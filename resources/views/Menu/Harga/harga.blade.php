@extends('template')
@section('content_header')
Harga
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Harga</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin addProduk" data-toggle="modal" data-target="#modalProduk"><i
                        class="fa fa-plus"></i>
                    <span>&nbsp; Add Harga</span></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="produkTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Platform</th>
                            <th>Toko</th>
                            <th>Produk</th>
                            <th>Kode Produk & Toko</th>
                            <th>Harga</th>
                            <th><i class="fa fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach ($prices as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->nama_platform}}</td>
                            <td>{{$item->nama_sumber}}</td>
                            <td>{{$item->detail}}</td>
                            <td>{{$item->kode_toko}}</td>
                            <td>{{$item->harga}}</td>
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


<div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="modalProduk" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    // DataTable
        var produkTable=$("#produkTable").DataTable({
                'paging': true,
                'dom': 'lBfrtip',
                'buttons':['excel'],
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                "lengthMenu": [[ 25, 50,100, -1], [ 25, 50,100, "All"]],
                'info': true,
                'autoWidth': false,
                'scrollX':true,
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
        var filterPlatform = '&nbsp;<select name="platform" id="filterPlatform" class="form-control select2" style="width: auto;text-align:left;"><option value="">--Pilih Platform--</option></select> &nbsp;';
        var filterToko = '&nbsp;<select name="toko" id="filterToko" class="form-control select2" style="width: auto;text-align:left;"><option value="">--Pilih Toko--</option></select> &nbsp;';
        $('.dataTables_filter').prepend(filterVarian);
        $('.dataTables_filter').prepend(filterPlatform);
        $('.dataTables_filter').prepend(filterToko);


        $.ajax({
            type:'get',
            url:'/Harga/Get/Filter',
            dataType:'json',
            success:function(res){
                $.each(res.variances,function(key,value){
                    var option_variances = `<option value="${value.id}">${value.variance_name}</option>`;
                    $("#filterVarian").append(option_variances);
                });
                $.each(res.platforms,function(key,value){
                    var option_platforms = `<option value="${value.id}">${value.nama_platform}</option>`;
                    $("#filterPlatform").append(option_platforms);
                });
                $.each(res.toko,function(key,value){
                    var option_toko = `<option value="${value.id}">${value.nama_sumber}</option>`;
                    $("#filterToko").append(option_toko);
                });
            }
        });

        $(document).on('change','#filterVarian,#filterPlatform,#filterToko',function(){
            var varian=$("#filterVarian").val();
            var platform=$("#filterPlatform").val();
            var toko=$("#filterToko").val();
            $.ajax({
                type:'post',
                url:'/Harga/Filter',
                dataType:'json',
                data:{
                    _token:'{{csrf_token()}}',
                    varian:varian,
                    platform:platform,
                    toko:toko
                },
                success:function(res){
                    produkTable.clear();
                    $.each(res.prices,function(key,value){
                        var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.nama_platform}</td>
                                <td>${value.nama_sumber}</td>
                                <td>${value.detail}</td>
                                <td>${value.kode_toko}</td>
                                <td>${value.harga}</td>
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
        $(".addProduk").click(function(){
            try {
                $.ajax({
                url:'/Harga/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalProduk .modal-body").html('');
                    $("#modalProduk .modal-title").html(`
                        Add Harga
                    `);
                    $("#modalProduk .modal-body").html(`
                        <form class="formAddProduk" method="post">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Produk</label>
                                    <select name="produk" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Product--</option>
                                        ${res.products.map(p => `
                                                <option value="${p.id}">${p.variance_name} ${p.type_name} ${p.durasi} ${p.ket_durasi}</option>
                                            `).join('')}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sumber Transaksi</label>
                                    <select name="sumber" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Sumber Transaksi--</option>
                                        ${res.sumbers.map(s => `
                                                <option value="${s.id}">${s.nama_platform} ${s.nama_sumber} </option>
                                            `).join('')}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="durasi">Harga</label>
                                    <input type="number" class="form-control" name="harga" id="harga"
                                        placeholder="Input Harga Produk">
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
        $(document).on("submit",".formAddProduk",function(e){
            e.preventDefault();
            var form = $('.formAddProduk');
            var url = '/Harga/Store';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    produkTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalProduk").modal('hide');
                    $.each(res.prices,function(key,value){
                        var row=`
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_platform}</td>
                            <td>${value.nama_sumber}</td>
                            <td>${value.detail}</td>
                            <td>${value.kode_toko}</td>
                            <td>${value.harga}</td>
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
        $(document).on('click','.updateProduk',function(){
            try {
                $.ajax({
                url:'/Harga/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalProduk .modal-body").html('');
                    $("#modalProduk .modal-title").html(`
                        Update Harga
                    `);
                    $("#modalProduk .modal-body").html(`
                        <form class="formUpdateProduk" method="post">
                            @csrf
                       <div class="box-body">
                        <input type="hidden" class="form-control" name="id" value="${res.prices[0].id}">
                            <div class="form-group">
                                <label>Produk</label>
                                <select name="produk" class="form-control select2" style="width: 100%;">
                                    <option value="">--Choose Product--</option>
                                    ${res.products.map(p => `
                                            <option value="${p.id}" ${res.prices[0].id_produk==p.id ? "selected":""}>${p.variance_name} ${p.type_name} ${p.durasi} ${p.ket_durasi}</option>
                                        `).join('')}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Sumber Transaksi</label>
                                <select name="sumber" class="form-control select2" style="width: 100%;">
                                    <option value="">--Choose Sumber Transaksi--</option>
                                    ${res.sumbers.map(s => `
                                            <option value="${s.id}" ${res.prices[0].id_toko==s.id ? "selected":""}>${s.nama_platform} ${s.nama_sumber} </option>
                                        `).join('')}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Harga</label>
                                <input type="number" class="form-control" name="harga" id="harga" value="${res.prices[0].harga}">
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
        $(document).on("submit",".formUpdateProduk",function(e){
            e.preventDefault();
            var form = $('.formUpdateProduk');
            var url = '/Harga/Update';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    produkTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalProduk").modal('hide');
                    $.each(res.prices,function(key,value){
                        var row=`
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_platform}</td>
                            <td>${value.nama_sumber}</td>
                            <td>${value.detail}</td>
                            <td>${value.kode_toko}</td>
                            <td>${value.harga}</td>
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
        $(document).on('click','.deleteProduk',function(){
            try {
                $.ajax({
                url:'/Produk/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalProduk .modal-body").html('');
                    $("#modalProduk .modal-title").html(`
                        Delete Produk
                    `);
                    $("#modalProduk .modal-body").html(`
                        <form class="formDeleteProduk" method="post">
                            @csrf
                        <div class="box-body">
                            <input type="hidden" class="form-control" name="id" id="id" value="${res.products[0].id}">
                               <p> Apakah anda yakin ingin menghapus setup harga ini ? </p>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger ">Delete</button>
                        </div>
                        </form>
                    `);

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
        $(document).on("submit",".formDeleteProduk",function(e){
            e.preventDefault();
            var form = $('.formDeleteProduk');
            var url = '/Harga/Delete';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    produkTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalProduk").modal('hide');
                    $.each(res.prices,function(key,value){
                        var row=`
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_platform}</td>
                            <td>${value.nama_sumber}</td>
                            <td>${value.detail}</td>
                            <td>${value.kode_toko}</td>
                            <td>${value.harga}</td>
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
