@extends('template')
@section('content_header')
Member
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Member</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin" data-toggle="modal" data-target="#addMember"><i
                        class="fa fa-plus"></i>
                    <span>&nbsp; Add Member</span></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="memberTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Job Title</th>
                            <th><i class="fa fa-bars"></i></th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($user as $item)
                        <tr>
                            <td>@php
                                echo $i;
                                @endphp</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>
                                <center> <a data-toggle="modal" class="edit-btn" data-target="#editModal-{{ $item->id }}"><i
                                            title="Edit Member" class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" data-target="#deleteModal-{{ $item->id }}"><i
                                            title="Delete Member" class="fa fa-fw fa-trash-o"
                                            style="margin-left: 20%"></i></a>
                                </center>
                            </td>
                        </tr>
                        @php
                        $i += 1;
                        @endphp
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

{{-- Modal Add Member --}}
<div class="modal fade" id="addMember" tabindex="-1" role="dialog" aria-labelledby="addMember" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addMember">Add Member</h3>
            </div>
            <div class="modal-body">
                <form role="form" action="/Member/Store" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="Job Title">Job Title</label>
                            <input type="text" class="form-control" id="Job Title" name="job_title"
                                placeholder="Job Title">
                        </div>
                        <div class="form-group">
                            <label for="Job Title">Roles</label>
                            <select name="id_role" class="form-control">
                                <option value="">--Choose Role--</option>
                                @foreach ($roles as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.box-body -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal Add Member --}}

{{-- Modal Update Member --}}
@foreach ($user as $item)
<div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="addMember"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addMember">Update Member</h3>
            </div>
            <div class="modal-body">
                <form role="form" action="/Member/Update" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="idUser" id="idUser" value="{{$item->id}}">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="{{$item->name}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{$item->email}}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                        </div> --}}
                        <div class="form-group">
                            <label for="Job Title">Job Title</label>
                            <input type="text" class="form-control" id="Job Title" name="job_title"
                                value="{{$item->jabatan}}">
                        </div>
                        <div class="form-group">
                            <label for="Job Title">Roles</label>
                            <select name="id_role" class="form-control">
                                <option value="">--Choose Role--</option>
                                @foreach ($roles as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.box-body -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- Modal Update Member --}}

{{-- Modal Delete Member --}}
@foreach ($user as $item)
<div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteMember"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="deleteMember">Delete Member</h3>
            </div>
            <div class="modal-body">
                <form role="form" action="/Member/Delete" method="POST">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <input type="hidden" name="idUser" id="idUser" value="{{$item->id}}">
                        <p>Apakah anda yakin ingin menghapus User {{Auth::user()->name}} ?</p>
                    </div>
                    <!-- /.box-body -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- Modal Delete Member --}}

<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var memberTable = $("#memberTable").DataTable({
            'paging': true,
            'dom': 'lBfrtip',
            'buttons': ['excel'],
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            'info': true,
            'autoWidth': false,
            'scrollX': true

        });
        $(".roles").html('');
        $('.edit-btn').click(function() {
            var id = $(this).data('target').split('-')[1];
            console.log(id);
            $.ajax({
                url: "{{url('Member/fetchUserRole')}}",
                type: 'post',
                data: {
                    idUser: id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(res) {
                    $(".roles").html('<option value="">-- Choose Role --</option>');
                    var roleName = "";
                    $.each(res.userRole, function(key, value) {
                        roleName = value.name;
                    });
                    $.each(res.roles, function(key, value) {
                        $(".roles").append('<option value="' + value.name + '" ' + (roleName === value.name ? 'selected' : '') + '>' + value.name + '</option>');
                    });

                }
            });
        });
    });
</script>
@endsection