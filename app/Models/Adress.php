<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $table = 'adresses';
    protected $fillable = [
        'postalCode',
        'street',
        'number',
        'neighborhood',
        'complement',
        'city',
        'state',
    ];

}
