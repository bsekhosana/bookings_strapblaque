<?php

use Illuminate\Support\Facades\Artisan;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;use function Laravel\Prompts\password;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/**
 * Custom
 */
//Artisan::command('example:test', function () {
//    $this->comment('Orange text');
//    $this->info('Green text');
//})->purpose('');

/**
 * Optimization & Clearing/Flushing
 */
Artisan::command('ide', function () {
    $this->callSilently('ide-helper:generate');
    $this->callSilently('ide-helper:meta');
    $this->callSilently('ide-helper:models', ['--nowrite', '--no-interaction']);
    info('Generated IDE helper files.');
})->purpose('Generate IDE helper files');

Artisan::command('format', function () {
    exec('./vendor/bin/pint --quiet');
    info('Formatted code to the Laravel coding standard.');
})->purpose('Clean and format code to the Laravel coding standard');

Artisan::command('logs:clear', function () {
    exec('rm -f '.storage_path('logs/*.log'));
    exec('rm -f '.base_path('*.log'));
    exec('rm -f '.base_path('*.cache'));
    info('Cleared log files.');
})->purpose('Clear log files');

Artisan::command('bootstrap:cache', function () {
    $this->callSilently('bootstrap:clear');
    $this->callSilently('package:discover');
    $this->callSilently('config:cache');
    $this->callSilently('route:cache');
    $this->callSilently('view:cache');
    $this->callSilently('event:cache');
    $this->info('Bootstrap files cached successfully.');
})->purpose('Cached bootstrap files');

Artisan::command('bootstrap:clear', function () {
    $this->callSilently('event:clear');
    $this->callSilently('view:clear');
    $this->callSilently('route:clear');
    $this->callSilently('config:clear');
    $this->callSilently('clear-compiled');
    $this->info('Bootstrap caches cleared successfully.');
})->purpose('Remove the cached bootstrap files');

Artisan::command('flush', function () {
    if (confirm('Migrate fresh and seed the database?', false)) {
        $this->call('migrate:fresh', ['--seed']);
        info('Migrated fresh and seeded the database.');
    }
    $this->call('redis:flush');
    $this->call('logs:clear');
    $this->call('ide');
    $this->call('format');
    warning('Testing routes/config optimization for production...');
    $this->callSilently('bootstrap:cache');
    sleep(1);
    $this->callSilently('bootstrap:clear');
    $this->callSilently('package:discover');
})->purpose('Flush cache, views and logs');

Artisan::command('redis:flush', function () {
    try {
        $redis = new Redis();
        $redis->connect(config('database.redis.cache.host'));
        $prefix = config('database.redis.options.prefix');
        $names = [
            0 => 'cache',
            //1 => 'cache', // Add this to also flush sessions
            2 => 'horizon',
            3 => '*',
        ];

        foreach ($names as $db => $name) {
            $redis->select($db);
            $iterator = null;
            while (false !== ($keys = $redis->scan($iterator, sprintf('%s%s:*', $prefix, $name)))) {
                foreach ($keys as $key) {
                    $redis->del($key);
                }
            }
        }
        info('Flushed project Redis data.');
    } catch (\Exception $exception) {
        $this->error('You either don\'t have Redis extension installed or not using Redis');
    }
})->purpose('Flush project Redis data');

Artisan::command('config:prod', function () {
    $dev_configs = [
        'debugbar.php',
        'flare.php',
        'ide-helper.php',
        'ignition.php',
        'ray.php',
        'telescope.php', // Remove this line if you're planning on using Laravel Telescope in production environment!
        'telescope-toolbar.php',
    ];
    foreach ($dev_configs as $config) {
        exec(sprintf('rm -f %s', config_path($config)));
    }
})->purpose('Delete unnecessary config files for prod');

/**
 * Passwords & Hashing
 */
Artisan::command('hash {password?} {--R|rounds= : Amount of bcrypt rounds}', function () {
    $password = $this->argument('password') ?? password('Password to hash? (bcrypt)', 'Plain text password', true);
    warning('e.g. 12 ==> 2 to the power of 12 = 4,096 iterations');
    $rounds = $this->option('rounds') ?? text(
        label: 'Bcrypt rounds?',
        placeholder: '12',
        default: config('hashing.bcrypt.rounds', 12),
        required: true,
        validate: fn ($value) => match (true) {
            (intval($value) < 4 || intval($value) > 20) => 'Needs to be a number between 4 and 20.',
            default => null,
        },
        hint: 'The higher the better, but at a cost of more resources.'
    );
    $start = microtime(true);
    $hashed = bcrypt($password, compact('rounds'));
    warning(sprintf('%s iterations in %.3f seconds', number_format(pow(2, intval($rounds))), (microtime(true) - $start)));
    info($hashed);
    if (confirm('Show plain text password?', false)) {
        $this->info($password);
    }
})->purpose('Generate hashed password from plain text');

Artisan::command('bcrypt {--R|rounds= : Amount of bcrypt rounds}', function () {
    $rounds = $this->option('rounds') ?? config('hashing.bcrypt.rounds');
    $rounds = $rounds < 4 ? 4 : $rounds;
    $rounds = $rounds > 20 ? 20 : $rounds;
    $this->info(sprintf('Benchmarking %d bcrypt rounds:', $rounds));
    $total = 0;
    for ($x = 0; $x < 10; $x++) {
        $start = microtime(true);
        $password = bcrypt(\Str::password(16), compact('rounds'));
        $duration = (microtime(true) - $start);
        $total += ($duration * 1000);
        $this->info(sprintf('%s in %.3f seconds', $password, $duration));
    }
    $this->info(sprintf('Average: %.0fms', ($total / 10)));
})->purpose('Benchmark bcrypt hashing');

/**
 * Users & Admins
 */
Artisan::command('make:user', function () {
    $first_name = text('First Name');
    $last_name = text('Last Name');
    $email = text('Email Address');
    $password = password('Password');
    $password = \Hash::make($password);
    $user = \App\Models\User::create(compact('first_name', 'last_name', 'email', 'password'));
    $this->comment(json_encode($user->fresh()->makeVisible(['api_token']), 128));
    $user->forceFill(['email_verified_at' => now()])->saveQuietly();
})->purpose('Create a new User');

Artisan::command('make:admin', function () {
    $first_name = text('First Name');
    $last_name = text('Last Name');
    $email = text('Email Address');
    $mobile = text('Mobile Number (OTP)');
    $password = password('Password');
    $password = \Hash::make($password);
    $admin = \App\Models\Admin::create(compact('first_name', 'last_name', 'email', 'mobile', 'password'));
    $this->comment(json_encode($admin->fresh()->makeVisible(['api_token']), 128));
})->purpose('Create a new Admin');
