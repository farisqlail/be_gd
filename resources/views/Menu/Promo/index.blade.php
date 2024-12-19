@extends('template')
@section('content_header')
Master Promo
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Promo</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a href="{{ route('promos.create') }}" class="btn btn bg-olive margin addProduk">
                    <i class="fa fa-plus"></i> <span>&nbsp; Add Promo</span>
                </a>
            </div>

            <!-- Table to display list of promos -->
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>image</th>
                            <th>Nama Promo</th>
                            <th>Link Video</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promos as $index => $promo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($promo->image)
                                <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" style="max-width: 100px;">
                                @endif

                            </td>
                            <td>{{ $promo->title }}</td>
                            <td>
                                <a href="{{ $promo->link_video }}" target="_blank">{{ $promo->link_video }}</a>
                            </td>
                            <td>{{ $promo->deskripsi }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('promos.destroy', $promo->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection