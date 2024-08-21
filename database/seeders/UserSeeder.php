<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'email'      => 'user@example.com',
                'password'   => null,
            ],
        ];

        $now = now();
        $password = \App::isProduction()
            ? '$2y$12$tX5sznSNwH9GHEPNV0w.Se07aoqiQv47WGQE0lN.gnUwvqLfe91aq' // php artisan hash
            : '$2y$12$tX5sznSNwH9GHEPNV0w.Se07aoqiQv47WGQE0lN.gnUwvqLfe91aq'; // password

        foreach ($seeds as $seed) {
            $seed['email_verified_at'] = $now;
            $seed['password'] ??= $password;
            $seed['remember_token'] = \Str::random(60);

            \App\Models\User::create($seed);
        }
    }
}
