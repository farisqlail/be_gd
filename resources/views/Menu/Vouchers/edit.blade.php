@extends('template')

@section('content_header')
Edit Voucher
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('vouchers.index') }}">Voucher</a></li>
<li class="active">Edit Voucher</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="id_variance">Variance</label>
                        <select name="id_variance" class="form-control" required>
                            <option value="">Select Variance</option>
                            @foreach($variances as $variance)
                            <option value="{{ $variance->id }}" {{ $variance->id == $voucher->id_variance ? 'selected' : '' }}>
                                {{ $variance->variance_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_product_type">Product Type</label>
                        <select name="id_product_type" class="form-control" required>
                            <option value="">Select Product Type</option>
                            @foreach($productTypes as $productType)
                            <option value="{{ $productType->id }}" {{ $productType->id == $voucher->id_product_type ? 'selected' : '' }}>
                                {{ $productType->type_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name">Voucher Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $voucher->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" value="{{ old('amount', $voucher->amount) }}" required min="1">
                    </div>


                    <button type="submit" class="btn btn-primary">Update Voucher</button>
                    <a href="{{ route('vouchers.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection