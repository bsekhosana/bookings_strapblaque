<?php

namespace Emotality\CRUD\Helpers;

use Illuminate\Database\Eloquent\Model;

class ModelColumns
{
    public static function columnsForModel(Model|string $model): array
    {
        $model = $model instanceof Model ? $model : \App::make('App\\Models\\'.$model);

        $table = $model->getTable();
        $schema = $model->getConnection()->getSchemaBuilder();
        $columns = $schema->getColumns($table);

        foreach ($columns as $column) {
            $properties[$column['name']] = $column;
        }

        return $properties ?? [];
    }
}
