<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{
    /*
    |--------------------------------------------------------------------------
    | Setup Field Yang Ditampilkan
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'id_produk','nama_produk','kategori','deskripsi'
    ];
     /*
    |--------------------------------------------------------------------------
    | Setup Field Primary Key
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id_produk';
    /*
    |--------------------------------------------------------------------------
    | Setup Format Data
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];
}
