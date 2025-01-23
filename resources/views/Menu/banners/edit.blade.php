@extends('template')  
  
@section('content_header')  
Banner
@endsection  
  
@section('breadcrumb')  
<li><a href="#"><i class="fa fa-pie-chart"></i>Edit Benner</a></li>  
<li class="active">Edit</li>  
@endsection  
  
@section('main_content')  
<div class="container">  
    <h1>Edit Banner</h1>  
    <form action="{{ route('banners.update', $banner) }}" method="POST" enctype="multipart/form-data">  
        @csrf  
        @method('PUT')  
        <div class="form-group">  
            <label for="name">Name</label>  
            <input type="text" name="name" class="form-control" value="{{ $banner->name }}" required>  
        </div>  
        <div class="form-group">  
            <label for="images">Image</label>  
            <input type="file" name="images" class="form-control">  
            <img src="{{ asset('storage/' . $banner->images) }}" width="100" alt="{{ $banner->name }}">  
        </div>  
        <button type="submit" class="btn btn-primary">Update</button>  
    </form>  
</div>  
@endsection  
