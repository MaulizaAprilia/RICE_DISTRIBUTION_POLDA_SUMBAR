<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';

    protected $fillable = [
        'polres_id',
        'polsek_id',
        'sumber_beras',
        'stok_awal',
        'distribusi_beras',
        'stok_sisa',
        'created_at'
    ];

    public $timestamps = false; // pakai kolom created_at bawaan MySQL, bukan Laravel

    // Relasi ke tabel Polres
    public function polres()
    {
        return $this->belongsTo(Polres::class, 'polres_id');
    }

    // Relasi ke tabel Polsek
    public function polsek()
    {
        return $this->belongsTo(Polsek::class, 'polsek_id');
    }
}