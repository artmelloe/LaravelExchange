<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'boleto_fee' => 0.0145,
            'credit_card_fee' => 0.0763,
            'fee_amount_less' => 0.02,
            'fee_amount_less_value' => 3000,
            'fee_amount_greater' => 0.01,
            'fee_amount_greater_value' => 3000
        ]);
    }
}
