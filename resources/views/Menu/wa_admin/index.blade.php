@extends('template')  
  
@section('content_header')  
    WA Admin List  
@endsection  
  
@section('breadcrumb')  
    <li><a href="#"><i class="fa fa-user"></i>Home</a></li>  
    <li class="active">WA Admin</li>  
@endsection  
  
@section('main_content')  
<div class="row">  
    <div class="col-xs-12">  
        <div class="box">  
            <div class="box-header">  
                <a href="{{ route('wa_admin.create') }}" class="btn btn bg-olive margin addProduk">  
                    <i class="fa fa-plus"></i> <span>&nbsp; Add WA Admin</span>  
                </a>  
            </div>  
  
            <div class="box-body">  
                <table class="table table-bordered table-striped">  
                    <thead>  
                        <tr>  
                            <th>#</th>  
                            <th>Name</th>  
                            <th>WhatsApp</th>  
                            <th>Actions</th>  
                        </tr>  
                    </thead>  
                    <tbody>  
                        @foreach ($waAdmins as $waAdmin)  
                        <tr>  
                            <td>{{ $loop->iteration }}</td>  
                            <td>{{ $waAdmin->name }}</td>  
                            <td>{{ $waAdmin->wa }}</td>  
                            <td>  
                                <a href="{{ route('wa_admin.edit', $waAdmin->id) }}" class="btn btn-warning btn-sm">Edit</a>  
                                <form action="{{ route('wa_admin.destroy', $waAdmin->id) }}" method="POST" style="display:inline-block;">  
                                    @csrf  
                                    @method('DELETE')  
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>  
                                </form>  
                            </td>  
                        </tr>  
                        @endforeach  
                    </tbody>  
                </table>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection  
