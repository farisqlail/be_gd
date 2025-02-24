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

            <!-- /.box-header -->

            <div class="box-body">
                <table id="transaksiTable" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produk</th>
                            <th>Customer Name</th>
                            <th>Wa</th>
                            <th>Transaction Code</th>
                            <th>Purchase Date</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction['id'] }}</td>
                            <td>{{ $transaction['product_name'] }}</td>
                            <td>{{ $transaction['nama_customer'] }}</td>
                            <td>{{ $transaction['wa'] }}</td> <!-- Display WhatsApp number -->
                            <td>{{ $transaction['kode_transaksi'] }}</td>
                            <td>{{ $transaction['tanggal_pembelian'] }}</td>
                            <td>{{ $transaction['harga'] }}</td>
                            <td>{{ $transaction['status'] }}</td>
                        </tr>
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

<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // DataTable
        var transaksiTable = $("#transaksiTable").DataTable({
            'paging': true,
            'dom': 'lBfrtip',
            'buttons': ['excel'],
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
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
            //     { width:P '30%', targets: 6 },
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

    });
</script>
@endsection