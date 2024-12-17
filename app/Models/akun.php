<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class akun extends Model
{
    use HasFactory;

    public static function indexAkun($varian){
        $query='
        with detailProduk as (
            select v.variance_name,pt.type_name,p.*, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
            where p.deleted=false and v.variance_name="'.$varian.'"
        )

        select a.*,dp.detail
        from akuns a join detailProduk dp on a.id_produk=dp.id
        ';

        return DB::select($query);
    }

    public static function fetchProduk($varian){
        $query='
            select v.variance_name,pt.type_name,p.*, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
            where p.deleted=false and v.variance_name="'.$varian.'"
        ';

        return DB::select($query);
    }

    public static function fetchAkun($id_produk){
        $query='
            select a.*
            from products p join akuns a on p.id=a.id_produk
            where a.jumlah_pengguna < p.batas_pengguna and p.id='.$id_produk;

        return DB::select($query);
    }

}
