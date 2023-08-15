<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enderecos extends Model
{
    use SoftDeletes;

    protected $table = 'enderecos';
    protected $fillable = [
        'cep',
        'logradouro',
        'bairro',
        'cidade',
        'uf',
    ];

}
