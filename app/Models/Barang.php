<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kategoris_id',
        'tipes_id',
        'nama',
        'harga',
        'stok',
    ];
}
