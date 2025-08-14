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

    public function user()
{
    return $this->belongsTo(User::class, 'created_by');
}
}
