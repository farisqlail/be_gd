@extends('template')

@section('content_header')
Add Promo
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('promos.index') }}">Promo</a></li>
<li class="active">Add Promo</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form action="{{ route('promos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Promo</label>
                        <input type="text" name="title" class="form-control" placeholder="Promo 12.12" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link video youtube</label>
                        <input type="url" name="link_video" class="form-control" placeholder="https://www.....">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi promo..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-label">Gambar Promo</label>
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