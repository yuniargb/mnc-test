<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Warna extends Model 
{
    /*
    |--------------------------------------------------------------------------
    | Setup Field Yang Ditampilkan
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'id_warna_produk','warna_produk','id_produk'
    ];
     /*
    |--------------------------------------------------------------------------
    | Setup Field Primary Key
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id_warna_produk';
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
