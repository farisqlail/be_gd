@extends('template')
@section('content_header')
Tambah Produk
@endsection

@section('breadcrumb')
<li><a href="#"><i class="fa fa-user"></i>Home</a></li>
<li><a href="{{ route('produk.index') }}">Produk</a></li>
<li class="active">Tambah Produk</li>
@endsection

@section('main_content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Form Tambah Produk</h3>
            </div>
            <div class="box-body">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label>Produk</label>
                            <select name="nama_produk" id="varianProduk" class="form-control select2" style="width: 100%;">
                                <option value="">--Choose Product--</option>
                                @foreach($variances as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->variance_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Unit Type">Jenis Produk</label>
                            <select name="jenis_produk" id="jenisProduk" class="form-control select2" style="width: 100%;">
                                <option value="">--Choose Product Type--</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->type_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="durasi">Durasi Produk</label>
                            <input type="number" class="form-control" name="durasi" id="durasi" placeholder="1,2,3 ...">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan Durasi</label>
                            <select name="keterangan" class="form-control select2" style="width: 100%;">
                                <option value="">-- Pilih Durasi --</option>
                                <option value="Hari">Hari</option>
                                <option value="Bulan">Bulan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Biaya</label>
                            <input type="number" class="form-control" name="biaya" id="biaya"
                                placeholder="Masukkan Biaya Produksi">
                        </div>
                        <div class="form-group">
                            <label for="batas">Maximal Users</label>
                            <input type="number" class="form-control" name="batas" id="batas" placeholder="1,2,3 ...">
                        </div>
                        <div class="form-group">
                            <label for="produkImage">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection