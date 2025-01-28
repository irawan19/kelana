<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penawaran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'penawarans';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no',
        'nama',
        'perusahaan',
        'alamat',
        'cp',
        'kontak_cp'
    ];
}
