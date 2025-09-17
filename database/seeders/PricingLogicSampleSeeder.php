<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingLogic;

class PricingLogicSampleSeeder extends Seeder
{
    public function run()
    {
        PricingLogic::updateOrCreate([
            'region'=>'US','service'=>'pct_national_phase'
        ], [
            'country' => 'United States',
            'language' => 'English',
            'filing_fee' => 1200,
            'translation_fee' => 0,
            'official_fee' => 450,
            'excess_claim_fee' => 30,
            'claims_threshold' => 20,
            'excess_page_fee' => 5,
            'pages_threshold' => 25,
            'priority_fee' => 100,
            'priority_threshold' => 1,
            'drawing_fee_small' => 12,
            'drawing_small_threshold' => 0,
            'drawing_fee_large' => 25,
            'drawing_large_threshold' => 0,
            'per_sequence_page_fee' => 0,
            'special_rules' => null,
            'status' => 'active'
        ]);

        // Add one EU example
        PricingLogic::updateOrCreate([
            'region'=>'EU','service'=>'ep_validation'
        ], [
            'country' => 'Europe',
            'language' => 'English',
            'filing_fee' => 1450,
            'translation_fee' => 300,
            'official_fee' => 5370,
            'excess_claim_fee' => 0,
            'claims_threshold' => 45,
            'excess_page_fee' => 270,
            'pages_threshold' => 50,
            'priority_fee' => 0,
            'priority_threshold' => 0,
            'drawing_fee_small' => null,
            'drawing_small_threshold' => null,
            'drawing_fee_large' => null,
            'drawing_large_threshold' => null,
            'per_sequence_page_fee' => 0,
            'special_rules' => 'For Egypt apply 8x on certain charges (see notes)',
            'status' => 'active'
        ]);
    }
}
