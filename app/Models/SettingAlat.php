<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAlat extends Model
{
    use HasFactory;

    protected $table = 'setting_alats';

    protected $fillable = [
        'uid',
        'name',
        'ip_address',
        'port',
        'status',
        'last_connected_at',
        'auto_connect',
        'created_at',
        'updated_at',
    ];
}
