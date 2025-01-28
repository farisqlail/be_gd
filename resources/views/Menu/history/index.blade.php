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

@endsection