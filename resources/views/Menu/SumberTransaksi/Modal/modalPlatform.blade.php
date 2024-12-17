<div class="modal fade" id="managePlatform" tabindex="-1" role="dialog" aria-labelledby="managePlatform"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="managePlatform">Manage Platform</h3>
            </div>
            <div class="modal-body platformBody">
                <div class="box-body">
                    <form class="formAddPlatform" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idPlatform">
                        <div class="form-group">
                            <label for="platform">Nama Platform</label>
                            <input type="text" class="form-control" id="platform_master" name="platform"
                                placeholder="Masukkan Nama Platform">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @foreach ($platforms as $item)
                                <span class="btn btn-xs platformSumber" id="platform-{{$item->id}}"
                                    data-id="{{$item->id}}"
                                    data-platform="{{$item->nama_platform}}">{{$item->nama_platform}}</span>
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

        $(document).on('click', '.platformSumber', function(){
            var id = $(this).data('id');
            var platformName = $(this).data('platform');
            $(".platformBody form").removeClass("formAddPlatform").addClass("formUpdatePlatform");
            $("#platform_master").val(platformName);
            $("#idPlatform").val(id);
            $("#managePlatform #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delPlatform" >Delete</button>
                <button type="submit" class="btn btn-primary upPlatform" >Update</button>
            `);
        });

        $(document).on("hidden.bs.modal","#managePlatform",function(){
            $("#platform_master").val('');
            $("#managePlatform #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            `);
        });

        $(document).on("submit",".formAddPlatform",function(e){
            e.preventDefault();
            var form = $('.formAddPlatform');
            var formData = new FormData(form[0]);
            var url = "/Platform/Sumber/Store";
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
                        // Loop through the updated fleet platforms and append them to the container
                        $.each(response.platforms, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs platformSumber" id="platform-${value.id}" data-id="${value.id}}"
                                    data-platform="${value.nama_platform}">${value.nama_platform}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_platform}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#platformToko").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#platform_master").val('');
                            $("#managePlatform").modal('hide');
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

        $(document).on("submit",".formUpdatePlatform",function(e){
            e.preventDefault();
            var form = $('.formUpdatePlatform');
            var formData = new FormData(form[0]);
            var url = "/Platform/Sumber/Update";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $(".platformBody form").removeClass("formUpdatePlatform").addClass("formAddPlatform");
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet platforms and append them to the container
                        $.each(response.platforms, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs platformSumber" id="platform-${value.id}" data-id="${value.id}}"
                                    data-platform="${value.nama_platform}">${value.nama_platform}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_platform}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#platformToko").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#platform_master").val('');
                            $("#managePlatform").modal('hide');
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

        $(document).on('click','.delPlatofrm',function(e){
            e.preventDefault();
            var form = $('.formUpdatePlatform');
            var formData = new FormData(form[0]);
            var url = "/Platform/Sumber/Delete";
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
                        // Loop through the updated fleet platforms and append them to the container
                        $.each(response.platforms, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs platformSumber" id="platform-${value.id}" data-id="${value.id}}"
                                    data-platform="${value.nama_platform}">${value.nama_platform}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_platform}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#platformToko").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#platform_master").val('');
                            $("#managePlatform").modal('hide');
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
