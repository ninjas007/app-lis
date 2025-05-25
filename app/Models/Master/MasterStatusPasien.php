<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStatusPasien extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'master_status_pasiens';

    protected $fillable = [
        'uid',
        'name',
        'description'
    ];
}
