<div class="modal fade" id="modalAkun" tabindex="-1" role="dialog" aria-labelledby="modalAkun" aria-hidden="true">
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
        $(document).on('click','.addAkun',function(){
            var id=$(this).data('id');
            var varian=$(this).data('varian');

            $.ajax({
                url:'/Transaksi/Provide/Akun?id_produk='+varian+'&id_trans='+id,
                type:'get',
                dataType:'json',
                success:function(res){
                    $('#modalAkun .modal-title').html(`
                        Provide Akun
                    `);
                    $('#modalAkun .modal-body').html(`
                        <form class="formProvideAkun" method="post">
                            @csrf
                            <input type="hidden" name="id" value="${res.transaksi[0].id}">
                            <div class="form-group">
                                <label>Nama Customer</label>
                                <input type="text" name="customer" class="form-control" id="" value="${res.transaksi[0].nama_customer}"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label>Kode Transaksi</label>
                                <input type="text" name="kode" id="" class="form-control" readonly
                                    value="${res.transaksi[0].kode_transaksi}">
                            </div>
                            <div class="form-group">
                                <label>Detail Produk</label>
                                <input type="text" name="Produk" id="" class="form-control" value="${res.transaksi[0].detail}"
                                    readonly>
                            </div>
                              <div class="form-group">
                                <label>Akun</label>
                                <select name="akun" id="provide_akun" class="form-control select2" style="width: 100%;">
                                    <option value="">--Pilih Akun--</option>
                                    ${res.akuns.map(a => `
                                        <option value="${a.id}" data-id="${a.id}">${a.email=="" ? a.nomor_akun:a.email}</option>
                                    `).join('')}
                                </select>
                            </div>
                            <div class="form-group profile">

                            </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
            `);
            $("#modalAkun .select2").select2();

            }});

        $(document).on('change','#provide_akun',function(){
            var selectedOption = $(this).find('option:selected');
            var id = selectedOption.data('id');
            $.ajax({
                url:'/Transaksi/Provide/Akun/Detail?id_akun='+id,
                type:'get',
                dataType:'json',
                success:function(res){
                    $('.profile').html(`
                    <label for="">Profile</label>
                    <select id="profile" name="profile" class="form-control select2">
                        <option value="" >Pilih Profile</option>
                    </select>
                    `);
                    $.each(res.details,function(key,value){
                        var selectOption=`<option value="${value.id}" >${value.profile} ==> User = ${value.jumlah_pengguna}</option>`;
                        $('#profile').append(selectOption);
                    })
                    $("#modalAkun .select2").select2();
                }
            });
        });


        });
    });
</script>