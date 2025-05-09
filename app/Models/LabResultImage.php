<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResultImage extends Model
{
    use HasFactory;

    protected $table = 'lab_result_images';

    protected $fillable = [
        'uid',
        'lab_result_id',
        'description',
        'file_path'
    ];
}
