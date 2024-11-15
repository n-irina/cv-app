<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Cv;
use Illuminate\Database\Seeder;

class CvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            'front-end web developer',
            'back-end web developer',
            'fullstack web developer',
        ];

        $contacts = Contact::inRandomOrder()->take(3)->get();

        foreach($titles as $key => $title){
            Cv::factory()->create([
                'title' => $title,
                'contact_id' => $contacts[$key]->id,
            ]);
        }


    }
}
