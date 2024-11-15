<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = ['symfony', 'laravel', 'filament', 'vue.js', 'node.js', 'react', 'php', 'mySql', 'html', 'css'];

        foreach($technologies as $tech){
            Tag::create(['name' => $tech,
                         'slug' => $tech,
                         'type' => 'technologies',
            ]);
        }

    }
}
