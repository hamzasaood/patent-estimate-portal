<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id','firm_id','application_type','jurisdiction','application_number',
    'claims','pages','drawings','sequence_pages',
    'expedited','translation','priority',
    'title','applicant','priority_date','filing_date',
    'deadline_30m','deadline_31m','client_ref','emuna_ref',
    'fees_breakdown',
    'base_fee','extra_fee','tax','total',
    'firm_logo','firm_fees','total_with_firm','is_white_label','status'
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
