<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingLevel extends Model
{
    use HasFactory;
    protected $fillable = ['region','level','adjustment_percent','kind','notes','name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
