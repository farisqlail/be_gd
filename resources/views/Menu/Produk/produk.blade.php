@extends('template')
@section('content_header')
Master Produk
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Produk</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin addProduk" data-toggle="modal" data-target="#modalProduk"><i
                        class="fa fa-plus"></i>
                    <span>&nbsp; Add Produk</span></a>
                <a class="btn btn-xs" data-toggle="modal" data-target="#manageVarian"><i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Varian</span></a>
                <a class="btn btn-xs" data-toggle="modal" data-target="#manageJenis"><i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Jenis</span></a>
                {{-- <a class="btn btn-xs" data-toggle="modal" data-target="#addService"><i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Service</span></a> --}}
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="produkTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Produk</th>
                            <th>Jenis</th>
                            <th>Kode</th>
                            <th>Durasi</th>
                            <th>Biaya</th>
                            <th>Maximal User</th>
                            <th><i class="fa fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach ($produk as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->variance_name}}</td>
                            <td>{{$item->type_name}}</td>
                            <td>{{$item->kode_produk}}</td>
                            <td>{{$item->durasi}} {{$item->ket_durasi}}</td>
                            <td>{{$item->biaya}}</td>
                            <td>{{$item->batas_pengguna}}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateProduk" data-id="{{$item->id}}"
                                        data-target="#modalProduk"><i title="Update produk"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteProduk" data-id="{{$item->id}}"
                                        data-target="#modalProduk"><i title="Delete produk"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        @php
                        $i +=1;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@include('Menu.Produk.Modal.modalProduct')
@include('Menu.Produk.Modal.modalVarian')
@include('Menu.Produk.Modal.modalJenis')
<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // DataTable
        var produkTable = $("#produkTable").DataTable({
            'paging': true,
            'dom': 'lBfrtip',
            'buttons': ['excel'],
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            'info': true,
            'autoWidth': false,
            'scrollX': true,
            // 'columnDefs': [
            //     { width: '20%', targets: 0 }, // Example width settings
            //     { width: '30%', targets: 1 }
            // ]
        });

        produkTable.buttons().container().appendTo('#produkTable_wrapper .col-md-6:eq(0)');
        $('.dataTables_filter').css({
            'display': 'flex',
            'justify-content': 'flex-end',
            'align-items': 'center'
        });
        var filterVarian = '&nbsp;<select name="varian" id="filterVarian" class="form-control select2" style="width: auto;text-align:left;"><option value="">--Pilih Varian--</option></select> &nbsp;';
        var filterJenis = '&nbsp;<select name="jenis" id="filterJenis" class="form-control select2" style="width: auto;text-align:left;"><option value="">--Pilih Jenis--</option></select>&nbsp;';
        $('.dataTables_filter').prepend(filterJenis);
        $('.dataTables_filter').prepend(filterVarian);


        $.ajax({
            type: 'get',
            url: '/Produk/Get/Filter',
            dataType: 'json',
            success: function(res) {
                $.each(res.data.types, function(key, value) {
                    var option_types = `<option value="${value.id}">${value.type_name}</option>`;
                    $("#filterJenis").append(option_types);
                });
                $.each(res.data.variances, function(key, value) {
                    var option_variances = `<option value="${value.id}">${value.variance_name}</option>`;
                    $("#filterVarian").append(option_variances);
                });
            }
        });

        $(document).on('change', '#filterVarian,#filterJenis', function() {
            var varian = $("#filterVarian").val();
            var jenis = $("#filterJenis").val();
            $.ajax({
                type: 'post',
                url: '/Produk/Filter',
                dataType: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    varian: varian,
                    jenis: jenis,
                },
                success: function(res) {
                    produkTable.clear();
                    $.each(res.products, function(key, value) {
                        var row = `
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.variance_name}</td>
                            <td>${value.type_name}</td>
                            <td>${value.kode_produk}</td>
                            <td>${value.durasi} ${value.ket_durasi}</td>
                            <td>${value.biaya}</td>
                            <td>${value.batas_pengguna}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Update produk"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Delete produk"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        produkTable.row.add($(row));
                    });
                    produkTable.draw();
                }
            });
        });
        // DataTable
        // Showing Modal Form Store
        $(".addProduk").click(function() {
            try {
                $.ajax({
                    url: '/Produk/fetch/form',
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        $("#modalProduk .modal-body").html('');
                        $("#modalProduk .modal-title").html(`
                                Add Produk
                            `);
                        $("#modalProduk .modal-body").html(`
                                <form class="formAddProduk" method="post"  enctype="multipart/form-data">
                                    @csrf
                                <div class="box-body">
                                        <div class="form-group">
                                            <label>Produk</label>
                                            <select name="nama_produk" id="varianProduk" class="form-control select2" style="width: 100%;">
                                                <option value="">--Choose Product--</option>
                                            ${res.variances.map(v => `
                                                        <option value="${v.id}">${v.variance_name}</option>
                                                    `).join('')}
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Unit Type">Jenis Produk</label>
                                            <select name="jenis_produk" id="jenisProduk" class="form-control select2" style="width: 100%;">
                                                <option value="">--Choose Product's Type--</option>
                                            ${res.types.map(t => `
                                                        <option value="${t.id}">${t.type_name}</option>
                                                    `).join('')}
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="durasi">Durasi Produk</label>
                                            <input type="number" class="form-control" name="durasi" id="durasi" placeholder="1,2,3 ...">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan Durasi</label>
                                            <select name="keterangan" class="form-control select2" style="width: 100%;">
                                                <option value="">-- Pilih Durasi --</option>
                                                <option value="Hari">Hari</option>
                                                <option value="Bulan">Bulan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Biaya</label>
                                            <input type="number" class="form-control" name="biaya" id="biaya"
                                                placeholder="Masukkan Biaya Produksi">
                                        </div>
                                        <div class="form-group">
                                            <label for="batas">Maximal Users</label>
                                            <input type="number" class="form-control" name="batas" id="batas" placeholder="1,2,3 ...">
                                        </div>
                                        <div class="form-group">  
                                            <label for="produkImage">Upload Image</label>  
                                            <input type="file" class="form-control" name="images[]" id="produkImage" multiple required accept="image/*">  
                                            <small class="form-text text-muted">You can upload multiple images (max 5).</small>  
                                        </div>  
                                </div>
                                <!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                                </form>
                            `);
                        $("#modalProduk .select2").select2();

                    },
                    error: function(xhr) {
                        // Handle error response
                        console.error("Error updating component:", xhr);
                    }
                });
            } catch (error) {
                console.log(error);
            }
        });
        // Showing Modal Form Store

        // Action Modal Form Store
        $(document).on("submit", ".formAddProduk", function(e) {
            e.preventDefault();
            var form = $('.formAddProduk');
            var url = '/Produk/Store';
            var formData = new FormData(form[0]);

            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    produkTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalProduk").modal('hide');
                    $.each(res.products, function(key, value) {
                        var row = `
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.variance_name}</td>
                            <td>${value.type_name}</td>
                            <td>${value.kode_produk}</td>
                            <td>${value.durasi} ${value.ket_durasi}</td>
                            <td>${value.biaya}</td>
                            <td>${value.batas_pengguna}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Update produk"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Delete produk"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        produkTable.row.add($(row));
                    });
                    produkTable.draw();
                }
            })
        });
        // Action Modal Form Store

        // Showing Modal Form Update
        $(document).on('click', '.updateProduk', function() {
            try {
                $.ajax({
                    url: '/Produk/fetch/form',
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        $("#modalProduk .modal-body").html('');
                        $("#modalProduk .modal-title").html(`
                        Update Produk
                    `);
                        $("#modalProduk .modal-body").html(`
                        <form class="formUpdateProduk" method="post">
                            @csrf
                        <div class="box-body">
                            <input type="hidden" class="form-control" name="id" id="id" value="${res.products[0].id}">
                                <div class="form-group">
                                    <label>Produk</label>
                                    <select name="nama_produk" id="varianProduk" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Product--</option>
                                        ${res.variances.map(v => `
                                                <option value="${v.id}" ${res.products[0].id_varian==v.id ? "selected":""}>${v.variance_name}</option>
                                            `).join('')}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Unit Type">Jenis Produk</label>
                                    <select name="jenis_produk" id="jenisProduk" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Product's Type--</option>
                                        ${res.types.map(t => `
                                                <option value="${t.id}" ${res.products[0].id_jenis==t.id ? "selected":""}>${t.type_name}</option>
                                            `).join('')}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="durasi">Durasi Produk</label>
                                    <input type="number" class="form-control" name="durasi" id="durasi" value="${res.products[0].durasi}">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan Durasi</label>
                                    <select name="keterangan" class="form-control select2" style="width: 100%;">
                                        <option value="">-- Pilih Durasi --</option>
                                        <option value="Hari" ${res.products[0].ket_durasi="Hari" ? "selected":""}>Hari</option>
                                        <option value="Bulan" ${res.products[0].ket_durasi="Bulan" ? "selected":""}>Bulan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Biaya</label>
                                    <input type="number" class="form-control" name="biaya" id="biaya" value="${res.products[0].biaya}">
                                </div>
                                <div class="form-group">
                                    <label for="batas">Maximal Users</label>
                                    <input type="number" class="form-control" name="batas" id="batas" value="${res.products[0].batas_pengguna}">
                                </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                        </form>
                    `);
                        $("#modalProduk .select2").select2();

                    },
                    error: function(xhr) {
                        // Handle error response
                        console.error("Error updating component:", xhr);
                    }
                });
            } catch (error) {
                console.log(error);
            }
        });
        // Showing Modal Form Update

        // Action Modal Form Update
        $(document).on("submit", ".formUpdateProduk", function(e) {
            e.preventDefault();
            var form = $('.formUpdateProduk');
            var url = '/Produk/Update';
            var formData = new FormData(form[0]);

            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    produkTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalProduk").modal('hide');
                    $.each(res.products, function(key, value) {
                        var row = `
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.variance_name}</td>
                            <td>${value.type_name}</td>
                            <td>${value.kode_produk}</td>
                            <td>${value.durasi} ${value.ket_durasi}</td>
                            <td>${value.biaya}</td>
                            <td>${value.batas_pengguna}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Update produk"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Delete produk"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        produkTable.row.add($(row));
                    });
                    produkTable.draw();
                }
            })
        });
        // Action Modal Form Update

        // Showing Modal Form Delete
        $(document).on('click', '.deleteProduk', function() {
            try {
                $.ajax({
                    url: '/Produk/fetch/form',
                    type: 'get',
                    dataType: 'json',
                    success: function(res) {
                        $("#modalProduk .modal-body").html('');
                        $("#modalProduk .modal-title").html(`
                        Delete Produk
                    `);
                        $("#modalProduk .modal-body").html(`
                        <form class="formDeleteProduk" method="post">
                            @csrf
                        <div class="box-body">
                            <input type="hidden" class="form-control" name="id" id="id" value="${res.products[0].id}">
                               <p> Apakah anda yakin ingin menghapus produk ini ? </p>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger ">Delete</button>
                        </div>
                        </form>
                    `);
                        $("#modalProduk .select2").select2();

                    },
                    error: function(xhr) {
                        // Handle error response
                        console.error("Error updating component:", xhr);
                    }
                });
            } catch (error) {
                console.log(error);
            }
        });
        // Showing Modal Form Delete

        // Action Modal Form Delete
        $(document).on("submit", ".formDeleteProduk", function(e) {
            e.preventDefault();
            var form = $('.formDeleteProduk');
            var url = '/Produk/Delete';
            var formData = new FormData(form[0]);

            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    produkTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalProduk").modal('hide');
                    $.each(res.products, function(key, value) {
                        var row = `
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.variance_name}</td>
                            <td>${value.type_name}</td>
                            <td>${value.kode_produk}</td>
                            <td>${value.durasi} ${value.ket_durasi}</td>
                            <td>${value.biaya}</td>
                            <td>${value.batas_pengguna}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Update produk"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteProduk" data-id="${value.id}"
                                        data-target="#modalProduk"><i title="Delete produk"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        produkTable.row.add($(row));
                    });
                    produkTable.draw();
                }
            })
        });
        // Action Modal Form Delete

    });
</script>
@endsection