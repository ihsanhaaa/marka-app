<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiMarka extends Model
{
    use HasFactory;

    protected $table = 'kondisi_markas';
    protected $guarded = ['id'];
}
