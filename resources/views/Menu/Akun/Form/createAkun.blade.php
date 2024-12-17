@extends('template')
@section('content_header')
Create Akun
@endsection
@section('breadcrumb')
<li><a href="#"><i class="fa fa-pie-chart"></i>Akun</a></li>
<li class="active">Netflix</li>
@endsection
@section('main_content')
<div class="box box-default">
    <div class="box-header">
        <div class="row">
            {{-- <div class="col-md-9">
                <a class="btn btn bg-olive margin" href="/Transaksi/Today/Input"><i class="fa fa-plus"></i>
                    <span>&nbsp; Add Transaksi</span></a>
            </div> --}}

        </div>
        <div class="row">
            <div class="col-sm-12">


                <button type="button" class="btn btn-success add"><i class="fa fa-plus-circle"> &nbsp;Add
                        Row</i></button>


                <button type="button" class="btn btn-danger delete"><i class="fa fa-minus-circle">&nbsp;Delete
                        Row</i></button>

            </div>
        </div>

    </div>
    <div class="box-body">
        <div class="col-sm-12">
            <form action="/Akun/Netflix/Store" method="post">
                @csrf
                <input type="hidden" name="varian" value="Netflix">
                <table class="table table-bordered table-hover" id="myTable">
                    <thead>
                        <tr>
                            <td>Produk</td>
                            <td>Metode Produksi</td>
                            <td>Email</td>
                            <td>Password</td>
                            <td>Nomor Telepon Akun</td>
                            <td>Tanggal Pembuatan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <select name="produk[]" class="form-control select2" style="width: 100%;">
                                        <option value="">--Choose Produk--</option>
                                        @foreach ($produk as $item)
                                        <option value="{{$item->id}}">{{$item->detail}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select name="metode[]" class="form-control select2" style="width: 100%;">
                                        @foreach ($metode as $item)
                                        <option value="{{$item->id}}">{{$item->nama_metode}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email[]"
                                        placeholder="Masukkan Email Akun">
                                </div>
                            </td>
                            <td>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="password[]"
                                        placeholder="Masukkan Password Akun">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="nomor[]"
                                        placeholder="08123489238 Atau 628123841289">
                                </div>
                            </td>

                            <td>

                                <div class="form-group">
                                    <input type="date" class="form-control" name="tanggal[]" value="{{date('Y-m-d')}}">
                                </div>

                            </td>
                            <!-- Repeat similar td elements for other input fields -->
                        </tr>
                    </tbody>
                </table>

        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    </form>
</div>
<script src="{{ asset('../../bower_components/jquery/dist/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
    $(".add").click(function () {
        var newRow = `
            <tr>
                <td>
                    <div class="form-group">
                        <select name="produk[]" class="form-control select2" style="width: 100%;">
                            <option value="">--Choose Produk--</option>
                            @foreach ($produk as $item)
                            <option value="{{$item->id}}">{{$item->detail}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <select name="metode[]" class="form-control select2" style="width: 100%;">
                            @foreach ($metode as $item)
                            <option value="{{$item->id}}">{{$item->nama_metode}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email[]" placeholder="Masukkan Email Akun">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control" name="password[]" placeholder="Masukkan Password Akun">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" class="form-control" name="nomor[]" placeholder="08123489238 Atau 628123841289">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="date" class="form-control" name="tanggal[]" value="{{date('Y-m-d')}}">
                    </div>
                </td>
            </tr>
        `;

        // Append the new row to the table
        var appendedRow = $(newRow).appendTo('#myTable tbody');

        // Initialize select2 on the appended elements
        appendedRow.find('.select2').select2();
    });

    $(".delete").click(function () {
        $('#myTable tbody tr:last').remove();
    });
});

</script>
@endsection