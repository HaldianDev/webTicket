<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanComment extends Model
{
    protected $table = 'pengaduan_comments';

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'message',
    ];

    public $timestamps = true;

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
