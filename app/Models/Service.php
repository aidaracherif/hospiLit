<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        "nom",
        "nombreLit",
        "responsable",
        "etage",
        'description',
        'statut',
    ];

    public function hospitalizations()
{
    return $this->hasMany(Hospitalization::class);
}

}
