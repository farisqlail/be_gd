<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class price extends Model
{
    use HasFactory;

    public static function indexPrice($idVarian = null, $idToko = null, $idPlatform = null, $idPrice = null)
    {
        $query = '
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
            $query .= ' and id_varian=' . $idVarian;
        }

        if ($idToko) {
            $query .= ' and id_toko=' . $idToko;
        }
        if ($idPlatform) {
            $query .= ' and id_platform=' . $idPlatform;
        }

        if ($idPrice) {
            $query .= ' and p.id=' . $idPrice;
        }
        return DB::select($query);
    }

    public static function get_products($namaVarian = null, $namaPlatform = null, $type_name= null, $durasi = null, $ket_durasi = null)
    {
        $query = '  
        WITH detailProduct AS (  
            SELECT p.*, pt.type_name, v.variance_name,
            CONCAT(durasi, " ", ket_durasi) AS kategori,  
                   CONCAT(variance_name, " ", type_name, " ", durasi, " ", ket_durasi) AS detail  
            FROM products p   
            JOIN variances v ON p.id_varian = v.id  
            JOIN product_types pt ON p.id_jenis = pt.id  
        ),  
          
        detailToko AS (  
            SELECT st.*, p.nama_platform  
            FROM sumber_transaksis st   
            JOIN platforms p ON st.id_platform = p.id  
        )  
      
        SELECT p.id AS id_produk,   
               p.kode_toko AS kode_produk,   
               dt.nama_platform AS platform,   
               nama_sumber AS toko,   
               dp.detail AS detail_produk,   
               dp.kategori as kategori,
               p.harga,  
               vi.image_path AS image_url,
               dp.variance_name AS variance_name
        FROM prices p   
        JOIN detailProduct dp ON p.id_produk = dp.id  
        JOIN detailToko dt ON p.id_toko = dt.id  
        LEFT JOIN variance_images vi ON vi.variance_id = dp.id_varian  
        WHERE p.deleted = false 
        ';

        if ($namaVarian) {
            $query .= ' and dp.variance_name="' . $namaVarian . '"';
        }
        if ($namaPlatform) {
            $query .= ' and dt.nama_platform="' . $namaPlatform . '"';
        }
        if ($type_name) {
            $query .= ' and dp.type_name in ' . $type_name . '';
        }
        if ($durasi) {
            $query .= ' and dp.durasi >= "' . $durasi . '"';
        }
        if ($ket_durasi) {
            $query .= ' and dp.ket_durasi in ' . $ket_durasi . '';
        }

        

        return DB::select($query);
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'id_produk', 'id');
    }

    public function variance()
    {
        return $this->belongsTo(Variance::class, 'id_varian', 'id');
    }

    public function productType()
    {
        return $this->belongsTo(product_type::class, 'id_jenis', 'id');
    }

    public function sumberTransaksi()
    {
        return $this->belongsTo(sumberTransaksi::class, 'id_toko', 'id'); // Adjust foreign key and local key as necessary
    }
}
