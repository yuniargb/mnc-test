@extends('layout')


@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Produk</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Produk List</h3>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary" id="button-tambah" data-toggle="modal" data-target="#form-modal">
             Tambah Data
            </button>
            <div id="alert-table"></div>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</section>



<div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="detail-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="detail-modalLabel">Detail Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <dl class="row">
            <dt class="col-sm-3">ID Produk</dt>
            <dd class="col-sm-9"><span id="detail-id-produk"></span></dd>
            <dt class="col-sm-3">Nama Produk</dt>
            <dd class="col-sm-9"><span id="detail-nama-produk"></span></dd>
            <dt class="col-sm-3">Kategori Produk</dt>
            <dd class="col-sm-9"><span id="detail-kategori-produk"></span></dd>
            <dt class="col-sm-3">Deskripsi Produk</dt>
            <dd class="col-sm-9"><span id="detail-deskripsi-produk"></span></dd>
        </dl>

        <h4>Harga</h4>
        <ol id="detail-harga-list"></ol>
        <h4>Warna</h4>
        <ol id="detail-warna-list"></ol>
        <h4>Gambar</h4>
        <ol id="detail-gambar-list"></ol>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modalLabel">Form Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="alert-form"></div>
        <form autocomplete="off" data-method="post" id="action-form" enctype='multipart/form-data' data-id="">
            <div class="form-group">
                <label for="form_nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="form_nama_produk" name="nama_produk" placeholder="Nama Produk">
            </div>
            <div class="form-group">
                <label for="form_kategori_produk">Kategori Produk</label>
                <select name="kategori" class="form-control" id="form_kategori_produk" >
                <option>Pakaian</option>
                <option>Celana</option>
                <option>Topi</option>
                <option>Jas</option>
                <option>Sepatu</option>
                <option>Jaket</option>
                <option>Tas</option>
                <option>Dompet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="form_deskripsi_produk">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" id="form_deskripsi_produk" placeholder="Deskripsi Produk">
            </div>

            <div class="form-group">
                <label for="form_ukuran_produk">Ukuran</label>
                <select name="ukuran[]" class="form-control" id="form_ukuran_produk"  multiple="multiple">
                <option>S</option>
                <option>M</option>
                <option>L</option>
                <option>XL</option>
                <option>XXL</option>
                </select>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="form_harga_produk">Harga</label>
                    
                    <!-- <input type="number" name="harga[]" class="form-control" id="form_harga_produk" placeholder="Harga Produk"> -->
                </div>
            </div>
            <div id="form-harga-multiple" class="row">

            </div>
            <div class="form-group">
                <label for="form_warna_produk">Warna Produk</label>
                <select name="warna[]" class="form-control" id="form_warna_produk"  multiple="multiple">
                <option value=""></option>
                <option>Merah</option>
                <option>Biru</option>
                <option>Hitam</option>
                <option>Abu-abu</option>
                </select>
            </div>
            <div class="form-group">
                <label for="form_gambar_produk">Gambar</label>
                <input type="file" name="gambar[]" class="form-control" id="form_gambar_produk" placeholder="Gambar Produk" multiple="multiple">
            </div>            
            <button type="submit" class="btn btn-primary" id="form-submit">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
