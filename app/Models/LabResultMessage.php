<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResultMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'lab_result_id',
        'code',
        'content',
    ];
}
