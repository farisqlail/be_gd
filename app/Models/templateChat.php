<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class templateChat extends Model
{
    use HasFactory;

    public static function indexTemplate(){
        $query='
            with detailProduct as (
                select p.*,pt.type_name,v.variance_name, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
                from products p join variances v on p.id_varian=v.id
                join product_types pt on p.id_jenis=pt.id
            )

            select tc.*,dp.detail
            from template_chats tc join detailProduct dp on tc.id_produk=dp.id
        ';

        return DB::select($query);
    }

    public static function fetchProduct(){
        $query='
            select v.variance_name,pt.type_name,p.*
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
            where p.deleted=false and p.id not in (select id_produk from template_chats)
        ';

        return DB::select($query);
    }

    public static function fetchProductAll(){
        $query='
            select v.variance_name,pt.type_name,p.*
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
            where p.deleted=false
        ';

        return DB::select($query);
    }
}
