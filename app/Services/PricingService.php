<?php
namespace App\Services;

use App\Models\PricingLogic;
use App\Models\PricingLevel;
use App\Models\User;

class PricingService
{
    /**
     * Calculate a quote breakdown.
     *
     * $input = [
     *   'region','service','claims','pages','drawings','priority_count','word_count','small_drawings','large_drawings'
     * ]
     *
     * $user optional: to pull pf_level_id and tf_level_id defaults
     */
    public function calculate(array $input, ?User $user = null, ?array $overrideLevels = null)
    {
        $region = $input['region'] ?? null;
        $service = $input['service'] ?? null;
        $logic = PricingLogic::where('region',$region)->where('service',$service)->where('status','active')->first();

        if (!$logic) {
            return ['error' => 'No pricing logic defined for this region/service.'];
        }

        // determine PF level (patent filing) and TF level (translation)
        if ($overrideLevels) {
            $pfLevel = $overrideLevels['pf'] ?? null;
            $tfLevel = $overrideLevels['tf'] ?? null;
        } else {
            $pfLevel = $user && $user->pf_level_id ? PricingLevel::find($user->pf_level_id) : PricingLevel::where('kind','pf')->where('name','Level 1')->first();
            $tfLevel = $user && $user->tf_level_id ? PricingLevel::find($user->tf_level_id) : PricingLevel::where('kind','tf')->where('name','Level 1')->first();
        }

        $claims = (int)($input['claims'] ?? 0);
        $pages = (int)($input['pages'] ?? 0);
        $drawings = (int)($input['drawings'] ?? 0);
        $priorityCount = (int)($input['priority_count'] ?? 0);
        $wordCount = (int)($input['word_count'] ?? 0);
        $smallDrawings = (int)($input['small_drawings'] ?? 0);
        $largeDrawings = (int)($input['large_drawings'] ?? 0);

        // base fees from pricing_logic
        $filing = (float) $logic->filing_fee;
        $translation = (float) $logic->translation_fee;
        $official = (float) $logic->official_fee;

        // apply PF adjustment to filing fee
        if ($pfLevel) {
            $filing = round($filing * (1 + ($pfLevel->adjustment_percentage / 100)), 2);
        }

        // apply TF adjustment to translation fee (translation fee could be per word or flat)
        if ($tfLevel) {
            $translation = round($translation * (1 + ($tfLevel->adjustment_percentage / 100)), 2);
        }

        // extras: excess claims/pages
        $excessClaimsFee = 0.0;
        if ($logic->claims_threshold && $claims > $logic->claims_threshold) {
            $extraClaims = $claims - $logic->claims_threshold;
            $excessClaimsFee = $extraClaims * (float)$logic->excess_claims_fee;
        }

        $excessPagesFee = 0.0;
        if ($logic->pages_threshold && $pages > $logic->pages_threshold) {
            $extraPages = $pages - $logic->pages_threshold;
            $excessPagesFee = $extraPages * (float)$logic->excess_pages_fee;
        }

        $priorityExtraFee = 0.0;
        if ($logic->priority_threshold && $priorityCount > $logic->priority_threshold) {
            $extraPriorities = $priorityCount - $logic->priority_threshold;
            $priorityExtraFee = $extraPriorities * (float)$logic->priority_fee;
        }

        // drawing handling
        $drawingFees = 0.0;
        if ($logic->drawing_small_threshold !== null && $smallDrawings > $logic->drawing_small_threshold) {
            $drawingFees += ($smallDrawings - $logic->drawing_small_threshold) * (float)$logic->drawing_fee_small;
        }
        if ($logic->drawing_large_threshold !== null && $largeDrawings > $logic->drawing_large_threshold) {
            $drawingFees += ($largeDrawings - $logic->drawing_large_threshold) * (float)$logic->drawing_fee_large;
        }
        // if your sheet uses drawing count in drawings field, you can map small/large logic or treat drawings as small by default
        if (!$logic->drawing_small_threshold && $drawings>0 && $logic->drawing_fee_small) {
            $drawingFees += $drawings * (float)$logic->drawing_fee_small;
        }

        // translation variable: if translation fee is per-word, adjust by wordCount logic. For now assume translation_fee is per-page or flat
        // (If you have word-based fees in sheet, we will store per_word_translation_fee field and use it)
        // You can extend PricingLogic to have translation_per_word_fee if needed.

        // total before tax
        $subtotal = $filing + $translation + $official + $excessClaimsFee + $excessPagesFee + $priorityExtraFee + $drawingFees;

        // tax? Use percentage stored in pricing_logic (if present) or default 0%
        $taxPercent = (float)($logic->tax_percentage ?? 0);
        $tax = round($subtotal * ($taxPercent / 100), 2);

        $total = round($subtotal + $tax, 2);

        return [
            'breakdown' => [
                'filing' => $filing,
                'translation' => $translation,
                'official' => $official,
                'excess_claims' => $excessClaimsFee,
                'excess_pages' => $excessPagesFee,
                'priority_extra' => $priorityExtraFee,
                'drawing_fees' => $drawingFees,
                'subtotal' => round($subtotal,2),
                'tax' => $tax,
                'total' => $total,
                'pf_level' => $pfLevel ? $pfLevel->name : null,
                'tf_level' => $tfLevel ? $tfLevel->name : null,
            ],
            'pricing_logic' => $logic
        ];
    }
}
