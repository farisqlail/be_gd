@extends('template')  
  
@section('content_header')  
Video Tutorials  
@endsection  
  
@section('breadcrumb')  
<li><a href="#"><i class="fa fa-pie-chart"></i>Video Tutorials</a></li>  
<li class="active">Index</li>  
@endsection  
  
@section('main_content')  
<div class="box box-default">  
    <div class="box-header">  
        <h3 class="box-title">Video Tutorials</h3>  
        <div class="box-tools pull-right">  
            <a href="{{ route('video_tutorials.create') }}" class="btn btn-primary">Create New</a>  
        </div>  
    </div>  
    <div class="box-body">  
        @if(session('success'))  
            <div class="alert alert-success">  
                {{ session('success') }}  
            </div>  
        @endif  
        <table class="table table-bordered table-hover">  
            <thead>  
                <tr>  
                    <th>ID</th>  
                    <th>Name</th>  
                    <th>Link Video</th>  
                    <th>Account</th>  
                    <th>Actions</th>  
                </tr>  
            </thead>  
            <tbody>  
                @foreach ($videoTutorials as $videoTutorial)  
                    <tr>  
                        <td>{{ $videoTutorial->id }}</td>  
                        <td>{{ $videoTutorial->name }}</td>  
                        <td>{{ $videoTutorial->link_video }}</td>  
                        <td>{{ $videoTutorial->account }}</td>  
                        <td>  
                            <a href="{{ route('video_tutorials.edit', $videoTutorial->id) }}" class="btn btn-warning">Edit</a>  
                            <form action="{{ route('video_tutorials.destroy', $videoTutorial->id) }}" method="POST" style="display:inline;">  
                                @csrf  
                                @method('DELETE')  
                                <button type="submit" class="btn btn-danger">Delete</button>  
                            </form>  
                        </td>  
                    </tr>  
                @endforeach  
            </tbody>  
        </table>  
    </div>  
</div>  
@endsection  
