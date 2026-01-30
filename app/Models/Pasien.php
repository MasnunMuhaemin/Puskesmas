<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'nama','nik','alamat','tanggal_lahir'
    ];

    public function pendaftarans() {
        return $this->hasMany(Pendaftaran::class);
    }

    public function rekamMedis() {
        return $this->hasMany(RekamMedis::class);
    }
}
