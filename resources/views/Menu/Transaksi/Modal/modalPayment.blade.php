<div class="modal fade" id="managePayment" tabindex="-1" role="dialog" aria-labelledby="managePayment"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Manage Payment</h3>
            </div>
            <div class="modal-body paymentBody">
                <div class="box-body">
                    <form class="formAddPayment" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idPayment">
                        <div class="form-group">
                            <label for="payment">Payment Method</label>
                            <input type="text" class="form-control" id="payment_master" name="payment"
                                placeholder="Masukkan Payment Method">
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @foreach ($payments as $item)
                                <span class="btn btn-xs paymentMethod" id="payment-{{$item->id}}"
                                    data-id="{{$item->id}}"
                                    data-payment="{{$item->nama_payment}}">{{$item->nama_payment}}</span>
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

        $(document).on('click', '.paymentMethod', function(){
            var id = $(this).data('id');
            var paymentName = $(this).data('payment');
            $(".paymentBody form").removeClass("formAddPayment").addClass("formUpdatePayment");
            $("#payment_master").val(paymentName);
            $("#idPayment").val(id);
            $("#managePayment #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delPayment" >Delete</button>
                <button type="submit" class="btn btn-primary upPayment" >Update</button>
            `);
        });

        $(document).on("hidden.bs.modal","#managePayment",function(){
            $("#payment_master").val('');
            $("#managePayment #footerSubmit").html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            `);
        });

        $(document).on("submit",".formAddPayment",function(e){
            e.preventDefault();
            var form = $('.formAddPayment');
            var formData = new FormData(form[0]);
            var url = "/Payment/Store";
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
                        $.each(response.payments, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs paymentMethod" id="payment-${value.id}"
                                    data-id=${value.id}"
                                    data-payment="${value.nama_payment}">${value.nama_payment}</span>`;

                            var select_option=`
                                        <option value="${value.id}">${value.nama_payment}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#payment").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#payment_master").val('');
                            $("#managePayment").modal('hide');
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

        $(document).on("submit",".formUpdatePayment",function(e){
            e.preventDefault();
            var form = $('.formUpdatePayment');
            var formData = new FormData(form[0]);
            var url = "/Payment/Update";
            try {
                $.ajax({
                    type:'post',
                    url:url,
                    dataType:'json',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $(".paymentBody form").removeClass("formUpdatePayment").addClass("formAddPayment");
                        toastr.success(response.message,('Success'));
                        $('.card-body').empty();
                        // Loop through the updated fleet types and append them to the container
                        $.each(response.payments, function(key, value) {
                            var refresh_data = `
                                <span class="btn btn-xs paymentMethod" id="payment-${value.id}"
                                    data-id=${value.id}"
                                    data-payment="${value.nama_payment}">${value.nama_payment}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_payment}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#paymentMethod").append(select_option);
                            // $("#supplier_update").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#payment_master").val('');
                            $("#managePayment").modal('hide');
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

        $(document).on('click','.delPayment',function(e){
            e.preventDefault();
            var form = $('.formUpdatePayment');
            var formData = new FormData(form[0]);
            var url = "/Payment/Delete";
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
                        $.each(response.payments, function(key, value) {
                            var refresh_data = `
                               <span class="btn btn-xs paymentMethod" id="payment-${value.id}"
                                    data-id=${value.id}"
                                    data-payment="${value.nama_payment}">${value.nama_payment}</span>`;

                            var select_option=`
                                        <option value="${value.id}}">${value.nama_payment}</option>
                            `;
                            $('.card-body').append(refresh_data);
                            $("#paymentMethod").append(select_option);
                        });
                        // Hide the modal after updating
                            $("#payment_master").val('');
                            $("#managePayment").modal('hide');
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
