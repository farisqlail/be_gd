@extends('template')  
  
@section('content_header')  
Edit Video Tutorial  
@endsection  
  
@section('breadcrumb')  
<li><a href="#"><i class="fa fa-pie-chart"></i>Video Tutorials</a></li>  
<li class="active">Edit</li>  
@endsection  
  
@section('main_content')  
<div class="box box-default">  
    <div class="box-header">  
        <h3 class="box-title">Edit Video Tutorial</h3>  
    </div>  
    <div class="box-body">  
        @if(session('success'))  
            <div class="alert alert-success">  
                {{ session('success') }}  
            </div>  
        @endif  
        <form action="{{ route('video_tutorials.update', $videoTutorial->id) }}" method="POST">  
            @csrf  
            @method('PUT')  
            <div class="form-group">  
                <label for="name">Name</label>  
                <input type="text" class="form-control" name="name" id="name" value="{{ $videoTutorial->name }}" required>  
            </div>  
            <div class="form-group">  
                <label for="link_video">Link Video</label>  
                <input type="url" class="form-control" name="link_video" id="link_video" value="{{ $videoTutorial->link_video }}" required>  
            </div>  
            <div class="form-group">  
                <label for="account">Account</label>  
                <input type="text" class="form-control" name="account" id="account" value="{{ $videoTutorial->account }}" required>  
            </div>  
            <button type="submit" class="btn btn-primary">Update</button>  
            <a href="{{ route('video_tutorials.index') }}" class="btn btn-default">Cancel</a>  
        </form>  
    </div>  
</div>  
@endsection  
