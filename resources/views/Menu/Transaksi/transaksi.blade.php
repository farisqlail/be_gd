@extends('template')
@section('content_header')
Transaksi
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Transaksi</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin addTransaksi" data-toggle="modal" data-target="#modalTransaksi"><i
                        class="fa fa-plus"></i>
                    <span>&nbsp; Add Transaksi</span></a>
                <a class="btn btn-xs" data-toggle="modal" data-target="#managePayment"><i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Payment</span></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="transaksiTable" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Customer</th>
                            <th>No. Whatsapp</th>
                            <th>Toko</th>
                            <th>Produk</th>
                            <th>Tanggal Pembelian</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                            <th>Chat Wa</th>
                            <th>Akun</th>
                            <th><i class="fa fa-bars"></i></th>
                            <th><input type="checkbox" id="selectAll"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach ($transaksi as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->nama_customer}}</td>
                            <td>{{$item->wa}}</td>
                            <td>{{$item->nama_platform}} {{$item->nama_sumber}}</td>
                            <td>{{$item->detail}}</td>
                            <td>{{$item->tanggal_pembelian}}</td>
                            <td>{{$item->tanggal_berakhir}}</td>
                            <td>{{$item->status_pembayaran}}</td>
                            <td><a href="{{$item->link_wa}}" target="_blank">Chat Customer</a></td>

                            @if ($item->status==0)
                            <td>
                                <a class="addAkun" data-toggle="modal" data-target="#modalAkun" data-id="{{$item->id}}"
                                    data-varian="{{$item->id_produk}}"><button type="button"
                                        class="btn btn-block btn-success btn-sm">Add</button></a>
                            </td>
                            <td> <a class="btn btn-primary btn-sm editTransaksi" data-toggle="modal"
                                    title="Edit Pembelian" data-id="{{$item->id}}" data-target="#modalTransaksi"><i
                                        class="fa fa-fw fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger btn-sm deleteTransaksi" data-toggle="modal" title="Delete"
                                    data-target="#modalTransaksi" data-id="{{$item->id}}"><i
                                        class="fa fa-fw fa-trash-o"></i></a>
                                <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi"
                                    data-target="#modalTransaksi"><i class="fa fa-fw fa-eye"></i></a>
                            </td>
                            @else
                            {{-- Akun --}}
                            <td>{{$item->email==null ? $item->nomor_akun:$item->email}}</td>
                            <td> <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi"
                                    data-target="#viewModal"><i class="fa fa-fw fa-eye"></i></a>
                            </td>
                            {{-- Akun --}}
                            @endif
                            <td><input type="checkbox" class="status-checkbox" name="id[]" id="done"
                                    data-id="{{$item->id}}" data-status="{{$item->status}}" {{$item->status == 2 ?
                                'checked' : ''}}>
                            </td>

                        </tr>
                        @php
                        $i+=1;
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


@include('Menu.Transaksi.Modal.modalTransaksi')
@include('Menu.Transaksi.Modal.modalPayment')
@include('Menu.Transaksi.Modal.modalAkun')
<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    // DataTable
        var transaksiTable=$("#transaksiTable").DataTable({
            'paging': true,
            'dom': 'lBfrtip',
            'buttons': ['excel'],
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            'info': true,
            'autoWidth': false,
            'scrollX': true
                // 'columnDefs': [
                //     { width: '3%', targets: 0 }, // Example width settings
                //     { width: '15%', targets: 1 },
                //     { width: '15%', targets: 2 },
                //     { width: '15%', targets: 3 },
                //     { width: '15%', targets: 4 },
                //     { width: '15%', targets: 5 },
                //     { width: '30%', targets: 6 },
                //     { width: '30%', targets: 7 },
                //     { width: '30%', targets: 8 },
                //     { width: '30%', targets: 9 },
                //     { width: '30%', targets: 10 },
                //     { width: '30%', targets: 11 },
                // ]
        });

        transaksiTable.on('order.dt', function() {
            transaksiTable.columns.adjust();
            transaksiTable.header.adjust();
        });

        transaksiTable.buttons().container().appendTo('#transaksiTable_wrapper .col-md-6:eq(0)');
        $('.dataTables_filter').css({
        'display': 'flex',
        'justify-content': 'flex-end',
        'align-items': 'center'
        });

    // DataTable
    // Showing Modal Form Store
            $(".addTransaksi").click(function(){
                try {
                    $.ajax({
                        url:'/Transaksi/fetch/form',
                        type:'get',
                        dataType:'json',
                        success:function(res){
                            $("#modalTransaksi .modal-body").html('');
                            $("#modalTransaksi .modal-title").html(`
                                Add Transaksi
                            `);
                            $("#modalTransaksi .modal-body").html(`
                                <form class="formAddTransaksi" method="post">
                                    @csrf
                                     <input type="hidden" name="user" value="{{Auth::user()->id}}">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>WA Customer</label>
                                                <input type="text" name="wa" id="wa" class="form-control"
                                                    placeholder="Masukkan WA Customer">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Nama Customer</label>
                                                <input type="text" name="customer" class="form-control" id="customer"
                                                    placeholder="Masukkan Nama Customer">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Last Transaction</label>
                                                <input type="text" name="lastTransaction" class="form-control" id="lastTransaction"
                                                    placeholder="Last Transaction" readonly>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Kode Transaksi</label>
                                                <input type="text" name="kode" id="" class="form-control"
                                                    placeholder="Masukkan Kode Transaksi">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Platform</label>
                                                <select name="platform" id="platform" class="form-control select2" style="width: 100%;">
                                                    <option value="">--Choose Platform--</option>
                                                    ${res.platforms.map(p => `
                                                        <option value="${p.id}" data-platform="${p.nama_platform}">${p.nama_platform}</option>
                                                    `).join('')}
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Sumber Transaksi</label>
                                                <select name="sumber" id="sumber" class="form-control select2" style="width: 100%;">

                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Payment Method</label>
                                                <select name="payment" id="payment" class="form-control select2" style="width: 100%;">
                                                    <option value="">-- Choose Payment Method --</option>
                                                        ${res.payments.map(p => `
                                                            <option value="${p.id}">${p.nama_payment}</option>
                                                        `).join('')}
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label>Status Pembayaran</label>
                                                <select name="status_bayar" id="status_bayar" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option value="">Pilih Status Pembayaran</option>
                                                    <option value="Lunas">Lunas</option>
                                                    <option value="Kredit">Kredit</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group" id="bukti_bayar">
                                            <label for="bukti">Bukti Pembayaran</label>
                                            <div id="paste-area" style="border: 1px solid #ccc; padding: 10px; min-height: 100px;">
                                            </div>
                                            <input type="file" id="bukti" name="bukti" accept="image/*" style="display: none;">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Promo</label>
                                            <input type="checkbox" class="status-checkbox" name="promo" id="promo" value="1">
                                        </div>
                                        <div style="float: right;">
                                            <button type="button" class="btn btn-success add"><i class="fa fa-plus-circle"> &nbsp;Add
                                                    Item</i></button>
                                            <button type="button" class="btn btn-danger delete"><i class="fa fa-minus-circle">&nbsp;Delete
                                                    Item</i></button>
                                        </div>
                                        <center>
                                            <table class="table table-bordered table-hover" id="myTable" style="width: 70%">
                                                <thead>
                                                    <tr>
                                                        <td style="width:50%">
                                                            <center>Produk</center>
                                                        </td>
                                                        <td style="width:50%">
                                                            <center>Harga</center>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                {{-- <label for="item">Item</label> --}}
                                                                <select name="produk[]" id="produk_1" class="form-control select2 produkDropdown"
                                                                    style="width: 100%">

                                                                </select>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" name="harga[]" class="form-control price-field"
                                                                    id="harga_1" readonly>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </center>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                                </form>
                            `);
                            $("#modalTransaksi .select2").select2();

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

    // Showing Modal Form Update
        $(".editTransaksi").click(function(){
            var id=$(this).data('id');
            try {
                $.ajax({
                    url:'/Transaksi/fetch/form/update?id_trans='+id,
                    type:'get',
                    dataType:'json',
                    success:function(res){
                        $("#modalTransaksi .modal-body").html('');
                        $("#modalTransaksi .modal-title").html(`
                            Add Transaksi
                        `);
                        $("#modalTransaksi .modal-body").html(`
                            <form class="formUpdateTransaksi" method="post">
                                @csrf
                                    <input type="hidden" name="user" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="id" value="${res.transactions[0].id}">
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>WA Customer</label>
                                            <input type="text" name="wa" id="wa" class="form-control"
                                                value="${res.transactions[0].wa}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Nama Customer</label>
                                            <input type="text" name="customer" class="form-control" id="customer"
                                                value="${res.transactions[0].nama_customer}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Last Transaction</label>
                                            <input type="text" name="lastTransaction" class="form-control" id="lastTransaction"
                                                placeholder="Last Transaction" readonly>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Kode Transaksi</label>
                                            <input type="text" name="kode" id="" class="form-control"
                                                value="${res.transactions[0].kode_transaksi}">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Platform</label>
                                            <select name="platform" id="platform" class="form-control select2" style="width: 100%;">
                                                <option value="">--Choose Platform--</option>
                                                ${res.platforms.map(p => `
                                                    <option value="${p.id}" ${res.transactions[0].id_platform==p.id ? "selected":""} data-platform="${p.nama_platform}">${p.nama_platform}</option>
                                                `).join('')}
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label>Sumber Transaksi</label>
                                            <select name="sumber" id="sumber" class="form-control select2" style="width: 100%;">
                                                ${res.sumbers.map(s => `
                                                    <option value="${s.id}" ${res.transactions[0].id_toko==s.id ? "selected":""} data-platform="${s.nama_sumber}">${s.nama_sumber}</option>
                                                `).join('')}
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label>Payment Method</label>
                                            <select name="payment" id="payment" class="form-control select2" style="width: 100%;">
                                                <option value="">-- Choose Payment Method --</option>
                                                    ${res.payments.map(p => `
                                                        <option value="${p.id}">${p.nama_payment}</option>
                                                    `).join('')}
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label>Status Pembayaran</label>
                                            <select name="status_bayar" id="status_bayar" class="form-control select2"
                                                style="width: 100%;">
                                                <option value="">Pilih Status Pembayaran</option>
                                                <option value="Lunas" ${res.transactions[0].status_pembayaran=="Lunas" ? "selected":""}>Lunas</option>
                                                <option value="Kredit" ${res.transactions[0].status_pembayaran=="Kredit" ? "selected":""}>Kredit</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group" id="bukti_bayar">
                                        <label for="bukti">Bukti Pembayaran</label>
                                        <div id="paste-area" style="border: 1px solid #ccc; padding: 10px; min-height: 100px;">
                                        </div>
                                        <input type="file" id="bukti" name="bukti" accept="image/*" style="display: none;">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Promo</label>
                                        <input type="checkbox" class="status-checkbox" name="promo" id="promo" value="1">
                                    </div>
                                    <center>
                                        <table class="table table-bordered table-hover" id="myTable" style="width: 70%">
                                            <thead>
                                                <tr>
                                                    <td style="width:50%">
                                                        <center>Produk</center>
                                                    </td>
                                                    <td style="width:50%">
                                                        <center>Harga</center>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            {{-- <label for="item">Item</label> --}}
                                                            <select name="produk" id="produk_1" class="form-control select2 produkDropdown"
                                                                style="width: 100%">
                                                                    ${res.products.map(p => `
                                                                        <option value="${p.id}" ${res.transactions[0].id_price==p.id ? "selected":""} data-harga="${p.harga}">${p.detail}</option>
                                                                    `).join('')}
                                                            </select>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="number" name="harga" class="form-control price-field"
                                                                id="harga_1" value="${res.transactions[0].harga}" readonly>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </center>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ">Update</button>
                                </div>
                            </form>
                        `);
                        $("#modalTransaksi .select2").select2();

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
    // Dependent Platform, Sumber Transaksi, Produk
            $(document).on('change','#platform',function(){
                var platform=$('#platform').val();
                var namaPlatform = $('#platform option:selected').data('platform');

                if (namaPlatform=="Shopee") {
                    $("#status_bayar").val("Kredit").trigger('change');
                } else {
                    $("#status_bayar").val("Lunas").trigger('change');

                }
                $.ajax({
                    url:'/Transaksi/fetch/sumber?id_platform='+platform,
                    type:'get',
                    dataType:'json',
                    success:function(res){
                        $("#sumber").html('');
                        $.each(res.sumbers,function(key,value){
                            $('#sumber').html(`
                                <option value="">--Choose Sumber Transaksi--</option>
                            `);
                            $('#sumber').append(`<option value="${value.id}">${value.nama_sumber}</option>`);
                        });
                    }
                });
            });

            $(document).on('change','#sumber',function(key,value){
                var sumber =$('#sumber').val();
                $.ajax({
                    url:'/Transaksi/fetch/produk?id_toko='+sumber,
                    type:'get',
                    dataType:'json',
                    success:function(res){
                        $('.produkDropdown').html(``);
                        $.each(res.products,function(key,value){
                            $('.produkDropdown').html(`
                            <option value="">--Choose Product--</option>
                            `);
                            $('.produkDropdown').append(`
                                <option value="${value.id}" data-harga="${value.harga}">${value.detail}</option>
                            `);
                        });
                    }
                });
            });

            $(document).on('change','.produkDropdown',function(){
                var idProdukToko=$(this).val();
                var currentId = $(this).attr('id');
                var number = currentId.split('_')[1];
                var hargaInput = $('#harga_' + number);
                var selectedOption = $(this).find('option:selected');
                var harga = selectedOption.data('harga');
                hargaInput.val(harga);

            });
    // Dependent Platform, Sumber Transaksi, Produk

    // Action Modal Form Store
        $(document).on("submit",".formAddTransaksi",function(e){
            e.preventDefault();
            var form = $('.formAddTransaksi');
            var url = '/Transaksi/Store';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    transaksiTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalTransaksi").modal('hide');
                    $.each(res.transactions,function(key,value){
                        var row=`
                         <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_customer}</td>
                            <td>${value.wa}</td>
                            <td>${value.nama_platform} ${value.nama_sumber}</td>
                            <td>${value.detail}</td>
                            <td>${value.tanggal_pembelian}</td>
                            <td>${value.tanggal_berakhir}</td>
                            <td>${value.status_pembayaran}</td>
                            <td><a href="${value.link_wa}" target="_blank">Chat Customer</a></td>

                            `;
                            if (value.status == 0) {
                                row += `
                                    <td>
                                        <a class="addAkun" data-toggle="modal" data-target="#modalAkun"
                                    data-id="${value.id}" data-varian=${value.id_produk}><button type="button"
                                        class="btn btn-block btn-success btn-sm">Add</button></a>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm editTransaksi" data-id="${value.id}" data-toggle="modal" title="Edit Pembelian" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-pencil-square-o"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteTransaksi" data-id="${value.id}" data-toggle="modal" title="Delete" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                        </a>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                `;
                            } else {
                                row += `<td>${value.email==null ? value.nomor_akun:value.email }</td>`;

                                row += `
                                    <td>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi" data-target="#viewModal">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                `;
                            }

                            row += `
                                <td>
                                    <input type="checkbox" class="status-checkbox" name="id[]" id="done" data-id="${value.id}" data-status="${value.status}}" ${value.status == 2 ?
                                'checked' : ''}>
                                </td>
                                </tr>
                            `;

                            transaksiTable.row.add($(row));
                    });
                    transaksiTable.draw();
                }
            })
        });
    // Action Modal Form Store

    // Action Modal Form Store
        $(document).on("submit",".formUpdateTransaksi",function(e){
            e.preventDefault();
            var form = $('.formUpdateTransaksi');
            var url = '/Transaksi/Update';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    transaksiTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalTransaksi").modal('hide');
                    $.each(res.transactions,function(key,value){
                        var row=`
                         <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_customer}</td>
                            <td>${value.wa}</td>
                            <td>${value.nama_platform} ${value.nama_sumber}</td>
                            <td>${value.detail}</td>
                            <td>${value.tanggal_pembelian}</td>
                            <td>${value.tanggal_berakhir}</td>
                            <td>${value.status_pembayaran}</td>
                            <td><a href="${value.link_wa}" target="_blank">Chat Customer</a></td>

                            `;
                            if (value.status == 0) {
                                row += `
                                    <td>
                                        <a class="addAkun" data-toggle="modal" data-target="#modalAkun"
                                    data-id="${value.id}" data-varian=${value.id_produk}><button type="button"
                                        class="btn btn-block btn-success btn-sm">Add</button></a>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm editTransaksi" data-id="${value.id}" data-toggle="modal" title="Edit Pembelian" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-pencil-square-o"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteTransaksi" data-id="${value.id}" data-toggle="modal" title="Delete" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                        </a>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                `;
                            } else {
                                row += `<td>${value.email==null ? value.nomor_akun:value.email }</td>`;

                                row += `
                                    <td>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi" data-target="#viewModal">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                `;
                            }

                            row += `
                                <td>
                                    <input type="checkbox" class="status-checkbox" name="id[]" id="done" data-id="${value.id}" data-status="${value.status}}" ${value.status == 2 ?
                                'checked' : ''}>
                                </td>
                                </tr>
                            `;

                            transaksiTable.row.add($(row));
                    });
                    transaksiTable.draw();
                }
            })
        });
    // Action Modal Form Store

    // Action Modal Provide Akun
        $(document).on('submit','.formProvideAkun',function(e){
            e.preventDefault();
            var form = $('.formProvideAkun');
            var formData = new FormData(form[0]);
            var url='/Transaksi/Provide/Akun/Store';

            $.ajax({
                url:url,
                type:'post',
                data:formData,
                contentType: false,
                processData: false,
                success:function(res){
                    transaksiTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalAkun").modal('hide');
                    $.each(res.transactions,function(key,value){
                        var row=`
                         <tr>
                            <td>${key+1}</td>
                            <td>${value.nama_customer}</td>
                            <td>${value.wa}</td>
                            <td>${value.nama_platform} ${value.nama_sumber}</td>
                            <td>${value.detail}</td>
                            <td>${value.tanggal_pembelian}</td>
                            <td>${value.tanggal_berakhir}</td>
                            <td>${value.status_pembayaran}</td>
                            <td><a href="${value.link_wa}" target="_blank">Chat Customer</a></td>

                            `;
                            if (value.status == 0) {
                                row += `
                                    <td>
                                        <a class="addAkun" data-toggle="modal" data-target="#modalAkun"
                                    data-id="${value.id}" data-varian=${value.id_produk}><button type="button"
                                        class="btn btn-block btn-success btn-sm">Add</button></a>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm editTransaksi" data-id="${value.id}" data-toggle="modal" title="Edit Pembelian" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-pencil-square-o"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteTransaksi" data-id="${value.id}" data-toggle="modal" title="Delete" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                        </a>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi" data-target="#modalTransaksi">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                `;
                            } else {
                                row += `<td>${value.email==null ? value.nomor_akun:value.email }</td>`;

                                row += `
                                    <td>
                                        <a class="btn btn-info btn-sm" data-toggle="modal" title="Bukti Transaksi" data-target="#viewModal">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                `;
                            }

                            row += `
                                 <td>
                                    <input type="checkbox" class="status-checkbox" name="id[]" id="done" data-id="${value.id}" data-status="${value.status}}" ${value.status == 2 ?
                                'checked' : ''}>
                                </td>
                                </tr>
                            `;

                            transaksiTable.row.add($(row));
                    });
                    transaksiTable.draw();
                }
            });


        });
    // Action Modal Provide Akun

    // Select All Check Box
        $(document).on('change','#selectAll',function(){
            var isChecked = $(this).is(':checked');
            $('.status-checkbox').prop('checked', isChecked).trigger('change');
        });
    // Select All Check Box

    // Update Status Check Box
        $(document).on('change','.status-checkbox',function(){
            var isChecked = $(this).is(':checked');
            var itemId = $(this).data('id');
            var status = $(this).data('status');

            $.ajax({
                url: '/Transaksi/Today/updateStatus', // Update the URL to your Laravel route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: itemId,
                    status: isChecked ? 2 : 1
                },
                success: function (response) {
                    // Handle success response
                    console.log('Status updated successfully:', response);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error('Error updating status:', error);
                }
            });

        });

    // Update Status Check Box

    });
</script>
@endsection