<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLocations extends Model
{

    protected $fillable = [
        'name', 'address_1', 'address_2','postal_code','pictures',
    ];


    protected $casts=[

        'pictures'=>'array',


    ];






}
