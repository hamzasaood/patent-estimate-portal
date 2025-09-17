<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\PricingLevel;

class PricingLevelsSeeder extends Seeder
{
    public function run()
    {
        // PF (filing) levels — use percentages from client:
        PricingLevel::updateOrCreate(['name'=>'Level 0','kind'=>'pf'], ['adjustment_percent'=>+5.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 1','kind'=>'pf'], ['adjustment_percent'=>0.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 2','kind'=>'pf'], ['adjustment_percent'=>-5.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 3','kind'=>'pf'], ['adjustment_percent'=>-10.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 4','kind'=>'pf'], ['adjustment_percent'=>-20.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 5','kind'=>'pf'], ['adjustment_percent'=>-30.00]);

        // TF (translation) levels — usually same mapping; if different you can change here
        PricingLevel::updateOrCreate(['name'=>'Level 0','kind'=>'tf'], ['adjustment_percent'=>+5.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 1','kind'=>'tf'], ['adjustment_percent'=>0.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 2','kind'=>'tf'], ['adjustment_percent'=>-5.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 3','kind'=>'tf'], ['adjustment_percent'=>-10.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 4','kind'=>'tf'], ['adjustment_percent'=>-20.00]);
        PricingLevel::updateOrCreate(['name'=>'Level 5','kind'=>'tf'], ['adjustment_percent'=>-30.00]);
    }
}
