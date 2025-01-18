@extends('template')  
  
@section('content_header')  
User Count  
@endsection  
  
@section('main_content')  
<div class="row">  
    <div class="col-xs-12">  
        <div class="box">  
            <div class="box-header">  
                <h3>Current User Count: {{ $userCount->count ?? 0 }}</h3>  
                <a href="{{ route('user_counts.increment') }}" class="btn btn bg-olive margin">  
                    <i class="fa fa-plus"></i> <span>&nbsp; Increment User Count</span>  
                </a>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection  
