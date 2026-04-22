<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'filename',
        'filepath',
        'filesize_kb',
        'country_name',
        'country_code',
        'currency_name',
        'currency_code',
        'currency_symbol',
        'flag',
    ];
}
