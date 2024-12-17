<div class="modal fade" id="manageVarian" tabindex="-1" role="dialog" aria-labelledby="manageVarian" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addCategory">Manage Varian</h3>
            </div>
            <div class="modal-body varianBody">
                <div class="box-body">
                    <form class="formAddVarian" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idVarian">
                        <div class="form-group">
                            <label for="varian">Varian</label>
                            <input type="text" class="form-control" id="varian_master" name="varian"
                                placeholder="Masukkan Varian Produk">
                        </div>
                        <div class="card">
                            <div class="card-body varianList">
                                @foreach ($variances as $item)
                                <span class="btn btn-xs varianProduk" id="varian-{{$item->id}}" data-id="{{$item->id}}"
                                    data-varian="{{$item->variance_name}}">{{$item->variance_name}}</span>
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

        $(document).on('click', '.varianProduk', function(){
            var id = $(this).data('id');
            var varianName = $(this).data('varian');
            $(".varianBody form").removeClass("formAddVarian").addClass("formUpdateVarian");
            $("#varian_master").val(varianName);
            $("#idVarian").val(id);
            $("#manageVarian #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delVarian" >Delete</button>
                <button type="submit" class="btn btn-primary upVarian" >Update</button>
            `);
        });

        $(document).on("hidden.bs.modal","#manageVarian",function(){
            $("#varian_master").val('');
            $("#manageVarian #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            `);
        });

        $(document).on("submit",".formAddVarian",function(e){
            e.preventDefault();
            var form = $('.formAddVarian');
            var formData = new FormData(form[0]);
            var url = "/Varian/Produk/Store";
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
                        $.each(response.variances, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs varianProduk" id="varian-${value.id}" data-id="${value.id}}"
                                    data-varian="${value.variance_name}">${value.variance_name}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.variance_name}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#varianProduk").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#varian_master").val('');
                            $("#manageVarian").modal('hide');
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

        $(document).on("submit",".formUpdateVarian",function(e){
            e.preventDefault();
            var form = $('.formUpdateVarian');
            var formData = new FormData(form[0]);
            var url = "/Varian/Produk/Update";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $(".varianBody form").removeClass("formUpdateVarian").addClass("formAddVarian");
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet types and append them to the container
                        $.each(response.variances, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs varianProduk" id="varian-${value.id}" data-id="${value.id}}"
                                    data-varian="${value.variance_name}">${value.variance_name}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.variance_name}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#varianProduk").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#varian_master").val('');
                            $("#manageVarian").modal('hide');
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

        $(document).on('click','.delVarian',function(e){
            e.preventDefault();
            var form = $('.formUpdateVarian');
            var formData = new FormData(form[0]);
            var url = "/Varian/Produk/Delete";
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
                        $.each(response.variances, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs varianProduk" id="varian-${value.id}" data-id="${value.id}}"
                                    data-varian="${value.variance_name}">${value.variance_name}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.variance_name}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#varianProduk").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#varian_master").val('');
                            $("#manageVarian").modal('hide');
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
