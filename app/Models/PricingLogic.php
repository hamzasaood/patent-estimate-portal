<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingLogic extends Model
{
    use HasFactory;
    protected $fillable = [
    'region','country','language','service',
    'filing_fee','translation_fee','official_fee',
    'excess_claim_fee','claims_threshold','excess_page_fee','pages_threshold',
    'priority_fee','priority_threshold',
    'drawing_fee_small','drawing_small_threshold','drawing_fee_large','drawing_large_threshold',
    'per_sequence_page_fee','special_rules','status'
];

protected $casts = [
    'filing_fee' => 'float',
    'translation_fee' => 'float',
    'official_fee' => 'float',
    'excess_claim_fee' => 'float',
    'claims_threshold' => 'integer',
    'excess_page_fee'=> 'float',
    'pages_threshold'=> 'integer',
    'priority_fee' => 'float',
    'priority_threshold'=> 'integer',
    'drawing_fee_small' => 'float',
    'drawing_small_threshold' => 'integer',
    'drawing_fee_large' => 'float',
    'drawing_large_threshold' => 'integer',
    'per_sequence_page_fee' => 'float',
];


}
