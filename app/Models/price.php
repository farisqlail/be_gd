<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class price extends Model
{
    use HasFactory;

    public static function indexPrice($idVarian=null,$idToko=null,$idPlatform=null,$idPrice=null){
        $query='
            with detailProduct as (
                select p.*,pt.type_name,v.variance_name, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
                from products p join variances v on p.id_varian=v.id
                join product_types pt on p.id_jenis=pt.id
            ),

            detailToko as (
                select st.*,p.nama_platform
                from sumber_transaksis st join platforms p on st.id_platform=p.id
            )

            select p.*, dp.id_varian,dp.durasi,dp.ket_durasi,dp.id_jenis,dp.detail,dt.nama_platform,nama_sumber,dt.id_platform
            from prices p join detailProduct dp on p.id_produk=dp.id
            join detailToko dt on p.id_toko=dt.id
            where p.deleted=false
        ';

        if ($idVarian) {
            $query .=' and id_varian='.$idVarian;
        }

        if ($idToko) {
            $query .=' and id_toko='.$idToko;
        }
        if ($idPlatform) {
            $query .=' and id_platform='.$idPlatform;
        }

        if ($idPrice) {
            $query .=' and p.id='.$idPrice;
        }
        return DB::select($query);
    }

    public static function get_products(){
        $query='
        with detailProduct as (
            select p.*,pt.type_name,v.variance_name, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
        ),

        detailToko as (
            select st.*,p.nama_platform
            from sumber_transaksis st join platforms p on st.id_platform=p.id
        )

        select p.id as id_produk,p.kode_toko as kode_produk,dt.nama_platform as platform,nama_sumber as toko, dp.detail as detail_produk,p.harga
        from prices p join detailProduct dp on p.id_produk=dp.id
        join detailToko dt on p.id_toko=dt.id
        where p.deleted=false
    ';

    return DB::select($query);
    }
}
