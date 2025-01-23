@extends('template')

@section('content_header')
Banner
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-pie-chart"></i>Banner</a></li>
<li class="active">Index</li>
@endsection

@section('main_content')
<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Banner</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('banners.create') }}" class="btn btn-primary">Create Banner</a>
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
                    <th>Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                <tr>
                    <td>{{ $banner->name }}</td>
                    <td><img src="{{ asset('storage/' . $banner->images) }}" width="100" alt="{{ $banner->name }}"></td>
                    <td>
                        <a href="{{ route('banners.edit', $banner) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('banners.destroy', $banner) }}" method="POST" style="display:inline;">
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