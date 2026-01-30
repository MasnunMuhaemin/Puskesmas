<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $fillable = ['rekam_medis_id', 'obat_id', 'jumlah', 'aturan_pakai'];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
