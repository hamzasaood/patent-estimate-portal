<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id','service','region','application_type','jurisdiction',
    'application_number','reference_number','claims','pages',
    'drawings','sequence_pages','expedited','translation','priority',
    'title','applicant','priority_date','filing_date',
    'deadline_30m','deadline_31m','client_ref','emuna_ref',
    'fees_breakdown','special_instructions','attachment',
    'base_fee','extra_fee','tax','total','status','is_white_label','firm_fees','firm_logo','total_with_firm',
    'stripe_payment_intent','payment_status','stripe_session_id','filing_fee','translation_fee','official_fee','notes'
    ,'word_count','invoice_group','language',
];


protected $casts = [
    'priority_date' => 'date',
    'filing_date'   => 'date',
    'deadline_30m'  => 'date',
    'deadline_31m'  => 'date',
    'fees_breakdown'=> 'array',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Additional methods for business logic can be added here
}
