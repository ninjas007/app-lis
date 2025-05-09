<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'medical_record_number',
        'name',
        'birth_date',
        'gender',
    ];

    public function labResults()
    {
        return $this->hasMany(LabResult::class, 'patient_id', 'id');
    }

}
