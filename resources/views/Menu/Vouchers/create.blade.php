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
                        <label for="id_variance">Variance</label>
                        <select name="id_variance" id="id_variance" class="form-control" required>
                            <option value="">-- Select Variance --</option>
                            @foreach($variances as $variance)
                            <option value="{{ $variance->id }}">{{ $variance->variance_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_product_type">Product Type</label>
                        <select name="id_product_type" id="id_product_type" class="form-control" required>
                            <option value="">-- Select Product Type --</option>
                            @foreach($productTypes as $productType)
                            <option value="{{ $productType->id }}">{{ $productType->type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Voucher Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" name="amount" id="amount" required min="1">
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