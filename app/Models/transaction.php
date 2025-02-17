<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_price',
        'id_customer',
        'id_payment',
        'nama_customer',
        'kode_transaksi',
        'tanggal_pembelian',
        'tanggal_berakhir',
        'harga',
        'wa', 
        'status',
        'link_wa',
        'status_pembayaran',
        'promo',
        'payment_method'
    ];

    public static function indexTransaction($idTransaksi=null){
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
                select da.*,a.email,a.password,a.nomor_akun,dt.id_transaksi
                from akuns a join detail_akuns da on a.id=da.id_akun
                join detail_transactions dt on da.id=dt.id_detail_akun
            )

                select dp.detail,nama_platform,nama_sumber,t.*,dp.id_produk,email,nomor_akun,id_platform,dp.id_toko
                from transactions t join detailPrices dp on t.id_price=dp.id
                left join detailAkuns da on t.id=da.id_transaksi
                where tanggal_pembelian="'.$today.'"';

            if ($idTransaksi) {
                $query .= '  and t.id='.$idTransaksi;
            }

            // select t.*,da.*,dt.keterangan
            // from detail_transactions dt join transaksis t on dt.id_transaksi=t.id
            // join detailAkuns da on dt.id_detail_akun=da.id
        return DB::select($query);
    }

    public static function currentProduct($email_account, $dateThreshold){
        $today=date("Y-m-d");
        $query='
        with detailProduct as (
            select v.variance_name,pt.type_name,p.id,p.id_varian,durasi,ket_durasi, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
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
            select p.*, dp.detail,dp.variance_name,dp.type_name,dp.id_varian,dp.durasi,dp.ket_durasi
            from prices p join detailProduct dp on p.id_produk=dp.id
            join detailToko dt on p.id_toko=dt.id
            where p.deleted=false
        ),
        detailAkuns as (
            select da.*,a.email,a.password,a.nomor_akun,dt.id_transaksi
            from akuns a join detail_akuns da on a.id=da.id_akun
            join detail_transactions dt on da.id=dt.id_detail_akun
        )
        
            select distinct dp.* -- dp.detail,nama_platform,nama_sumber,t.*,dp.id_produk,email,nomor_akun,id_platform,dp.id_toko
            from transactions t join detailPrices dp on t.id_price=dp.id
            left join detailAkuns da on t.id=da.id_transaksi        
            where da.email="'.$email_account.'" and t.tanggal_berakhir >="'.$dateThreshold.'"' ;

            // select t.*,da.*,dt.keterangan
            // from detail_transactions dt join transaksis t on dt.id_transaksi=t.id
            // join detailAkuns da on dt.id_detail_akun=da.id
        return DB::select($query);
    }

    public static function claimTransaction($transaksi_uuid=null){
        $query='
            with detailAkun as(
                select da.*,a.email,a.password,a.nomor_akun,dt.id_transaksi
                from akuns a join detail_akuns da on a.id=da.id_akun
                join detail_transactions dt on da.id=dt.id_detail_akun
            )
            select da.email, da.password, da.profile, da.pin
            from transactions t 
            join detailAkun da on t.id = da.id_transaksi
            where t.kode_transaksi = "'.$transaksi_uuid.'"';



            // select t.*,da.*,dt.keterangan
            // from detail_transactions dt join transaksis t on dt.id_transaksi=t.id
            // join detailAkuns da on dt.id_detail_akun=da.id
        return DB::select($query);
    }

    public function customer()  
    {  
        return $this->belongsTo(Customer::class, 'id_customer');  
    }  

    public function price()  
    {  
        return $this->belongsTo(Price::class, 'id_price', 'id'); // Adjust foreign key and local key as necessary  
    }  
}
