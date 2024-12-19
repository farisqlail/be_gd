@extends('template')

@section('content_header')
Add Voucher
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('vouchers.index') }}">Voucher</a></li>
<li class="active">Add Voucher</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form action="{{ route('vouchers.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Voucher Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Voucher Name" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="1000" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection