@include('vendor/autoload.php')
@include('bootstrap/app.php')

@php
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\RegisterFacades;

(new LoadConfiguration())->bootstrap($app);
(new RegisterFacades())->bootstrap($app);

// Deploy Config
$config = config('deploy');
$deploy_repo = $config['repo'];
$deploy_branch = $config['branch'];
$deploy_ssh_key = $config['ssh_key'];
$deploy_php_fpm = $config['php_fpm'];
$deploy_servers = $config['servers'];

// Create/add servers in an SSH form
foreach ($deploy_servers as $environment => $env_servers) {
    foreach ($env_servers as $server) {
        $servers[$environment][] = sprintf('-i %s %s@%s -p %d', $deploy_ssh_key, $server['user'], $server['host'], $server['port']);
    }
}

// Arguments
$env ??= 'staging';
if (! in_array($env, ['staging', 'production'])) {
    throw new Exception('Invalid environment specified! Valid: staging, production');
}

// Variables
$date = now()->format('YmdHis');
$deploy_path = $deploy_servers[$env][0]['path'] ?? '/var/www';
$deploy_path = '/'.rtrim(ltrim($deploy_path, '/'), '/');
$release_path = $deploy_path.'/releases/'.$date;
$keep_releases = $config['keep_releases'];
$started_at = microtime(true);
@endphp

@servers($servers)

@php
/*
|--------------------------------------------------------------------------
| Deployer Tasks
|--------------------------------------------------------------------------
|
| deployment_start    : Clone project, symlink storage folder and .env file
| deployment_composer : Install composer packages
| deployment_npm      : Install npm packages and run npm run prod
| deployment_migrate  : Run database migrations
| deployment_optimize : Cache routes, config and views (artisan optimize)
| deployment_geoip    : Download the latest MaxMind GeoIP database
| deployment_finish   : Create the "current" folder symlink for latest release
| deployment_fpm      : Reload the php-fpm service
| deployment_horizon  : Restart Laravel Horizon (artisan horizon:terminate)
| deployment_reverb   : Restart Laravel Reverb (artisan reverb:restart)
| deployment_pulse    : Restart Laravel Pulse (artisan pulse:restart)
| deployment_pm2      : Restart PM2 nodes (JS process manager)
| deployment_cleanup  : Delete the oldest release and only keep 5 releases
|
*/
@endphp

@story('deploy_production', ['on' => 'production', 'parallel' => true])
deployment_start
deployment_composer
deployment_migrate
deployment_optimize
deployment_finish
deployment_fpm
deployment_horizon
deployment_pulse
deployment_cleanup
@endstory

@story('deploy_staging', ['on' => 'staging', 'parallel' => true])
deployment_start
deployment_composer
deployment_migrate
deployment_optimize
deployment_finish
deployment_fpm
deployment_horizon
deployment_pulse
deployment_cleanup
@endstory

@story('rollback')
deployment_rollback
@endstory

@import('repositories/deployer/envoy_tasks.blade.php')
