<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model 
{
    /*
    |--------------------------------------------------------------------------
    | Setup Field Yang Ditampilkan
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'id_harga_produk','harga_produk','ukuran_produk','id_produk'
    ];
     /*
    |--------------------------------------------------------------------------
    | Setup Field Primary Key
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id_harga_produk';
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
