@extends('template')

@section('content_header')
Edit Trending
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('promos.index') }}">Trending</a></li>
<li class="active">Edit Trending</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form action="{{ route('trendings.update', $trending->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Nama Trending</label>
                        <input type="text" name="title" class="form-control" value="{{ $trending->title }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="caption" class="form-label">Caption</label>
                        <textarea class="form-control" id="caption" name="caption" rows="3" required>{{ $trending->caption }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload Gambar</label>
                        <input type="file" name="image" class="form-control">
                        @if ($trending->image)
                        <p class="mt-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $trending->image) }}" alt="{{ $trending->title }}" style="max-width: 150px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
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