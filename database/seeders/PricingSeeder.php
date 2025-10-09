<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class PricingSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(database_path('seeders/csv/ep.csv'), 'r');
        $csv->setHeaderOffset(0); // first row as header

        foreach ($csv as $record) {
            DB::table('pricing_logics')->insert([
                'region' => $record['region'] ?? null,
                'country' => $record['country'] ?? null,
                'language' => $record['langage'] ?? null,
                'translation' => $record['translation'] ?? null,
                'filing_fee' => $record['filing_fee'] ?: null,
                'official_fee' => $record['official_fee'] ?: null,
                'translation_fee' => $record['translation_fee'] ?: null,
                'service' => $record['service'] ?? null,
                
                'pages_threshold' => $record['pages_threshold'] ?: null,
                'excess_page_fee' => $record['excess_page_fee'] ?: null,
                
                'special_rules' => $record['special_rules'] ?? null,
            ]);
        }
    }
}
