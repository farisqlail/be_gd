@guest
<script>
    window.location = "/";
</script>
@endguest

@auth


@extends('template')
@section('content_header')
Profile
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Member</li>
<li class="active">Profile</li>
@endsection

@section('main_content')

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="../../dist/img/Logo GMG.png"
                    alt="User profile picture">

                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                <p class="text-muted text-center">{{ Auth::user()->jabatan }}</p>

                {{-- <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Followers</b> <a class="pull-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                        <b>Following</b> <a class="pull-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="pull-right">13,287</a>
                    </li>
                </ul> --}}

                {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        {{-- <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

                <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                <p>
                    <span class="label label-danger">UI Design</span>
                    <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
        </div> --}}
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#generals" data-toggle="tab">General Info</a></li>
                {{-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li> --}}
                <li><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="generals">
                    <form class="form-horizontal" method="POST" action="/Member/Bio/Update">
                        @csrf
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Name</label>
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" id="inputName"
                                    value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="inputEmail"
                                    value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Job Title</label>

                            <div class="col-sm-10">
                                <input type="text" name="jabatan" class="form-control" id="inputName"
                                    value="{{ Auth::user()->jabatan }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- Account Setting --}}
                <div class="tab-pane" id="settings">
                    <form class="form-horizontal" method="POST" action="/Member/Account/Update">
                        @csrf
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail"
                                    value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-eye" id="password_vis" onclick="visibilePass()"></i>
                                    </div>

                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="Input New Password">


                                </div>
                            </div>

                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Retype Password</label>

                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-eye" id="password_vis" onclick="visibilePass2()"></i>
                                    </div>

                                    <input type="password" class="form-control" id="password_confirm"
                                        placeholder="Retype Password">


                                </div>
                            </div>

                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-10">
                                <div style="margin-top: 7px;" id="CheckPasswordMatch"></div>
                            </div>

                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id="btn_account" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    function visibilePass() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }

            }

            function visibilePass2() {
                var x = document.getElementById("password_confirm");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }

            }

            $(document).ready(function() {
                $("#password").on('keyup', function() {
                    var password = $("#password").val();
                    if (password.length < 6) {
                        $("#CheckPasswordMatch").html("Please enter at least 6 characters.").css("color",
                            "red");
                        document.getElementById("btn_account").disabled = true;
                    } else {
                        document.getElementById("btn_account").disabled = false;
                    }
                });
                $("#password_confirm").on('keyup', function() {
                    var password = $("#password").val();
                    var confirmPassword = $("#password_confirm").val();
                    if (confirmPassword != password) {
                        $("#CheckPasswordMatch").html("Please enter the same value again.").css("color", "red");
                        document.getElementById("btn_account").disabled = true;
                    } else {
                        $("#CheckPasswordMatch").html("Password match !").css("color", "green");
                        document.getElementById("btn_account").disabled = false;
                    }
                });

            });
</script>
@endsection
@endauth