<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingLogic extends Model
{
    use HasFactory;
    protected $fillable = [
        'jurisdiction','application_type','priority_fee',
        'base_fee','per_claim_fee','per_page_fee','per_drawing_fee','per_sequence_page_fee',
        'translation_fee','expedited_fee','tax_percentage',
        'status','claims_threshold','pages_threshold',
    ];
    protected $casts = [
    'base_fee'        => 'float',
    'claims_threshold'=> 'integer',
    'per_claim_fee'   => 'float',
    'pages_threshold' => 'integer',
    'per_page_fee'    => 'float',
    'per_drawing_fee' => 'float',
    'expedited_fee'   => 'float',
    'translation_fee' => 'float',
    'priority_fee'    => 'float',
    'tax_percentage'  => 'float',
     ];

}
