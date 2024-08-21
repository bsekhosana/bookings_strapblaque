<?php

namespace Emotality\CRUD\Helpers;

use Barryvdh\Reflection\DocBlock;
use Barryvdh\Reflection\DocBlock\Context;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\ContextFactory;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionObject;
use ReflectionType;

class ModelRules
{
    private static array $rules = [];

    private static array $properties = [];

    private static array $nullable_columns = [];

    private static array $ignore_columns = [
        'id',
        'slug',
        'password',
        'tfa_otp',
        'api_token',
        'remember_token',
        'last_seen_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function rulesForModel(Model|string $model, array $columns = []): array
    {
        $model = $model instanceof Model ? $model : \App::make('App\\Models\\'.$model);

        $columns = empty($columns) ? ModelColumns::columnsForModel($model) : $columns;

        self::rulesFromTable($columns);
        self::rulesFromCasts($model);

        self::buildRulesArray();

        return self::$rules;
    }

    private static function rulesFromTable(array $columns): void
    {
        self::$rules = [];
        self::$properties = [];
        self::$nullable_columns = [];

        foreach ($columns as $name => $column) {
            if (in_array($name, self::$ignore_columns)) {
                continue;
            }

            self::$nullable_columns[$name] = $column['nullable'];

            self::$properties[$name] = [];
            self::$properties[$name]['column'] = $column;
            self::$properties[$name]['casts'] = [];
            self::$properties[$name]['rules'] = self::rulesFromColumn($column);
        }
    }

    private static function rulesFromColumn(array $column): array
    {
        $nullable_required = ($column['nullable'] ? 'nullable' : 'required');

        // Match types to Laravel validation rule equivalent
        $type = match ($column['type_name']) {
            'tinyint', 'smallint', 'mediumint', 'integer', 'int', 'bigint',
            'bit', 'int2', 'int4', 'int8' => 'integer',

            'boolean', 'bool' => 'boolean',

            'float', 'real', 'float4', 'double', 'float8' => 'numeric',

            'timestamp', 'datetime' => 'date_format:Y-m-d H:i',

            'date' => 'date_format:Y-m-d',

            'year' => 'date_format:Y',

            default => 'string',
        };

        return [$nullable_required, $type];
    }

    private static function rulesFromCasts(Model $model): void
    {
        $casts = $model->getCasts();

        foreach ($casts as $name => $type) {
            if (in_array($name, self::$ignore_columns)) {
                continue;
            }

            if (Str::startsWith($type, 'decimal:')) {
                $type = 'decimal';
            } elseif (Str::startsWith($type, 'custom_datetime:')) {
                $type = 'date';
            } elseif (Str::startsWith($type, 'date:')) {
                $type = 'date';
            } elseif (Str::startsWith($type, 'datetime:')) {
                $type = 'date';
            } elseif (Str::startsWith($type, 'immutable_custom_datetime:')) {
                $type = 'immutable_date';
            } elseif (Str::startsWith($type, 'immutable_date:')) {
                $type = 'immutable_date';
            } elseif (Str::startsWith($type, 'immutable_datetime:')) {
                $type = 'immutable_datetime';
            } elseif (Str::startsWith($type, 'encrypted:')) {
                $type = Str::after($type, ':');
            }

            $params = [];

            switch ($type) {
                case 'boolean':
                case 'bool':
                    $rule = 'boolean';
                    break;
                case 'decimal':
                case 'encrypted':
                case 'string':
                    $rule = 'string';
                    break;
                case 'array':
                case 'object':
                case 'json':
                case AsArrayObject::class:
                case AsCollection::class:
                case 'collection':
                    $rule = 'array';
                    break;
                case 'int':
                case 'integer':
                case 'timestamp':
                    $rule = 'integer';
                    break;
                case 'real':
                case 'double':
                case 'float':
                    $rule = 'numeric';
                    break;
                case 'date':
                case 'datetime':
                case 'immutable_date':
                case 'immutable_datetime':
                    $rule = 'date_format:Y-m-d H:i';
                    break;
                default:
                    // In case of an optional custom cast parameter , only evaluate the `$type` until the `:`
                    $type = strtok($type, ':');
                    $rule = class_exists($type) ? ('\\'.$type) : 'mixed';
                    $params = strtok(':');
                    $params = $params ? explode(',', $params) : [];
                    break;
            }

            if (! isset(self::$properties[$name])) {
                continue;
            }

            $cast = self::checkForCastableCasts($rule, $params);
            $cast = self::checkForCustomLaravelCasts($cast);
            $cast = self::applyNullability($cast, self::$nullable_columns[$name]);
            $cast = explode('|', $cast);

            self::$properties[$name]['casts'] = $cast;
        }
    }

    private static function checkForCastableCasts(string $type, array $params = []): string
    {
        if (! class_exists($type) || ! interface_exists(Castable::class)) {
            return $type;
        }

        $reflection = new ReflectionClass($type);

        if (! $reflection->implementsInterface(Castable::class)) {
            return $type;
        }

        $cast = call_user_func([$type, 'castUsing'], $params);

        if (is_string($cast) && ! is_object($cast)) {
            return $cast;
        }

        $castReflection = new ReflectionObject($cast);

        $methodReflection = $castReflection->getMethod('get');

        return self::getReturnTypeFromReflection($methodReflection)
            ?? self::getReturnTypeFromDocBlock($methodReflection, $reflection)
            ?? $type;
    }

    private static function checkForCustomLaravelCasts(string $type): ?string
    {
        if (! class_exists($type) || ! interface_exists(CastsAttributes::class)) {
            return $type;
        }

        $reflection = new ReflectionClass($type);

        if (! $reflection->implementsInterface(CastsAttributes::class)) {
            return $type;
        }

        $methodReflection = new \ReflectionMethod($type, 'get');

        $reflectionType = self::getReturnTypeFromReflection($methodReflection);

        if ($reflectionType === null) {
            $reflectionType = self::getReturnTypeFromDocBlock($methodReflection);
        }

        return $reflectionType;
    }

    private static function applyNullability(?string $type, bool $is_nullable): ?string
    {
        if (! $type) {
            return null;
        }

        $null_string = null;

        // Find instance of:
        // A) start of string or non-word character (like space or pipe) followed by 'null|'
        // B) '|null' followed by end of string or non-word character (like space or pipe)
        // This will find 'or null' instances at the beginning, middle or end of a type string,
        // but will exclude solo/pure null instances and null being part of a type's name (e.g. class 'Benull').
        if (preg_match('/(?:(?:^|\W)(null\|))|(\|null(?:$|\W))/', $type, $matches) === 1) {
            $null_string = array_pop($matches);
        }

        // Return the current type string if:
        // A) the type can be null and the type contains a null instance
        // B) the type can not be null and the type does not contain a null instance
        if (! ($is_nullable xor $null_string)) {
            return $type;
        }

        if ($is_nullable) {
            $type = 'nullable|'.$type;
        } else {
            $type = str_replace($null_string, '', $type);
        }

        return $type;
    }

    private static function getReturnTypeFromDocBlock(\ReflectionMethod $reflection, ?\Reflector $reflectorForContext = null): ?string
    {
        $phpDocContext = (new ContextFactory())->createFromReflector($reflectorForContext ?? $reflection);

        $context = new Context(
            $phpDocContext->getNamespace(),
            $phpDocContext->getNamespaceAliases()
        );

        $type = null;

        $phpdoc = new DocBlock($reflection, $context);

        if ($phpdoc->hasTag('return')) {
            $type = $phpdoc->getTagsByName('return')[0]->getType();
        }

        return $type;
    }

    private static function getReturnTypeFromReflection(\ReflectionMethod $reflection): ?string
    {
        if (! $returnType = $reflection->getReturnType()) {
            return null;
        }

        $types = self::extractReflectionTypes($returnType);

        $type = implode('|', $types);

        if ($returnType->allowsNull()) {
            $type = 'nullable|'.$type;
        }

        return $type;
    }

    private static function extractReflectionTypes(ReflectionType $reflection_type): array
    {
        $types = [];

        if ($reflection_type instanceof ReflectionNamedType) {
            $types[] = self::getReflectionNamedType($reflection_type);
        } else {
            foreach ($reflection_type->getTypes() as $named_type) {
                if ($named_type->getName() === 'null') {
                    continue;
                }

                $types[] = self::getReflectionNamedType($named_type);
            }
        }

        return $types;
    }

    private static function getReflectionNamedType(ReflectionNamedType $paramType): string
    {
        $parameterName = $paramType->getName();

        if (! $paramType->isBuiltin()) {
            $parameterName = '\\'.$parameterName;
        }

        return $parameterName;
    }

    private static function buildRulesArray(): void
    {
        foreach (self::$properties as $column => $property) {
            $rules = collect($property['rules'])->unique()->values()->toArray();
            $casts = collect($property['casts'])->unique()->values()->toArray();

            if ($cast_count = count($casts)) {
                if ($cast_count === 1 && $casts[0] == 'boolean') {
                    $rules = $casts;
                }

                if (($i = Arr::containIndex($casts, 'App\Enums')) !== false) {
                    $casts[$i] = sprintf('Rule::enum(%s::class)', $casts[$i]);
                }

                if (in_array('required', $rules) && ! in_array('required', $casts)) {
                    array_unshift($casts, 'required');
                }
            } else {
                $casts = $rules;
            }

            if ($casts != $rules) {
                if (in_array('mixed', $casts)) {
                    $rules = [''];
                } elseif (Arr::contains($rules, 'date_format:') && Arr::contains($casts, 'date_format:')) {
                    //$rules = $rules;
                } else {
                    $rules = $casts;
                }
            }

            self::$rules[$column] = self::addAdditionalRules($rules, $property['column']);
        }
    }

    private static function addAdditionalRules(array $property_rules, array $db_column): array
    {
        if ($db_column['type_name'] == 'varchar' && in_array('string', $property_rules)) {
            $max = str_replace(['varchar', '(', ')'], '', $db_column['type']);
            $property_rules[] = 'max:'.$max;
        }

        if (Str::contains($db_column['name'], 'email') && in_array('string', $property_rules)) {
            $property_rules[] = 'email';
        }

        if ($db_column['type_name'] == 'text' && in_array('string', $property_rules)) {
            $property_rules[] = 'max:64000';
        }

        if (Str::contains($db_column['name'], 'url') && in_array('string', $property_rules)) {
            $property_rules[] = 'url:https';
        }

        if ($db_column['type'] == 'tinyint(1)' && ! in_array('boolean', $property_rules)) {
            $property_rules[] = 'boolean';
        }

        if ($db_column['type_name'] == 'enum' && ! Arr::contains($property_rules, 'App\Enums')) {
            $opt_string = str_replace(["enum('", "')"], '', $db_column['type']);
            $options = explode("','", $opt_string);
            $property_rules[] = 'in:'.implode(',', $options);
        }

        if ($db_column['type_name'] == 'char' && in_array('string', $property_rules)) {
            $max = str_replace(['char(', ')'], '', $db_column['type']);
            $property_rules[] = 'max:'.$max;
        }

        return $property_rules;
    }
}
