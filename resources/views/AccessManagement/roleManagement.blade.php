@guest
<script>
    window.location = "/";
</script>
@endguest
@auth

@extends('template')

@section('content_header')
Role Management
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-book"></i>Home</a></li>
<li class="active">Role Management</li>
@endsection

@section('content')
{{--
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="col-md-12">
                    <div class="col-md-2" style="margin-left: -2%">
                        <a class="btn btn bg-olive margin" data-toggle="modal" data-target="#addRole"><i
                                class="fa fa-plus"></i>
                            <span>&nbsp; Add Role</span></a>
                    </div>
                    <div class="col-md-2" style="margin-left: -6%">
                        <a class="btn btn bg-olive margin" data-toggle="modal" data-target="#addPermission"><i
                                class="fa fa-plus"></i>
                            <span>&nbsp; Add permission</span></a>
                    </div>
                </div>
            </div>


            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h4 class="box-title">Roles</h4>
                            </div>
                            <div class="box-body">
                                <form action="/AccessManagement/Update" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <select name="role" id="role" class="form-control select2">
                                            <option value="">Pilih Role</option>
                                            @foreach ($role as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer" id="footerRole">

                            </div>
                        </div>
                        <!-- /. box -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-8">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">Permission List</h4>
                            </div>
                            <div class="box-body" id="PermissionList">

                                <div class="form-group">
                                    <label for="">Can Access Modul :</label>
                                    <br>
                                    @foreach ($permission as $item)
                                    <input type="checkbox" name="permissions[]" id="{{$item->id}}"
                                        style="transform: scale(1.5); margin-right: 5px;" class="flat-red"
                                        value="{{$item->name}}"> <b>
                                        {{$item->name}}</b> <br>
                                    @endforeach

                                </div>
                                <button type="submit" class="btn btn-primary">Save </button>
                                </form>

                            </div>
                            <!-- /.box-body -->

                        </div>
                        <!-- /. box -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

{{-- Modal Add Role Name --}}
<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addVarian" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Role</h3>
            </div>
            <div class="modal-body">
                <form role="form" action="/AccessManagement/Role/Store" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama">Role Name</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama Role">
                        </div>

                    </div>
                    <!-- /.box-body -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save </button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal Add Role Name --}}

{{-- Modal Add Permission --}}
<div class="modal fade" id="addPermission" tabindex="-1" role="dialog" aria-labelledby="addVarian" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Permission</h3>
            </div>
            <div class="modal-body">
                <form role="form" action="/AccessManagement/Permission/Store" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nama">Permission Name</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama Permission">
                        </div>

                    </div>
                    <!-- /.box-body -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save </button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal Add Permission --}}

<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#role").on("change",function(){
            $(".flat-red").prop('checked', false);
            roleName=$("#role").val();
            $.ajax({
                url:"{{url ('AccessManagement/fetchPermission')}}",
                type:"post",
                data:{
                    role:roleName,
                    _token:'{{csrf_token()}}',
                },
                dataType:'json',
                success:function(res){
                    $.each(res.permission,function(key,value){

                            $('#' + value.id).prop('checked', value.name);

                    });
                }

            });
        });
    });
</script>
@endsection
@endauth