@extends('template')
@section('content_header')
Transaksi
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li class="active">Transaksi</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a class="btn btn bg-olive margin addTransaksi" data-toggle="modal" data-target="#modalTransaksi">
                    <i class="fa fa-plus"></i>
                    <span>&nbsp; Add Transaksi</span>
                </a>
                <a class="btn btn-xs" data-toggle="modal" data-target="#managePayment">
                    <i class="fa fa-tag"></i>
                    <span>&nbsp; Manage Payment</span>
                </a>
            </div>

            <div class="box-body">
                <table id="transaksiTable" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Customer</th>
                            <th>Email Customer</th>
                            <th>Wa Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Nomor Klaim</th>
                            <th>Klaim Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->transaction_code }}</td>
                            <td>{{ $transaction->customer_name }}</td>
                            <td>{{ $transaction->email_customer }}</td>
                            <td>{{ $transaction->phone_customer }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->payment_status }}</td>
                            <td>{{ $transaction->payment_method }}</td>
                            <td>{{ $transaction->claim_number }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>
                                <form action="{{ route('transactions.pending.update', $transaction->transaction_code) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary">Selesai</button>
                                </form>

                                @if($transaction->image_path)
                                    <button type="button" class="btn btn-info btn-sm view-image" data-image="{{ asset('/uploads/invoices/' . $transaction->image_path) }}" data-toggle="modal" data-target="#imageModal">
                                        Lihat Gambar
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Menampilkan Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Bukti Pembayaran">
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('../../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // DataTable
        var transaksiTable = $("#transaksiTable").DataTable({
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

        // Event handler untuk tombol "Lihat Gambar"
        $(".view-image").on("click", function() {
            var imageUrl = $(this).data("image");
            $("#modalImage").attr("src", imageUrl);
        });
    });
</script>
@endsection
