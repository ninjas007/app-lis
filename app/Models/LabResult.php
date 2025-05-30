<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'patient_id',
        'lab_number',
        'doctor',
        'department',
        'sample_taken_at',
        'result_at',
        'test_type',
        'created_at',
        'updated_at',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function details()
    {
        return $this->hasMany(LabResultDetail::class);
    }

    public function resultImages()
    {
        return $this->hasMany(LabResultImage::class);
    }

    public function messages()
    {
        return $this->hasMany(LabResultMessage::class);
    }
}
