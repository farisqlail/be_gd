<div class="modal fade" id="modalTransaksi" tabindex="-1" role="dialog" aria-labelledby="modalTransaksi"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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


     function updateRowNumbers() {
            $('#myTable tbody tr').each(function(index) {
                // Update the ids for item and qty fields with row number
                var rowNumber = index + 1;
                $(this).find('select[name="produk[]"]').attr('id', 'produk_' + rowNumber);
                $(this).find('input[name="harga[]"]').attr('id', 'harga_' + rowNumber);
            });
    };
        // $('#myTable').on('change', 'select[name="produk[]"]',function(){
        //     var selectedOption = $(this).find('option:selected');
        //     var stock = selectedOption.data('stock');

        //     if (stock == 0) {
        //         var html = '<h4 style="color: red"><center>' + stock + ' </center></h4>';
        //         $(this).closest('tr').find('.last_stock').html(html);
        //         $(this).closest('tr').find('input[name="qty[]"]').prop('disabled', true);
        //     } else {
        //         var html = '<h4 style="color: green"><center>' + stock + ' </center></h4>';
        //         $(this).closest('tr').find('.last_stock').html(html);
        //         $(this).closest('tr').find('input[name="qty[]"]').prop('disabled', false);
        //     }
        // });

        $(document).on('click','.add',function(){
            var rowCount = $('#myTable tbody tr').length + 1;
            var sumber =$('#sumber').val();
            var newRow = `
                <tr>
                    <td>
                        <div class="form-group">
                            {{-- <label for="item">Item</label> --}}
                            <select name="produk[]" id="produk_${rowCount}" class="form-control select2 produkDropdown"
                                style="width: 100%">

                            </select>

                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" name="harga[]" class="form-control price-field" id="harga_${rowCount}"
                                readonly>
                        </div>
                    </td>
                </tr>`;

                $.ajax({
                    url:'/Transaksi/fetch/produk?id_toko='+sumber,
                    type:'get',
                    dataType:'json',
                    success:function(res){
                        $.each(res.products,function(key,value){
                            $('#produk_' + rowCount).html(`
                            <option value="">--Choose Product--</option>
                            `);
                            $('#produk_' + rowCount).append(`
                                <option value="${value.id}" data-harga="${value.harga}">${value.detail}</option>
                            `);
                        });
                    }
                });
            $('#myTable tbody').append(newRow);
            $('#produk_' + rowCount).select2();
            updateRowNumbers();
        });

        $(document).on('click','.delete',function(){
            if ($('#myTable tbody tr').length > 1) {
                $('#myTable tbody tr:last').remove();
                updateRowNumbers();
            }
        });

        $(document).on('change','.status-checkbox',function(){
            if ($(this).is(':checked')) {
                $('.price-field').prop('readonly', false);
            } else {
                $('.price-field').prop('readonly', true);
            }
        });

        $(document).on('blur','#wa',function(){
            var wa = $(this).val();
            if (wa) {
                $.ajax({
                    type:'get',
                    url:'/Transaksi/fetch/lastTransaction?wa='+wa,
                    dataType:'json',
                    success:function(res){
                        $('#customer').val(res.nama_customer);
                        $('#lastTransaction').val(res.created_at);
                    }
                });
            }
        });

        $(document).on('paste','#paste-area',function(e){
            var items = (e.originalEvent.clipboardData || e.clipboardData).items;

            // Loop through the clipboard items
            $.each(items, function (index, item) {
                if (item.kind === 'file') {
                    var blob = item.getAsFile();

                    if (blob && blob.type.startsWith("image/")) {
                        var $fileInput = $('#bukti')[0];
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(blob);

                        // Append the blob to the file input
                        $fileInput.files = dataTransfer.files;

                        // Optional: preview the image (e.g., in the paste-area div)
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var $img = $('<img>', {
                                src: e.target.result,
                                css: { maxWidth: '200px' } // Adjust as needed
                            });
                            $('#paste-area').append($img);
                        };
                        reader.readAsDataURL(blob);
                    }
                }
            });
        });

        // updateRowNumbers();
    });
</script>
