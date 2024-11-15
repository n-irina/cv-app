<?php

namespace Database\Seeders;

use App\Enums\ContractType;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ContractType::cases();

        foreach($types as $type){

            $contacts = Contact::inRandomOrder()->take(random_int(1, 5))->get();

            Contract::factory()->create([
                'type' => $type->value,
                'signatories' => $contacts->pluck('full_name'),
            ]);
        }
    }
}
