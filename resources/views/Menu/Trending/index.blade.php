@extends('template')
@section('content_header')
Master Trending
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Trending</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a href="{{ route('trendings.create') }}" class="btn btn bg-olive margin addProduk">
                    <i class="fa fa-plus"></i> <span>&nbsp; Add Trending</span>
                </a>
            </div>

            <!-- Table to display list of promos -->
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>image</th>
                            <th>Title</th>
                            <th>Caption</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trendings as $index => $trending)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($trending->image)
                                <img src="{{ asset('storage/' . $trending->image) }}" alt="{{ $trending->title }}" style="max-width: 100px;">
                                @endif

                            </td>
                            <td>{{ $trending->title }}</td>
                            
                            <td>{{ $trending->caption }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('trendings.edit', $trending->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('trendings.destroy', $trending->id) }}" method="POST" style="display:inline-block;">
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