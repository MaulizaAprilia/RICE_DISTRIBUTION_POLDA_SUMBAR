<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile'; // Kalau nama tabel bukan jamak
    protected $fillable = [
        'user_id',
        'polres_id',
        'polsek_id',
        'nrp',
        'pangkat',
        'jabatan',
        'foto_ktp',
        'foto_wajah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Polsek
    public function polsek()
    {
        return $this->belongsTo(Polsek::class, 'polsek_id');
    }

    // Relasi ke Polres
    public function polres()
    {
        return $this->belongsTo(Polres::class, 'polres_id');
    }
}
