@extends('template')

@section('content_header')
Add Trending
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('trendings.index') }}">Trending</a></li>
<li class="active">Add Trending</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form action="{{ route('trendings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Trending</label>
                        <input type="text" name="title" class="form-control" placeholder="Nama Film" required>
                    </div>
                    <div class="form-group">
                        <label for="caption" class="form-label">Caption</label>
                        <textarea class="form-control" id="caption" name="caption" rows="3" placeholder="Caption trending..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-label">Gambar Trending</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
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