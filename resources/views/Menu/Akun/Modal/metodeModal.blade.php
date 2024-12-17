<div class="modal fade" id="manageMetode" tabindex="-1" role="dialog" aria-labelledby="manageMetode" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addMetode">Manage Metode</h3>
            </div>
            <div class="modal-body metodeBody">
                <div class="box-body">
                    <form class="formAddMetode" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idMetode">
                        <div class="form-group">
                            <label for="metode">Metode Produksi</label>
                            <input type="text" class="form-control" id="metode_master" name="metode"
                                placeholder="Masukkan Metode Produksi">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @foreach ($metode as $item)
                                <span class="btn btn-xs metodeProduksi" id="metode-{{$item->id}}"
                                    data-id="{{$item->id}}"
                                    data-metode="{{$item->nama_metode}}">{{$item->nama_metode}}</span>
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

        $(document).on('click', '.metodeProduksi', function(){
            var id = $(this).data('id');
            var metodeName = $(this).data('metode');
            $(".metodeBody form").removeClass("formAddMetode").addClass("formUpdateMetode");
            $("#metode_master").val(metodeName);
            $("#idMetode").val(id);
            $("#manageMetode #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delMetode" >Delete</button>
                <button type="submit" class="btn btn-primary upMetode" >Update</button>
            `);
        });

        $(document).on("hidden.bs.modal","#manageMetode",function(){
            $("#metode_master").val('');
            $("#manageMetode #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            `);
        });

        $(document).on("submit",".formAddMetode",function(e){
            e.preventDefault();
            var form = $('.formAddMetode');
            var formData = new FormData(form[0]);
            var url = "/Metode/Produksi/Store";
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
                        $.each(response.metode, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs metodeProduksi" id="metode-${value.id}" data-id="${value.id}}"
                                    data-metode="${value.nama_metode}">${value.nama_metode}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_metode}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#manageMetode").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#metode_master").val('');
                            $("#manageMetode").modal('hide');
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

        $(document).on("submit",".formUpdateMetode",function(e){
            e.preventDefault();
            var form = $('.formUpdateMetode');
            var formData = new FormData(form[0]);
            var url = "/Metode/Produksi/Update";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $(".metodeBody form").removeClass("formUpdateMetode").addClass("formAddMetode");
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet types and append them to the container
                        $.each(response.metode, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs metodeProduksi" id="metode-${value.id}" data-id="${value.id}}"
                                    data-metode="${value.nama_metode}">${value.nama_metode}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_metode}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#manageMetode").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#metode_master").val('');
                            $("#manageMetode").modal('hide');
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
            var url = "/Metode/Produksi/Delete";
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
                                <span class="btn btn-xs metodeProduksi" id="metode-${value.id}" data-id="${value.id}}"
                                    data-metode="${value.nama_metode}">${value.nama_metode}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_metode}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#manageMetode").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#metode_master").val('');
                            $("#manageMetode").modal('hide');
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