<div class="modal fade" id="manageJenis" tabindex="-1" role="dialog" aria-labelledby="manageJenis" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addCategory">Manage Jenis</h3>
            </div>
            <div class="modal-body jenisBody">
                <div class="box-body">
                    <form class="formAddJenis" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idJenis">
                        <div class="form-group">
                            <label for="jenis">Jenis Produk</label>
                            <input type="text" class="form-control" id="jenis_master" name="jenis"
                                placeholder="Masukkan Jenis Produk">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @foreach ($types as $item)
                                <span class="btn btn-xs jenisProduk" id="jenis-{{$item->id}}" data-id="{{$item->id}}"
                                    data-jenis="{{$item->type_name}}">{{$item->type_name}}</span>
                                @endforeach
                            </div>
                        </div>
                </div>
                <!-- /.box-body -->

            </div>
            <div class="modal-footer" id="footerSubmit">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Detail Job --}}

<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    // Manage Type

        $(document).on('click', '.jenisProduk', function(){
            var id = $(this).data('id');
            var jenisName = $(this).data('jenis');
            $(".jenisBody form").removeClass("formAddJenis").addClass("formUpdateJenis");
            $("#jenis_master").val(jenisName);
            $("#idJenis").val(id);
            $("#manageJenis #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delJenis" >Delete</button>
                <button type="submit" class="btn btn-primary upJenis" >Update</button>
            `);
        });

        $(document).on("hidden.bs.modal","#manageJenis",function(){
            $("#jenis_master").val('');
            $("#manageJenis #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            `);
        });

        $(document).on("submit",".formAddJenis",function(e){
            e.preventDefault();
            var form = $('.formAddJenis');
            var formData = new FormData(form[0]);
            var url = "/Jenis/Produk/Store";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet types and append them to the container
                        $.each(response.types, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs jenisProduk" id="jenis-${value.id}" data-id="${value.id}}"
                                    data-jenis="${value.type_name}">${value.type_name}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.type_name}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#jenisProduk").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#jenis_master").val('');
                            $("#manageJenis").modal('hide');
                            $("#footerSubmit").html(`
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            `);
                    }
                });
            } catch (error) {
                console.log(error)
            }

        });

        $(document).on("submit",".formUpdateJenis",function(e){
            e.preventDefault();
            var form = $('.formUpdateJenis');
            var formData = new FormData(form[0]);
            var url = "/Jenis/Produk/Update";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $(".jenisBody form").removeClass("formUpdateJenis").addClass("formAddJenis");
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet types and append them to the container
                        $.each(response.types, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs jenisProduk" id="jenis-${value.id}" data-id="${value.id}}"
                                    data-jenis="${value.type_name}">${value.type_name}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.type_name}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#jenisProduk").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#jenis_master").val('');
                            $("#manageJenis").modal('hide');
                            $("#footerSubmit").html(`
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            `);
                    }
                });
            } catch (error) {
                console.log(error)
            }

        });

        $(document).on('click','.deljenis',function(e){
            e.preventDefault();
            var form = $('.formUpdatejenis');
            var formData = new FormData(form[0]);
            var url = "/Jenis/Produk/Delete";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet types and append them to the container
                        $.each(response.types, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs jenisProduk" id="jenis-${value.id}" data-id="${value.id}}"
                                    data-jenis="${value.type_name}">${value.type_name}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.type_name}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#jenisProduk").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#jenis_master").val('');
                            $("#manageJenis").modal('hide');
                            $("#footerSubmit").html(`
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            `);
                    }
                });
            } catch (error) {
                console.log(error)
            }
        });


    // Manage Type
    });
</script>
