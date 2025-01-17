@extends('template')

@section('content_header')
Add Payment
@endsection

@section('breadcrumb')
<li><a href="{{ route('payments.index') }}"><i class="fa fa-money"></i>Payments</a></li>
<li class="active">Add Payment</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Tambah Payment</h3>
            </div>
            <div class="box-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="va">VA</label>
                        <input type="text" name="va" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name_account">Account Name</label>
                        <input type="text" name="name_account" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection