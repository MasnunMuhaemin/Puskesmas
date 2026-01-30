<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
   protected $fillable = [
        'pasien_id','dokter_id','keluhan',
        'diagnosa','tindakan','tanggal_periksa'
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
    ];

    public function pasien() {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter() {
        return $this->belongsTo(Dokter::class);
    }

    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }
}
