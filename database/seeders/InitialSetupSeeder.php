<?php

namespace Database\Seeders;

use App\Models\RateVat;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        RateVat::updateOrCreate(
            ['rate' => 24],
            ['name' => '24% Φ.Π.Α',
                'default' => true,'seed'=> true]
        );



    }
}
