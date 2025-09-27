<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class PricingSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(database_path('seeders/csv/pricing.csv'), 'r');
        $csv->setHeaderOffset(0); // first row as header

        foreach ($csv as $record) {
            DB::table('pricing_logics')->insert([
                'region' => $record['region'] ?? null,
                'country' => $record['country'] ?? null,
                'language' => $record['langage'] ?? null,
                'filing_fee' => $record['filing_fee'] ?: null,
                'official_fee' => $record['official_fee'] ?: null,
                'translation_fee' => $record['translation_fee'] ?: null,
                'service' => $record['service'] ?? null,
                'claims_threshold' => $record['claims_threshold'] ?: null,
                'excess_claim_fee' => $record['excess_claim_fee'] ?: null,
                'pages_threshold' => $record['pages_threshold'] ?: null,
                'excess_page_fee' => $record['excess_page_fee'] ?: null,
                'priority_threshold' => $record['priority_threshold'] ?: null,
                'priority_fee' => $record['priority_fee'] ?: null,
                'entity' => $record['entity'] ?? null,
                'special_rules' => $record['special_rules'] ?? null,
            ]);
        }
    }
}
