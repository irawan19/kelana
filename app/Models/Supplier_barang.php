<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier_barang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplier_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'suppliers_id',
        'barangs_id',
        'harga_beli',
    ];
}
