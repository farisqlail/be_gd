@extends('template')
@section('content_header')
Master Sumber Transaksi
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Sumber Transaksi</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin addToko" data-toggle="modal" data-target="#modalToko"><i
                        class="fa fa-plus"></i>
                    <span>&nbsp; Add Toko</span></a>
                <a class="btn btn-xs" data-toggle="modal" data-target="#managePlatform"><i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Platform</span></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="tokoTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Platform</th>
                            <th>Nama Toko</th>
                            <th><i class="fa fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach ($toko as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->nama_platform}}</td>
                            <td>{{$item->nama_sumber}}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateToko" data-id="{{$item->id}}"
                                        data-target="#modalToko"><i title="Update Toko"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteToko" data-id="{{$item->id}}"
                                        data-target="#modalToko"><i title="Delete Toko"
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

@include('Menu.SumberTransaksi.Modal.modalToko')
@include('Menu.SumberTransaksi.Modal.modalPlatform')
<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    // DataTable
        var tokoTable=$("#tokoTable").DataTable({
                'paging': true,
                'dom': 'lBfrtip',
                'buttons':['excel'],
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                'info': true,
                'autoWidth': false,
                'scrollX':true,
                // 'columnDefs': [
                //     { width: '20%', targets: 0 }, // Example width settings
                //     { width: '30%', targets: 1 }
                // ]
        });

        tokoTable.buttons().container().appendTo('#tokoTable_wrapper .col-md-6:eq(0)');
        $('.dataTables_filter').css({
        'display': 'flex',
        'justify-content': 'flex-end',
        'align-items': 'center'
        });

    // DataTable
    // Showing Modal Form Store
        $(".addToko").click(function(){
            try {
                $.ajax({
                url:'/Toko/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalToko .modal-body").html('');
                    $("#modalToko .modal-title").html(`
                        Add Sumber Transaksi
                    `);
                    $("#modalToko .modal-body").html(`
                        <form class="formAddToko" method="post">
                            @csrf
                        <div class="box-body">
                                <div class="form-group">
                                    <label>Platform</label>
                                    <select name="platform" id="platformToko" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Platform--</option>
                                        ${res.platforms.map(v => `
                                                <option value="${v.id}">${v.nama_platform}</option>
                                            `).join('')}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="toko">Sumber Transaksi / Nama Toko</label>
                                    <input type="text" class="form-control" name="toko" placeholder="Masukkan Nama Toko">
                                </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ">Save</button>
                        </div>
                        </form>
                    `);
                    $("#modalToko .select2").select2();

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
        $(document).on("submit",".formAddToko",function(e){
            e.preventDefault();
            var form = $('.formAddToko');
            var url = '/Toko/Store';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    tokoTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalToko").modal('hide');
                    $.each(res.sumbers,function(key,value){
                        var row=`
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_platform}</td>
                            <td>${value.nama_sumber}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateToko" data-id="${value.id}"
                                        data-target="#modalToko"><i title="Update Toko"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteToko" data-id="${value.id}"
                                        data-target="#modalToko"><i title="Delete Toko"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        tokoTable.row.add($(row));
                    });
                    tokoTable.draw();
                }
            })
        });
    // Action Modal Form Store

    // Showing Modal Form Update
        $(document).on('click','.updateToko',function(){
            try {
                $.ajax({
                url:'/Toko/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalToko .modal-body").html('');
                    $("#modalToko .modal-title").html(`
                        Update Sumber Transaksi
                    `);
                    $("#modalToko .modal-body").html(`
                        <form class="formUpdateToko" method="post">
                            @csrf
                            <div class="box-body">
                                <input type="hidden" class="form-control" name="id" value="${res.sumbers[0].id}">
                                <div class="form-group">
                                    <label>Platform</label>
                                    <select name="platform" id="platformToko" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Platform--</option>
                                        ${res.platforms.map(p => `
                                                <option value="${p.id}" ${res.sumbers[0].id == p.id ? "selected":""}>${p.nama_platform}</option>
                                            `).join('')}
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="toko">Sumber Transaksi / Nama Toko</label>
                                    <input type="text" class="form-control" name="toko" value="${res.sumbers[0].nama_sumber}">
                                </div>
                            </div>
                            <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                        </form>
                    `);
                    $("#modalToko .select2").select2();

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
        $(document).on("submit",".formUpdateToko",function(e){
            e.preventDefault();
            var form = $('.formUpdateToko');
            var url = '/Toko/Update';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    tokoTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalToko").modal('hide');
                    $.each(res.sumbers,function(key,value){
                        var row=`
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_platform}</td>
                            <td>${value.nama_sumber}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateToko" data-id="${value.id}"
                                        data-target="#modalToko"><i title="Update Toko"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteToko" data-id="${value.id}"
                                        data-target="#modalToko"><i title="Delete Toko"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        tokoTable.row.add($(row));
                    });
                    tokoTable.draw();
                }
            })
        });
    // Action Modal Form Update

    // Showing Modal Form Delete
        $(document).on('click','.deleteToko',function(){
            try {
                $.ajax({
                url:'/Toko/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalToko .modal-body").html('');
                    $("#modalToko .modal-title").html(`
                        Delete Produk
                    `);
                    $("#modalToko .modal-body").html(`
                        <form class="formDeleteToko" method="post">
                            @csrf
                        <div class="box-body">
                            <input type="hidden" class="form-control" name="id" id="id" value="${res.sumbers[0].id}">
                               <p> Apakah anda yakin ingin menghapus produk ini ? </p>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger ">Delete</button>
                        </div>
                        </form>
                    `);
                    $("#modalToko .select2").select2();

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
        $(document).on("submit",".formDeleteToko",function(e){
            e.preventDefault();
            var form = $('.formDeleteToko');
            var url = '/Toko/Delete';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    tokoTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalToko").modal('hide');
                    $.each(res.sumbers,function(key,value){
                        var row=`
                        <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_platform}</td>
                            <td>${value.nama_sumber}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateToko" data-id="${value.id}"
                                        data-target="#modalToko"><i title="Update Toko"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteToko" data-id="${value.id}"
                                        data-target="#modalToko"><i title="Delete Toko"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        `;
                        tokoTable.row.add($(row));
                    });
                    tokoTable.draw();
                }
            })
        });
    // Action Modal Form Delete

    });
</script>
@endsection
