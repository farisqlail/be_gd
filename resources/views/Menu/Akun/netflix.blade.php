@extends('template')
@section('content_header')
Akun Netflix
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Netflix</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin" href="/Akun/Netflix/Create?varian=Netflix"><i class="fa fa-plus"></i>
                    <span>&nbsp; Add Akun</span></a>
                <a class="btn btn-xs" data-toggle="modal" data-target="#manageMetode"><i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Metode</span></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="akunTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Produk</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Jumlah User</th>
                            <th>Nomor Akun</th>
                            <th><i class="fa fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach ($akuns as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->detail}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->password}}</td>
                            <td>{{$item->tanggal_pembuatan}}</td>
                            <td>{{$item->jumlah_pengguna}}</td>
                            <td>{{$item->nomor_akun}}</td>
                            <td>
                                <center>
                                    <a data-toggle="modal" class="detailAkun" data-id="{{$item->id}}"
                                        data-target="#akunModal"><i title="Detail Akun" class="fa fa-fw fa-eye"></i></a>
                                    <a data-toggle="modal" class="updateAkun" data-id="{{$item->id}}"
                                        data-target="#akunModal"><i title="Update Akun"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteAkun" data-id="{{$item->id}}"
                                        data-target="#akunModal"><i title="Delete Akun"
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



@include('Menu.Akun.Modal.metodeModal')
@include('Menu.Akun.Modal.akunModal')
<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
        // DataTable
            var akunTable=$("#akunTable").DataTable({
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

            akunTable.buttons().container().appendTo('#akunTable_wrapper .col-md-6:eq(0)');
            $('.dataTables_filter').css({
            'display': 'flex',
            'justify-content': 'flex-end',
            'align-items': 'center'
            });

            var filterJenis = '&nbsp;<select name="jenis" id="filterJenis" class="form-control select2" style="width: auto;text-align:left;"><option value="">--Pilih Jenis--</option></select>&nbsp;';
            $('.dataTables_filter').prepend(filterJenis);


            $.ajax({
                type:'get',
                url:'/Produk/Get/Filter',
                dataType:'json',
                success:function(res){
                    $.each(res.data.types,function(key,value){
                        var option_types = `<option value="${value.id}">${value.type_name}</option>`;
                        $("#filterJenis").append(option_types);
                    });
                }
            });

            $(document).on('change','#filterJenis',function(){
                var jenis=$("#filterJenis").val();
                $.ajax({
                    type:'post',
                    url:'/Produk/Filter',
                    dataType:'json',
                    data:{
                        _token:'{{csrf_token()}}',
                        jenis:jenis,
                    },
                    success:function(res){
                        akunTable.clear();
                        $.each(res.products,function(key,value){
                            var row=`
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
                                            data-target="#akunModal"><i title="Update produk"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteProduk" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Delete produk"
                                                class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                            `;
                            akunTable.row.add($(row));
                        });
                        akunTable.draw();
                    }
                });
            });
        // DataTable

        // Show Form Update
            $(document).on("click",'.updateAkun',function(){
                var id=$(this).data('id');
                $.ajax({
                    url:'/Akun/Netflix/fetch/form?varian=Netflix&idAkun='+id,
                    type:'get',
                    dataType:'json',
                    success:function(res){
                        $("#akunModal .modal-body").html('');
                        $("#akunModal .modal-title").html(`
                            Update Akun Netflix
                        `);
                        $("#akunModal .modal-body").html(`
                            <form class="formUpdateAkun" method="post">
                                @csrf
                                <div class="box-body">
                                <input type="hidden" name="varian" value="Netflix">
                                <input type="hidden" name="id" value="${res.akuns[0].id}">
                                    <div class="form-group">
                                        <label>Produk</label>
                                        <select name="produk"  class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">--Choose Produk--</option>
                                           ${res.products.map(p => `
                                                <option value="${p.id}" ${res.akuns[0].id_produk == p.id ? "selected":""}>${p.detail}</option>
                                            `).join('')}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Metode Produksi</label>
                                        <select name="metode" class="form-control select2"
                                            style="width: 100%;">
                                            ${res.metode.map(m => `
                                                <option value="${m.id}" ${res.akuns[0].id_metode==m.id ? "selected" :""}>${m.nama_metode}</option>
                                            `).join('')}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="${res.akuns[0].email}">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="text" class="form-control" name="password" value="${res.akuns[0].password}">
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Telepon Akun</label>
                                        <input type="number" class="form-control" name="nomor" value="${res.akuns[0].nomor_akun}">
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Pembuatan</label>
                                        <input type="date" class="form-control" name="tanggal" value="${res.akuns[0].tanggal_pembuatan}">
                                    </div>

                                    <div class="row form-group">
                                        ${res.details.map(d => `
                                            <input type="hidden" class="form-control" name="id_detail[]" value="${d.id}">
                                            <div class="col-sm-6">
                                                <label>Profile</label>
                                                <input type="text" name="profile[]" value="${d.profile}" class="form-control">
                                            </div>
                                            <div class="col-sm-6" >
                                                <label>Pin</label>
                                                <input type="text" name="pin[]" value="${d.pin==null ? "":d.pin}" class="form-control">
                                            </div>
                                        `).join('')}

                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ">Update</button>
                                </div>
                            </form>
                        `);
                        $("#akunModal .select2").select2();

                    },
                    error: function(xhr) {
                                // Handle error response
                                console.error("Error updating component:", xhr);
                    }
                });
            });
        // Show Form Update

        // Action Form Update
            $(document).on("submit",".formUpdateAkun",function(e){
                e.preventDefault();
                var form = $('.formUpdateAkun');
                var url = '/Akun/Netflix/Update';
                var formData = new FormData(form[0]);

                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:function(res){
                        akunTable.clear();
                        toastr.success(res.message, 'Success');
                        $("#akunModal").modal('hide');
                        $.each(res.akuns,function(key,value){
                            var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.detail}</td>
                                <td>${value.email}</td>
                                <td>${value.password}</td>
                                <td>${value.tanggal_pembuatan}</td>
                                <td>${value.jumlah_pengguna}</td>
                                <td>${value.nomor_akun}</td>
                                <td>
                                    <center>
                                        <a data-toggle="modal" class="detailAkun" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Detail Akun" class="fa fa-fw fa-eye"></i></a>
                                        <a data-toggle="modal" class="updateAkun" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Update Akun"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteAkun" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Delete Akun"
                                                    class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                            `;
                            akunTable.row.add($(row));
                        });
                        akunTable.draw();
                    }
                })
            });
        // Action Form Update

         // Show Form Delete
            $(document).on("click",'.deleteAkun',function(){
                var id=$(this).data('id');
                $.ajax({
                    url:'/Akun/Netflix/fetch/form?varian=Netflix&idAkun='+id,
                    type:'get',
                    dataType:'json',
                    success:function(res){
                        $("#akunModal .modal-body").html('');
                        $("#akunModal .modal-title").html(`
                            Delete Akun Netflix
                        `);
                        $("#akunModal .modal-body").html(`
                            <form class="formDeleteAkun" method="post">
                                @csrf
                                <div class="box-body">
                                <input type="hidden" name="varian" value="Netflix">
                                <input type="hidden" name="id" value="${res.akuns[0].id}">
                                    <p> Apakah anda yakin ingin menghapus akun <b> ${res.akun[0].email} </b> ? </p>
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
            });
        // Show Form Delete

        // Action Form Delete
        $(document).on("submit",".formDeleteAkun",function(e){
                e.preventDefault();
                var form = $('.formDeleteAkun');
                var url = '/Akun/Netflix/Delete';
                var formData = new FormData(form[0]);

                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success:function(res){
                        akunTable.clear();
                        toastr.success(res.message, 'Success');
                        $("#akunModal").modal('hide');
                        $.each(res.akuns,function(key,value){
                            var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.detail}</td>
                                <td>${value.email}</td>
                                <td>${value.password}</td>
                                <td>${value.tanggal_pembuatan}</td>
                                <td>${value.jumlah_pengguna}</td>
                                <td>${value.nomor_akun}</td>
                                <td>
                                    <center>
                                        <a data-toggle="modal" class="detailAkun" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Detail Akun" class="fa fa-fw fa-eye"></i></a>
                                        <a data-toggle="modal" class="updateAkun" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Update Akun"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteAkun" data-id="${value.id}"
                                            data-target="#akunModal"><i title="Delete Akun"
                                                    class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                            `;
                            akunTable.row.add($(row));
                        });
                        akunTable.draw();
                    }
                })
            });
        // Action Form Delete
    });
</script>
@endsection