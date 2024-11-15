<?php

namespace Database\Seeders;

use App\Enums\MediaType;
use App\Models\Contract;
use App\Models\Cv;
use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cvs = [
            [
                'title' => 'CV front end developer',
                'path' => ['media/CV_front_end.pdf'],
            ],
            [
                'title' => 'CV back end developer',
                'path' => ['media/CV_back_end.pdf'],
            ],
            [
                'title' => 'CV fullstack developer',
                'path' => ['media/CV_fullstack.pdf'],
            ],
        ];

        $contracts = [
            [
                'title' => 'Long contract',
                'path' => ['media/CDI.pdf'],
            ],
            [
                'title' => 'Short contract',
                'path' => ['media/CDD.pdf'],
            ],
            [
                'title' => 'Ponctual contract',
                'path' => ['media/Extra.pdf'],
            ],
        ];

        $resume = Cv::all();

        $allContract = Contract::all();

        foreach($cvs as $key => $cv){
            Media::factory()->create([
                'title' => $cv['title'],
                'type' => MediaType::Resume->value,
                'media_path' => $cv['path'],
                'cv_id' => $resume[$key]->id,
            ]);
        }

        foreach($contracts as $key => $contract){
            Media::factory()->create([
                'title' => $contract['title'],
                'type' => MediaType::Contract->value,
                'media_path' => $contract['path'],
                'contract_id' => $allContract[$key]->id,
            ]);
        }
    }
}
