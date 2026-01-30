<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'pasien_id','poli_id','tanggal_daftar','status'
    ];

    protected $attributes = [
        'status' => 'menunggu',
    ];

    public function pasien() {
        return $this->belongsTo(Pasien::class);
    }

    public function poli() {
        return $this->belongsTo(Poli::class);
    }
}
