<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $fillable = [
        'kategori_id',
        'user_id',
        'kode_produk',
        'nama_produk',
        'slug_produk',
        'deskripsi_produk',
        'foto',
        'qty',
        'satuan',
        'harga',
        'status',
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProdukImage', 'produk_id');
    }
}