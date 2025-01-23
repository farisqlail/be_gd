@extends('template')  
  
@section('content_header')  
Banner  
@endsection  
  
@section('breadcrumb')  
<li><a href="#"><i class="fa fa-pie-chart"></i>Add Banner</a></li>  
<li class="active">Add</li>  
@endsection  
  
@section('main_content')  
<div class="container">  
    <h1>Create Banner</h1>  
    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">  
        @csrf  
        <div class="form-group">  
            <label for="name">Name</label>  
            <input type="text" name="name" class="form-control" required>  
        </div>  
        <div class="form-group">  
            <label for="images">Image</label>  
            <input type="file" name="images" class="form-control" required>  
        </div>  
        <button type="submit" class="btn btn-primary">Create</button>  
    </form>  
</div>  
@endsection  
