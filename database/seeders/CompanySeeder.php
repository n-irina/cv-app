<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Enums\CompanyType;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            'SASU',
            'SAS',
            'SARL',
            'EURL',
            'EI',
        ];

        $type = CompanyType::cases();

        foreach ($status as $legalStatus) {
            $tags = Tag::inRandomOrder()->take(random_int(1,5))->get();
            $company = Company::factory()->create([
                    'legal_status' => $legalStatus,
                    'company_type' => $type[array_rand($type)]->value,
                ]);
            $company->attachTags($tags);
        }
    }
}
