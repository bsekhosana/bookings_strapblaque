<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * These are used for humanDate() and
     * humanDateTime() blade directives.
     *
     * @var array<string, mixed>
     */
    private static array $settings = [
        [
            'type'     => \Settings::STRING,
            'key'      => 'date_format',
            'value'    => 'D, j M Y',
            'comment'  => 'The date format dates should be displayed in.',
            'editable' => true,
        ],
        [
            'type'     => \Settings::STRING,
            'key'      => 'datetime_format',
            'value'    => 'D, j M Y, H:i',
            'comment'  => 'The datetime format dates should be displayed in.',
            'editable' => true,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = array_merge(self::$settings, [
            //[
            //    'type'     => \Settings::,
            //    'key'      => '',
            //    'value'    => '',
            //    'comment'  => '',
            //    'editable' => true,
            //],
        ]);

        foreach ($seeds as $seed) {
            \App\Models\Setting::create($seed);
        }
    }
}
