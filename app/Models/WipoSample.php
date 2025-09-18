<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipoSample extends Model
{
    use HasFactory;

    protected $fillable = ['application_country','application_number','application_date'
    ,'priority_date','applicant','language','page_count', 'claims_count','claims_raw','office','report_date','drawings_count'
    ,'title','priority_ref','publication_number'];

}
