<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'admin@example.com',
                'mobile'     => '0820001234',
                'password'   => null,
            ],
        ];

        $now = now();
        $password = \App::isProduction()
            ? '$2y$12$tX5sznSNwH9GHEPNV0w.Se07aoqiQv47WGQE0lN.gnUwvqLfe91aq' // php artisan hash
            : '$2y$12$tX5sznSNwH9GHEPNV0w.Se07aoqiQv47WGQE0lN.gnUwvqLfe91aq'; // password

        foreach ($seeds as $seed) {
            $seed['super_admin'] = 1;
            $seed['email_verified_at'] = $now;
            $seed['password'] ??= $password;

            \App\Models\Admin::create($seed);
        }
    }
}
