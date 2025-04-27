<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    //
    protected $table = "personnel";
    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'tel',
        'email',
        'adresse',
        'serviceId',
        'role'
    ];
}
