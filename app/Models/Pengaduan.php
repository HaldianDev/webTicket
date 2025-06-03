<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduans';

    protected $fillable = [
        'user_id',
        'ticket_number',
        'jenis_laporan',
        'kategori',
        'keterangan',
        'nik',
        'type',
        'file_path',
        'status',
    ];

    public $timestamps = true;

      // Relasi ke User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(\App\Models\Layanan::class);
    }

    public function comments()
    {
        return $this->hasMany(PengaduanComment::class);
    }

}
