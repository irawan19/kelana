<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran_barang extends Model
{
    use HasFactory;

    protected $table = 'penawaran_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'barangs_id',
        'harga',
    ];
}
