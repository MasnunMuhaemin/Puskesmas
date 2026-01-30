<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = ['nama_obat', 'satuan', 'stok', 'harga'];

    public function reseps()
    {
        return $this->hasMany(Resep::class);
    }
}
