<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = "personnels";
    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'tel',
        'email',
        'adresse',
        'serviceId',
        'role',
        'statut',
        'password',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceId');
    }
}
