$(function () {
    var dt_table = $("#example1")
    var dt_ajax = dt_table.DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        'processing': true,
        'serverSide': true,
        'ajax': base_url + '/api/produk',
        'columns': [{
                data: 'id_produk',
                name: 'id_produk'
            },
            {
                data: 'nama_produk',
                name: 'nama_produk'
            },
            {
                data: 'kategori',
                name: 'kategori'
            },
            {
                data: 'deskripsi',
                name: 'deskripsi'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });

    $('#myModal').modal('hide');

    dt_table.on('click', '.btn-detail', dt_ajax, function (e) {
        e.preventDefault()
        var id_produk = $(this).data('id')
        $.ajax({
            type: 'GET',
            url: base_url + '/api/produk/detail/' + id_produk,
            dataType: "json",
            success: function (res) {
                if (res.result) {
                    $('#detail-id-produk').text(res.data.produk.id_produk)
                    $('#detail-nama-produk').text(res.data.produk.kategori)
                    $('#detail-kategori-produk').text(res.data.produk.nama_produk)
                    $('#detail-deskripsi-produk').text(res.data.produk.deskripsi)


                    var html_gambar = ''
                    $.each(res.data.gambar, (i, val) => {
                        html_gambar += '<li class="mb-3"><img class="img-fluid" src="' + val.url_gambar + '" /></li>'
                    })
                    $('#detail-gambar-list').html(html_gambar)
                    var html_warna = ''
                    $.each(res.data.warna, (i, val) => {
                        html_warna += '<li>' + val.warna_produk + '</li>'
                    })
                    $('#detail-warna-list').html(html_warna)
                    var html_harga = ''
                    $.each(res.data.harga, (i, val) => {
                        html_harga += '<li>Ukuran  ' + val.ukuran_produk + ', Harga : ' + val.harga_produk + '</li>'
                    })
                    
                    $('#detail-harga-list').html(html_harga)

                    $('#detail-modal').modal('show');
                }

            }
        });
    });

    dt_table.on('click', '.btn-update', dt_ajax, function (e) {
        $('#action-form').data('method','put');
        e.preventDefault()
        var id_produk = $(this).data('id')
        $('#action-form').data('id',id_produk);
        $.ajax({
            type: 'GET',
            url: base_url + '/api/produk/detail/' + id_produk,
            dataType: "json",
            success: function (res) {
                if (res.result) {
                    $("#form_kategori_produk option[value='" + res.data.produk.kategori + "']").prop("selected", true);
                    $('#form_nama_produk').val(res.data.produk.nama_produk)
                    $('#form_deskripsi_produk').val(res.data.produk.deskripsi)
                   
                   
                    $.each(res.data.warna, (i, val) => {
                        console.log( val.warna_produk)
                        $("#form_warna_produk option[value='" + val.warna_produk + "']").prop("selected", true);
                    })
 
                    var html_harga = ''
                    $.each(res.data.harga, (i, val) => {
                        $("#form_ukuran_produk option[value='" + val + "']").attr("selected", true);

                        html_harga += `
                            <div class="col-3">
                                Ukuran ${val.ukuran_produk}
                            </div>
                            <div class="form-group col-9">
                                <label for="form_harga_produk">Harga</label>
                                
                                <input type="number" name="harga[]" class="form-control" value="${val.harga_produk}" id="form_harga_produk" placeholder="Harga Produk">
                            </div>
                        `
                    })

                    $('#form-harga-multiple').html(html_harga)

                    $('#form-modal').modal('show');
                }

            }
        });
    });
    dt_table.on('click', '.btn-delete', dt_ajax, function (e) {
        if (confirm("Kamu yakin ingin menghapus data ini?")) {
            
            e.preventDefault()
            var id_produk = $(this).data('id')
            $.ajax({
                type: 'POST',
                url: base_url + '/api/produk/delete/' + id_produk + '?_method=DELETE',
                dataType: "json",
                success: function (res) {
                    if (res.result) {
                        $('#alert-table').html('<div class="alert alert-success" role="alert">'+ res.message +'</div>')
                        dt_table.DataTable().ajax.reload();
                    }else{
                        $('#alert-table').html('<div class="alert alert-danger" role="alert">'+ res.message +'</div>')
                        dt_table.DataTable().ajax.reload();
                    }
    
                }
            });
        }
        return false;
    });

    $('#form_ukuran_produk').on('change', function(){
        var ukuran = $(this).val()
        var html_harga = ''
        $.each(ukuran, (i, val) => {

            html_harga += `
                <div class="col-3">
                    Ukuran ${val}
                </div>
                <div class="form-group col-9">
                    <label for="form_harga_produk">Harga</label>
                    
                    <input type="number" name="harga[]" class="form-control" id="form_harga_produk" placeholder="Harga Produk">
                </div>
            `
        })
        $('#form-harga-multiple').html(html_harga)
    })

    $('#button-tambah').on('click', function(){
        $('#action-form').data('method','post');
    })


    $('#action-form').on('submit', function(e){
        e.preventDefault()
        $('#form-submit').attr('disabled',true)
        var data = new FormData(this);
        var method = $(this).data('method')

        if(method == 'post'){
            var save_url = base_url + '/api/produk/store'
        }else{
            var id = $(this).data('id')
            var save_url = base_url + '/api/produk/update/' + id + '?_method=PUT'
        }

        $.ajax({
            type: 'POST',
            url: save_url,
            dataType: "json",
            data: data,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.result) {
                    $('#form-modal').modal('hide');
                    $('#alert-form').html('')
                    $('#alert-table').html('<div class="alert alert-success" role="alert">'+ res.message +'</div>')
                    dt_table.DataTable().ajax.reload();
                }else{
                    var alert_html = '<div class="alert alert-danger" role="alert">'
                    $.each(res.forms, function(key,val){
                       
                        alert_html += `${val} <br/>`
                    })

                    alert_html += ' </div>'

                    $('#alert-form').html(alert_html)
                }
                $('#form-submit').attr('disabled',false)
            }
        });
    })
});
