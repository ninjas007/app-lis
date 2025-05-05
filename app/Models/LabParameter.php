<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'loinc_code',
        'default_unit',
        'default_ref_range',
    ];
}
