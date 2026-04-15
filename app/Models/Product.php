<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Auditable;

    public $timestamps = false;

    // @use HasFactory<\Database\Factories\ProductsFactory>
    protected $fillable = ['sku', 'nama_obat', 'stock', 'kategori', 'purchase_price', 'selling_price', 'golongan', 'satuan', 'kadaluarsa'];
        
    // Relasi: Satu produk bisa muncul di banyak detail penjualan
    public function saleDetails()
    {
        return $this->hasMany(SaleItem::class);
    }
}
