@task('init_production', ['on' => 'production', 'parallel' => true])
if [ ! -d {{ $deploy_path }}/shared/storage ]; then
    echo "Initializing production server.."
    mkdir -p {{ $deploy_path }}/shared
    cd {{ $deploy_path }}
    echo "Cloning branch '{{ $deploy_branch }}' from '{{ $deploy_repo }}'.."
    git clone {{ $deploy_repo }} --branch={{ $deploy_branch }} --depth=1 -q {{ $release_path }}
    echo "Creating storage directory.."
    mv {{ $release_path }}/storage {{ $deploy_path }}/shared/storage
    ln -s {{ $deploy_path }}/shared/storage {{ $release_path }}/storage
    echo "Creating .env file.."
    cp {{ $release_path }}/.env.example {{ $deploy_path }}/shared/.env
    ln -s {{ $deploy_path }}/shared/.env {{ $release_path }}/.env
    echo "Installing composer packages.."
    cd {{ $release_path }} && composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
    echo "Generating a key.."
    cd {{ $release_path }} && php artisan key:generate --quiet
    rm -rf {{ $release_path }}
    echo "Production server initialized successfully!"
    echo "Remember to edit '{{ $deploy_path }}/shared/.env' then run 'php artisan deploy' again!"
else
    echo "Production server already initialized!"
    echo "Double check '{{ $deploy_path }}/shared/.env' then run 'php artisan deploy' again!"
fi
@endtask

@task('init_staging', ['on' => 'staging', 'parallel' => true])
if [ ! -d {{ $deploy_path }}/shared/storage ]; then
    echo "Initializing staging server.."
    mkdir -p {{ $deploy_path }}/shared
    cd {{ $deploy_path }}
    echo "Cloning branch '{{ $deploy_branch }}' from '{{ $deploy_repo }}'.."
    git clone {{ $deploy_repo }} --branch={{ $deploy_branch }} --depth=1 -q {{ $release_path }}
    echo "Creating storage directory.."
    mv {{ $release_path }}/storage {{ $deploy_path }}/shared/storage
    ln -s {{ $deploy_path }}/shared/storage {{ $release_path }}/storage
    echo "Creating .env file.."
    cp {{ $release_path }}/.env.example {{ $deploy_path }}/shared/.env
    ln -s {{ $deploy_path }}/shared/.env {{ $release_path }}/.env
    echo "Installing composer packages.."
    cd {{ $release_path }} && composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
    echo "Generating a key.."
    cd {{ $release_path }} && php artisan key:generate --quiet
    rm -rf {{ $release_path }}
    echo "Staging server initialized successfully!"
    echo "Remember to edit '{{ $deploy_path }}/shared/.env' then run 'php artisan deploy' again!"
else
    echo "Staging server already initialized!"
    echo "Double check '{{ $deploy_path }}/shared/.env' then run 'php artisan deploy' again!"
fi
@endtask

@task('deployment_start')
if [ ! -f {{ $deploy_path }}/shared/.env ]; then
    echo "No .env file found at '{{ $deploy_path }}/shared/.env'!"
    exit 1
fi
echo "Deploying to '{{ $release_path }}'"
echo "Cloning branch '{{ $deploy_branch }}' from '{{ $deploy_repo }}'"
git clone {{ $deploy_repo }} --branch={{ $deploy_branch }} --depth=1 -q {{ $release_path }}
rm -rf {{ $release_path }}/storage
echo "Creating symlink for storage folder.."
ln -nfs {{ $deploy_path }}/shared/storage {{ $release_path }}/storage
echo "Creating symlink for .env file.."
ln -nfs {{ $deploy_path }}/shared/.env {{ $release_path }}/.env
@endtask

@task('deployment_composer')
echo "Installing composer packages.."
cd {{ $release_path }} && composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
@endtask

@task('deployment_npm')
echo "Installing npm packages.."
cd {{ $release_path }}
npm install --no-audit --no-fund --omit=dev
echo "Running npm prod.."
npm run prod --silent
@endtask

@task('deployment_migrate')
echo "Migrating the database.."
php {{ $release_path }}/artisan migrate --env={{ $env }} --force --quiet --no-interaction
@endtask

@task('deployment_optimize')
echo "Optimizing config and routes.."
rm -rf {{ $deploy_path }}/shared/storage/framework/views/*.php
php {{ $release_path }}/artisan config:prod --quiet
php {{ $release_path }}/artisan bootstrap:cache --quiet
@endtask

@task('deployment_geoip')
echo "Downloading the latest MaxMind GeoIP database.."
php {{ $release_path }}/artisan geoip:update --quiet --no-interaction
@endtask

@task('deployment_finish')
php {{ $release_path }}/artisan storage:link --quiet
echo "Creating symlink to current release.."
ln -nfs {{ $release_path }} {{ $deploy_path }}/current
@endtask

@task('deployment_fpm')
echo "Restarting PHP-FPM {{ $deploy_php_fpm }}.."
sudo service php{{ $deploy_php_fpm }}-fpm reload
@endtask

@task('deployment_horizon')
echo "Restarting Laravel Horizon.."
php {{ $release_path }}/artisan horizon:terminate --quiet
@endtask

@task('deployment_reverb')
echo "Restarting Laravel Reverb.."
php {{ $release_path }}/artisan reverb:restart --quiet
@endtask

@task('deployment_pulse')
echo "Restarting Laravel Pulse.."
php {{ $release_path }}/artisan pulse:restart --quiet
@endtask

@task('deployment_pm2')
echo "Restarting PM2 nodes.."
/usr/bin/pm2 restart all
@endtask

@task('deployment_cleanup')
cd {{ $deploy_path }}/releases
echo "Removing the oldest release.."
find . -maxdepth 1 -name "20*" | sort | head -n -{{ $keep_releases }} | xargs rm -Rf
@endtask

@task('deployment_rollback')
cd {{ $deploy_path }}/releases
ln -nfs {{ $deploy_path }}/releases/$(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1) {{ $deploy_path }}/current
echo "Rolled back to $(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1)"
@endtask

@after
if (in_array($task, ['init_production', 'init_staging'])) {
    echo "⚙️ \033[01;32m Initialized successfully! \033[0m".PHP_EOL;
} elseif ($task === 'deployment_cleanup') {
    echo sprintf("🚀 \033[01;32m Successfully deployed in %.2f seconds! \033[0m", (microtime(true) - $started_at)).PHP_EOL;
}
@endafter