@extends('template')

@section('content_header')
Master Voucher
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Voucher</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a href="{{ route('vouchers.create') }}" class="btn btn bg-olive margin addProduk">Add Voucher</a>
            </div>
            <div class="box-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Variance</th>
                            <th>Product Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $voucher->name }}</td>
                            <td>{{ $voucher->amount }}</td>
                            <td>{{ $voucher->variance ? $voucher->variance->variance_name : 'N/A' }}</td>
                            <td>{{ $voucher->productType ? $voucher->productType->type_name : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
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