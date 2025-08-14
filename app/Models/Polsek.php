<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polsek extends Model
{
    protected $table = 'polsek';

    protected $fillable = [
        'polres_id',
        'nama',
        'stok_beras',
        'distribusi_beras',
    ];
    // Relasi Polsek ke satu Polres
    public function polres()
    {
        return $this->belongsTo(Polres::class, 'polres_id');
    }

    public function userProfiles()
{
    return $this->hasMany(UserProfile::class, 'polsek_id');
}
}
