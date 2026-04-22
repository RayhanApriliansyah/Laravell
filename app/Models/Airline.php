<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'code',
        'name',
        'country_id',
        'type',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
