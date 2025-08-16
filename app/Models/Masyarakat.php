<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    protected $table = 'masyarakat';

    protected $fillable = [
        'polres_id',
        'polsek_id',
        'created_by',
        'foto_ktp',
        'jumlah_beras',
    ];

    // Relasi ke User
    public function user()
    {
        // pastikan 'created_by' adalah foreign key ke users.id
        return $this->belongsTo(User::class, 'created_by');
    }
}
