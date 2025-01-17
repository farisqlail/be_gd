@extends('template')  
  
@section('content_header')  
Master Payments  
@endsection  
  
@section('breadcrumb')  
<li><a href="#"><i class="fa fa-money"></i>Home</a></li>  
<li class="active">Payments</li>  
@endsection  
  
@section('main_content')  
<div class="row">  
    <div class="col-xs-12">  
        <div class="box">  
            <div class="box-header">  
                <a href="{{ route('payments.create') }}" class="btn btn bg-olive margin addProduk">  
                    <i class="fa fa-plus"></i> <span>&nbsp; Tambah Payment</span>  
                </a>  
            </div>  
  
            <div class="box-body">  
                <table class="table table-bordered table-striped">  
                    <thead>  
                        <tr>  
                            <th>#</th>  
                            <th>Name</th>  
                            <th>Virtual Account (VA)</th>  
                            <th>Name Account</th>  
                            <th>Actions</th>  
                        </tr>  
                    </thead>  
                    <tbody>  
                        @foreach ($payments as $payment)  
                        <tr>  
                            <td>{{ $loop->iteration }}</td>  
                            <td>{{ $payment->nama_payment }}</td>  
                            <td>{{ $payment->va }}</td>  
                            <td>{{ $payment->name_account }}</td>  
                            <td>  
                                <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Edit</a>  
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline-block;">  
                                    @csrf  
                                    @method('DELETE')  
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>  
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
