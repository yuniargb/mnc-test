<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use IIlluminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Gambar;
use App\Models\Warna;
use App\Models\Harga;
use Validator;
use DataTables;

class ProductController extends Controller
{   
    public function index(Request $request){
        $data = Product::select('id_produk','nama_produk','kategori','deskripsi')
            ->when( $request->search['value'], function ($query)  use ($request){
            // return $query->where('products.nama_produk', 'like', '%'.$request->search.'%');
        })
        ->get();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-detail" data-id="'.encrypt($row->id_produk).'">Detail</a>';
                $btn .= '<a href="javascript:void(0)" class="btn btn-info btn-sm btn-update" data-id="'.encrypt($row->id_produk).'">Update</a>';
                $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="'.encrypt($row->id_produk).'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function find($id){
        $id_produk = decrypt($id);
        $produk = Product::find($id_produk);
        if($produk){
            $gambar =  Gambar::where('id_produk',$id_produk)->get();
            $warna =  Warna::where('id_produk',$id_produk)->get();
            $harga =  Harga::where('id_produk',$id_produk)->get();

            return response()->json([
                'result' => true,
                'message' => 'data found',
                'data' => [
                    'produk' => $produk,
                    'gambar' => $gambar,
                    'warna' => $warna,
                    'harga' => $harga,
                ]
            ]);   

        }else{
            return response()->json([
                'result' => false,
                'message' => 'data not found'
            ]);   
        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'nama_produk' => 'required|max:50',
            'kategori' => 'required|max:50',
            'deskripsi' => 'required|max:255',
            'gambar' => 'required|array',
            'gambar.*' => 'required|mimes:jpeg,png,jpg',
            'warna' => 'required|array',
            'warna.*' => 'required|max:20',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric',
            'ukuran' => 'required|array',
            'ukuran.*' => 'required|max:3',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => 'error validation',
                'forms' => $validator->errors()
            ]);       
        }

        $store_produk = Product::create([
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        if($store_produk){
            if($request->hasfile('gambar')){
                foreach($request->file('gambar') as $file){
                   $name = time().rand(1,100).'.'.$file->extension();
                   $file->move(public_path('images'), $name);  
                   Gambar::create([
                    'gambar_produk' => $name,
                    'id_produk' => $store_produk->id_produk,
                ]);
               }
            }

            if($request->warna){
                foreach($request->warna as $warna){
                    Warna::create([
                     'warna_produk' => $warna,
                     'id_produk' => $store_produk->id_produk,
                 ]);
                }
            }

            if($request->ukuran && $request->harga){
                foreach($request->harga as $i => $harga){
                    Harga::create([
                     'harga_produk' => $harga,
                     'ukuran_produk' => $request->ukuran[$i],
                     'id_produk' => $store_produk->id_produk,
                 ]);
                }
            }

            return response()->json([
                'result' => true,
                'message' =>  'success added',
                'id' => encrypt($store_produk->id_produk)
            ]);   
        }else{
            return response()->json([
                'result' => false,
                'message' => 'error input'
            ]);   
        }
    }
    
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'nama_produk' => 'required|max:50',
            'kategori' => 'required|max:50',
            'deskripsi' => 'required|max:255',
            'gambar' => 'required|array',
            'gambar.*' => 'required|mimes:jpeg,png,jpg',
            'warna' => 'required|array',
            'warna.*' => 'required|max:20',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric',
            'ukuran' => 'required|array',
            'ukuran.*' => 'required|max:3',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => 'error validation',
                'forms' => $validator->errors()
            ]);       
        }


        $id_produk = decrypt($id);
        $produk = Product::find($id_produk);

        $produk = $produk->update([
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        if($produk){
            if($request->hasfile('gambar')){
                $gambar =  Gambar::where('id_produk',$id_produk)->get();

                foreach($gambar as $gd){
                    unlink(public_path('images/'.$gd->gambar_produk));
                }

                $delete_gambar =  Gambar::where('id_produk',$id_produk)->delete();

                foreach($request->file('gambar') as $file){
                   $name = time().rand(1,100).'.'.$file->extension();
                   $file->move(public_path('images'), $name);  
                   Gambar::create([
                    'gambar_produk' => $name,
                    'id_produk' => $id_produk,
                ]);
               }
            }

            if($request->warna){
                $delete_warna =  Warna::where('id_produk',$id_produk)->delete();
                foreach($request->warna as $warna){
                    Warna::create([
                     'warna_produk' => $warna,
                     'id_produk' => $id_produk,
                 ]);
                }
            }

            if($request->ukuran && $request->harga){
                $delete_harga =  Harga::where('id_produk',$id_produk)->delete();
                foreach($request->harga as $i => $harga){
                    Harga::create([
                     'harga_produk' => $harga,
                     'ukuran_produk' => $request->ukuran[$i],
                     'id_produk' => $id_produk,
                 ]);
                }
            }

            return response()->json([
                'result' => true,
                'message' =>  'updated success'
            ]);   
        }else{
            return response()->json([
                'result' => false,
                'message' => 'error input'
            ]);   
        }
    }

    public function destroy(Request $request,$id)
    {
        $id_produk = decrypt($id);
        $produk = Product::find($id_produk);
        if($produk){

            $delete_produk = $produk->delete();
            if($delete_produk){
                $gambar =  Gambar::where('id_produk',$id_produk)->get();
                foreach($gambar as $gd){
                    unlink(public_path('images/'.$gd->gambar_produk));
                }
                
                $delete_gambar =  Gambar::where('id_produk',$id_produk)->delete();
                $delete_warna =  Warna::where('id_produk',$id_produk)->delete();
                $delete_harga =  Harga::where('id_produk',$id_produk)->delete();

                return response()->json([
                    'result' => true,
                    'message' => 'success delete'
                ]);   
            }else{
                return response()->json([
                    'result' => false,
                    'message' => 'failed delete'
                ]);  
            }
        }else{
            return response()->json([
                'result' => false,
                'message' => 'data not found'
            ]);   
        }
        
    }
}
