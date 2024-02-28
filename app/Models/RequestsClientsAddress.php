<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsClientsAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'state',
        'country',
        'complement',
        'number',
        'neighborhood',
        'addressline',
        'addressline2',
        'zipcode',
    ];
}