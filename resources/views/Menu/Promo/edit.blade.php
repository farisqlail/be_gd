@extends('template')

@section('content_header')
Edit Promo
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('promos.index') }}">Promo</a></li>
<li class="active">Edit Promo</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form action="{{ route('promos.update', $promo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Nama Promo</label>
                        <input type="text" name="title" class="form-control" value="{{ $promo->title }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link video youtube</label>
                        <input type="url" name="link_video" class="form-control" value="{{ $promo->link_video }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $promo->deskripsi }}</textarea>
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
