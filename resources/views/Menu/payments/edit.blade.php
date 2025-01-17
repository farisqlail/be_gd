@extends('template')  
  
@section('content_header')  
Edit Payment  
@endsection  
  
@section('breadcrumb')  
<li><a href="{{ route('payments.index') }}"><i class="fa fa-money"></i>Payments</a></li>  
<li class="active">Edit Payment</li>  
@endsection  
  
@section('main_content')  
<div class="row">  
    <div class="col-xs-12">  
        <div class="box">  
            <div class="box-header">  
                <h3 class="box-title">Edit Payment</h3>  
            </div>  
            <div class="box-body">  
                <form action="{{ route('payments.update', $payment->id) }}" method="POST">  
                    @csrf  
                    @method('PUT')  
                    <div class="form-group">  
                        <label for="name">Name</label>  
                        <input type="text" name="name" class="form-control" value="{{ $payment->name }}" required>  
                    </div>  
                    <div class="form-group">  
                        <label for="va">Virtual Account (VA)</label>  
                        <input type="text" name="va" class="form-control" value="{{ $payment->va }}" required>  
                    </div>  
                    <div class="form-group">  
                        <label for="name_account">Name Account</label>  
                        <input type="text" name="name_account" class="form-control" value="{{ $payment->name_account }}" required>  
                    </div>  
                    <button type="submit" class="btn btn-primary">Update</button>  
                    <a href="{{ route('payments.index') }}" class="btn btn-default">Cancel</a>  
                </form>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection  
