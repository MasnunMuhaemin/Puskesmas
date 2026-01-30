<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = ['nama', 'spesialis', 'poli_id'];

    public function poli() {
        return $this->belongsTo(Poli::class);
    }
}
