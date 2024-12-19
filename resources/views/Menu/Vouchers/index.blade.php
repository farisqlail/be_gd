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
                <a href="{{ route('vouchers.create') }}" class="btn btn bg-olive margin addProduk">
                    <i class="fa fa-plus"></i> <span>&nbsp; Add Voucher</span>
                </a>
            </div>

            <!-- Table to display list of promos -->
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td>{{ $voucher->name }}</td>
                            <td>{{ $voucher->amount }}</td>
                            <td>
                                <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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