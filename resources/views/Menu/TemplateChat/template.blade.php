@extends('template')
@section('content_header')
Master Template Chat
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Template Chat</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin addTemplate" data-toggle="modal" data-target="#modalTemplate"><i
                        class="fa fa-plus"></i>
                    <span>&nbsp; Add Template</span></a>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <table id="templateTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Produk</th>
                            <th>Template</th>
                            <th><i class="fa fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=1;
                        @endphp
                        @foreach ($templates as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->detail}}</td>
                            <td>{{$item->template}}</td>
                            <td>
                                <center> <a data-toggle="modal" class="updateTemplate" data-id="{{$item->id}}"
                                        data-target="#modalTemplate"><i title="Update Template"
                                            class="fa fa-fw fa-pencil-square-o"></i></a>
                                    <a data-toggle="modal" class="deleteTemplate" data-id="{{$item->id}}"
                                        data-target="#modalTemplate"><i title="Delete Template"
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </center>
                            </td>
                        </tr>
                        @php
                        $i +=1;
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


<div class="modal fade" id="modalTemplate" tabindex="-1" role="dialog" aria-labelledby="modalTemplate"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    // DataTable
        var templateTable=$("#templateTable").DataTable({
                'paging': true,
                'dom': 'lBfrtip',
                'buttons':['excel'],
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                "lengthMenu": [[ 25, 50,100, -1], [ 25, 50,100, "All"]],
                'info': true,
                'autoWidth': false,
                'scrollX':true,
                // 'columnDefs': [
                //     { width: '20%', targets: 0 }, // Example width settings
                //     { width: '30%', targets: 1 }
                // ]
        });

        templateTable.buttons().container().appendTo('#templateTable_wrapper .col-md-6:eq(0)');
        $('.dataTables_filter').css({
        'display': 'flex',
        'justify-content': 'flex-end',
        'align-items': 'center'
        });
        var filterVarian = '&nbsp;<select name="varian" id="filterVarian" class="form-control select2" style="width: auto;text-align:left;"><option value="">--Pilih Varian--</option></select> &nbsp;';
        $('.dataTables_filter').prepend(filterVarian);

        $.ajax({
            type:'get',
            url:'/Produk/Get/Filter',
            dataType:'json',
            success:function(res){
                $.each(res.variances,function(key,value){
                    var option_variances = `<option value="${value.id}">${value.variance_name}</option>`;
                    $("#filterVarian").append(option_variances);
                });
            }
        });

        $(document).on('change','#filterVarian',function(){
            var varian=$("#filterVarian").val();
            $.ajax({
                type:'post',
                url:'/Template/Filter',
                dataType:'json',
                data:{
                    _token:'{{csrf_token()}}',
                    varian:varian,
                },
                success:function(res){
                    templateTable.clear();
                    $.each(res.templates,function(key,value){
                        var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.detail}</td>
                                <td>${value.template}</td>
                                <td>
                                    <center> <a data-toggle="modal" class="updateTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Update Template"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Delete Template"
                                                class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                        `;
                        templateTable.row.add($(row));
                    });
                    templateTable.draw();
                }
            });
        });
    // DataTable
    // Showing Modal Form Store
        $(".addTemplate").click(function(){
            try {
                $.ajax({
                url:'/Template/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalTemplate .modal-body").html('');
                    $("#modalTemplate .modal-title").html(`
                        Add Template
                    `);
                    $("#modalTemplate .modal-body").html(`
                        <form class="formAddTemplate" method="post">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Produk</label>
                                    <select name="produk" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Product--</option>
                                        ${res.products.map(p => `
                                                <option value="${p.id}">${p.variance_name} ${p.type_name} ${p.durasi} ${p.ket_durasi}</option>
                                            `).join('')}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Template Chat</label>
                                    <textarea name="template" class="form-control" id="" cols="30" rows="20"></textarea>
                                </div>

                            </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ">Save</button>
                        </div>
                        </form>
                    `);
                    $("#modalTemplate .select2").select2();

                },
                error: function(xhr) {
                            // Handle error response
                            console.error("Error updating component:", xhr);
                }
            });
            } catch (error) {
                console.log(error);
            }
        });
    // Showing Modal Form Store

    // Action Modal Form Store
        $(document).on("submit",".formAddTemplate",function(e){
            e.preventDefault();
            var form = $('.formAddTemplate');
            var url = '/Template/Store';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    templateTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalTemplate").modal('hide');
                    $.each(res.templates,function(key,value){
                        var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.detail}</td>
                                <td>${value.template}</td>
                                <td>
                                    <center> <a data-toggle="modal" class="updateTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Update Template"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Delete Template"
                                                class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                        `;
                        templateTable.row.add($(row));
                    });
                    templateTable.draw();
                }
            })
        });
    // Action Modal Form Store

    // Showing Modal Form Update
        $(document).on('click','.updateTemplate',function(){
            try {
                $.ajax({
                url:'/Template/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalTemplate .modal-body").html('');
                    $("#modalTemplate .modal-title").html(`
                        Update Template
                    `);
                    $("#modalTemplate .modal-body").html(`
                        <form class="formUpdateTemplate" method="post">
                            @csrf
                            <div class="box-body">
                                <input type="hidden" name="id" value="${res.templates[0].id}">
                                    <div class="form-group">
                                        <label>Produk</label>
                                        <select name="produk" class="form-control select2" style="width: 100%;">
                                            <option value="">--Choose Product--</option>
                                            ${res.products_update.map(p => `
                                                    <option value="${p.id}" ${res.templates[0].id_produk==p.id ? "selected" : ""}>${p.variance_name} ${p.type_name} ${p.durasi} ${p.ket_durasi}</option>
                                                `).join('')}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Template Chat</label>
                                        <textarea name="template" class="form-control" id="" cols="30" rows="20">${res.templates[0].template}</textarea>
                                    </div>

                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                        </form>
                    `);
                    $("#modalTemplate .select2").select2();

                },
                error: function(xhr) {
                            // Handle error response
                            console.error("Error updating component:", xhr);
                }
            });
            } catch (error) {
                console.log(error);
            }
        });
    // Showing Modal Form Update

    // Action Modal Form Update
        $(document).on("submit",".formUpdateTemplate",function(e){
            e.preventDefault();
            var form = $('.formUpdateTemplate');
            var url = '/Template/Update';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    templateTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalTemplate").modal('hide');
                    $.each(res.templates,function(key,value){
                        var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.detail}</td>
                                <td>${value.template}</td>
                                <td>
                                    <center> <a data-toggle="modal" class="updateTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Update Template"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Delete Template"
                                                class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                        `;
                        templateTable.row.add($(row));
                    });
                    templateTable.draw();
                }
            })
        });
    // Action Modal Form Update

    // Showing Modal Form Delete
        $(document).on('click','.deleteTemplate',function(){
            try {
                $.ajax({
                url:'/Template/fetch/form',
                type:'get',
                dataType:'json',
                success:function(res){
                    $("#modalTemplate .modal-body").html('');
                    $("#modalTemplate .modal-title").html(`
                        Delete Template
                    `);
                    $("#modalTemplate .modal-body").html(`
                        <form class="formDeleteTemplate" method="post">
                            @csrf
                        <div class="box-body">
                            <input type="hidden" name="id" value="${res.templates[0].id}">
                            <input type="hidden" class="form-control" name="id" id="id" value="${res.templates[0].id}">
                               <p> Apakah anda yakin ingin menghapus template ini ? </p>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger ">Delete</button>
                        </div>
                        </form>
                    `);

                },
                error: function(xhr) {
                            // Handle error response
                            console.error("Error updating component:", xhr);
                }
            });
            } catch (error) {
                console.log(error);
            }
        });
    // Showing Modal Form Delete

    // Action Modal Form Delete
        $(document).on("submit",".formDeleteTemplate",function(e){
            e.preventDefault();
            var form = $('.formDeleteTemplate');
            var url = '/Template/Delete';
            var formData = new FormData(form[0]);

            $.ajax({
                type:'post',
                url:url,
                dataType:'json',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){
                    templateTable.clear();
                    toastr.success(res.message, 'Success');
                    $("#modalTemplate").modal('hide');
                    $.each(res.templates,function(key,value){
                        var row=`
                            <tr>
                                <td>${key+1}</td>
                                <td>${value.detail}</td>
                                <td>${value.template}</td>
                                <td>
                                    <center> <a data-toggle="modal" class="updateTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Update Template"
                                                class="fa fa-fw fa-pencil-square-o"></i></a>
                                        <a data-toggle="modal" class="deleteTemplate" data-id="${value.id}"
                                            data-target="#modalTemplate"><i title="Delete Template"
                                                class="fa fa-fw fa-trash-o"></i></a>
                                    </center>
                                </td>
                            </tr>
                        `;
                        templateTable.row.add($(row));
                    });
                    templateTable.draw();
                }
            })
        });
    // Action Modal Form Delete

    });
</script>
@endsection