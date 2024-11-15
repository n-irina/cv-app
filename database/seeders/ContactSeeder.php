<?php

namespace Database\Seeders;

use App\Enums\ContactProfil;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profil = ContactProfil::cases();

        $companies = Company::all();

        foreach($companies as $company){
            Contact::factory()->create([
                'company_id' => $company -> id,
                'profil' => $profil[array_rand($profil)]->value,
            ]);
        }

    }
}
