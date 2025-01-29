<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_barang extends Model
{
    use HasFactory;

    protected $table = 'supplier_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'suppliers_id',
        'barangs_id',
        'harga_beli',
    ];
}
