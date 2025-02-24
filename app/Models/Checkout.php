<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Checkout extends Model
{
    use HasFactory;

      protected $fillable = [
        'id_price',
        'id_customer',
        'id_promo',
        'customer_name',
        'email_customer',
        'phone_customer',
        'transaction_code',
        'amount',
        'payment_status',
        'payment_method',
        'status',
        'claim_number',
        'image_path'
    ];
    
    public static function indexCheckout($transaction_code=null,$idWA=null,$status=null,$idTransaction=null){
        $today=date("Y-m-d");
        $query='
        with detailProduct as (
                select v.variance_name,pt.type_name,p.id,p.id_varian, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
                from products p join variances v on p.id_varian=v.id
                join product_types pt on p.id_jenis=pt.id
                where p.deleted=false
        ),
        detailToko as (
            select st.*,p.nama_platform
            from sumber_transaksis st join platforms p on st.id_platform=p.id
            where st.deleted=false
        ),
        detailPrices as (
            select p.*, dp.detail,dt.nama_platform,dt.nama_sumber,id_platform,id_varian
            from prices p join detailProduct dp on p.id_produk=dp.id
            join detailToko dt on p.id_toko=dt.id
            where p.deleted=false
        ),
         detailAkuns as (
                select da.*,a.email,a.password,a.nomor_akun,dc.id_checkout
                from akuns a join detail_akuns da on a.id=da.id_akun
                join detail_checkouts dc on da.id=dc.id_detail_akun
        )
        
        select dp.detail,nama_platform,nama_sumber,c.*,dp.id_produk,email,nomor_akun,id_platform,dp.id_toko
                from checkouts c join detailPrices dp on c.id_price=dp.id
                left join detailAkuns da on c.id=da.id_checkout
                where date_format(c.created_at,"%Y-%m-%d")="'.$today.'"';
        
        if ($idWA) {
            $query .= ' and claim_number="'.$idWA.'"';
        }
        
        if ($status) {
            $query .= ' and status > 0';
        }
        if ($idTransaction) {
            $query .= ' and c.id='.$idTransaction;
        }
        if($transaction_code){
            $query .= ' and transaction_code="'.$transaction_code.'"';
        }
        
       
        return DB::select($query);
    }
    
    
    public static function getProduct($idPrice){
        $query='
         with detailProduct as (
                select v.variance_name,pt.type_name,p.id,p.id_varian
                from products p join variances v on p.id_varian=v.id
                join product_types pt on p.id_jenis=pt.id
                where p.deleted=false
        )
            select dp.*
            from prices p join detailProduct dp on p.id_produk=dp.id
            where p.id='.$idPrice;
            
        return DB::select($query);
    }
    public static function provideAccount($idPrice){
       $query='
        with detailAkuns as (
                select da.*,a.email,a.password,a.nomor_akun,a.id_produk,a.jumlah_pengguna as qty_user_akun
                from akuns a join detail_akuns da on a.id=da.id_akun
        )
        
        select da.*
        from prices p join detailAkuns da on p.id_produk=da.id_produk
        join products pd on da.id_produk=pd.id
        where p.id='.$idPrice.'
        and da.jumlah_pengguna < pd.batas_pengguna
        order by da.jumlah_pengguna asc
        limit 1';
         
         return DB::select($query);
    }

    public static function getAccount($kode_transaksi){
        $query='
            with getProduct as (
                select p.id_produk,c.id
                from checkouts c join prices p on c.id_price=p.id
                where transaction_code="'.$kode_transaksi.'"
            ) 
                select a.id as id_akun,a.jumlah_pengguna as qty_akun,a.email,a.password,a.nomor_akun,da.id as id_detail_akun,da.jumlah_pengguna,da.profile,da.pin,gp.id as id_checkout
                from akuns a join detail_akuns da on a.id=da.id_akun
                join getProduct gp on a.id_produk=gp.id_produk
                where a.jumlah_pengguna < (select batas_pengguna from products where id=gp.id_produk)
                order by jumlah_pengguna asc
                limit 1';

        return DB::select($query);
    }
}
