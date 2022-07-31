<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model 
{
    /*
    |--------------------------------------------------------------------------
    | Setup Field Yang Ditampilkan
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'id_gambar_produk','gambar_produk','id_produk'
    ];
     /*
    |--------------------------------------------------------------------------
    | Setup Field Primary Key
    |--------------------------------------------------------------------------
    */
    protected $primaryKey = 'id_gambar_produk';
     /*
    |--------------------------------------------------------------------------
    | Setup Format Data
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];

    protected $appends = ['url_gambar'];

    public function getUrlGambarAttribute()
    {   
        return asset('images/'.$this->attributes['gambar_produk']);
    }
}
