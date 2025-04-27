<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    //
    protected $fillable = [
        'nom',
        'prenom',
        'dateNaissance',
        'genre',
        'groupeSanguin',
        'tel',
        'email',
        'adresse',
        
    ];
    public function patient()
    {
        return $this->belongsTo(Lit::class, 'litId');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceId');
    }
    public function lit()
    {
        return $this->belongsTo(Lit::class, 'litId');
    }

    
    protected $dates = ['dateNaissance'];
    
    // Accesseur pour calculer l'âge
    public function getAgeAttribute()
    {
        return $this->dateNaissance ? Carbon::parse($this->dateNaissance)->age : null;
    }
    public function hospitalizations()
    {
        return $this->hasMany(Hospitalization::class);
    }

}
