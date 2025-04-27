<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lit;
use App\Models\Service;
use App\Models\Patient;

class Hospitalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'serviceId',
        'litId',
        'dateAdmission',
        'dateSortie',
        'noteMedical',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
{
    return $this->belongsTo(Service::class, 'serviceId');
}


    public function lit()
    {
        return $this->belongsTo(Lit::class, 'litId');
    }
}
