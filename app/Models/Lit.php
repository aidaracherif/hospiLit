<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lit extends Model
{
    //
    protected $fillable = [
        'numero',
        'serviceId',
        'etage',
        'status',
        'dateOccupation',
    ];
    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array
     */
    protected $casts = [
        'dateOccupation' => 'date',
    ];

    /**
     * Relation avec le service
     */
    // public function service()
    // {
    //     return $this->belongsTo(Service::class);
    // }

    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceId');
    }

    public function hospitalizations()
    {
        return $this->hasMany(Hospitalization::class);
    }


    /**
     * Accesseur pour obtenir la couleur du badge selon le statut
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'Disponible':
                return 'success';
            case 'Occupé':
                return 'danger';
            case 'En maintenance':
                return 'warning';
            default:
                return 'secondary';
        }
    }
}
