<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polres extends Model
{
    protected $table = 'polres';

    protected $fillable = [
        'nama',
        'stok_beras',
        'distribusi_beras',
    ];

    // Relasi Polres ke banyak Polsek
    public function polseks()
    {
        return $this->hasMany(Polsek::class, 'polres_id');
    }

    public function userProfiles()
{
    return $this->hasMany(UserProfile::class, 'polres_id');
}
}
