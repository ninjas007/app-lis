<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienHasilDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'patient_id',
        'hasil_id',
        'diagnosa',
        'catatan',
        'dokter_pengirim',
        'dokter_penanggung_jawab',
        'ruangan_poli',
        'petugas',
        'verifikasi',
        'status',
        'jenis_layanan',
        'created_at',
        'updated_at'
    ];
}
