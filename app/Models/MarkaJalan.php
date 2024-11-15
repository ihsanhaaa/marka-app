<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkaJalan extends Model
{
    use HasFactory;

    protected $table = 'marka_jalans';
    protected $guarded = ['id'];

    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function statuses()
    {
        return $this->hasMany(KondisiMarka::class);
    }

    public function statusMarkaTerbaru()
    {
        return $this->hasOne(KondisiMarka::class)->latestOfMany();
    }
}
