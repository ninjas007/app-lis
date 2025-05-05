<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResultDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_result_id',
        'lab_parameter_id',
        'result_value',
        'unit',
        'reference_range',
        'result_date',
    ];

    public function labParameter()
    {
        return $this->belongsTo(LabParameter::class);
    }
}
