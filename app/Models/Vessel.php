<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;
    protected $table = 'vessels';


    protected $fillable = ['name', 'imo', 'country_id', 'logo'];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
