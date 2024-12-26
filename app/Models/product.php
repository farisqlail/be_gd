<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class product extends Model
{
    use HasFactory;

    public static function indexProduk($idVarian = null, $idJenis = null)
    {
        $query = '
            select v.variance_name,pt.type_name,p.*
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
            where p.deleted=false
        ';

        if ($idVarian) {
            $query .= ' and p.id_varian=' . $idVarian;
        }

        if ($idJenis) {
            $query .= ' and p.id_jenis=' . $idJenis;
        }

        return DB::select($query);
    }


    public static function fetchProdukAkun($varian)
    {
        $query = '
            select v.variance_name,pt.type_name,p.*, concat(variance_name," ",type_name," ",durasi," ",ket_durasi) as detail
            from products p join variances v on p.id_varian=v.id
            join product_types pt on p.id_jenis=pt.id
            where p.deleted=false and v.variance_name="' . $varian . '"
        ';

        return DB::select($query);
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'id_produk');
    }

    public function variance()
    {
        return $this->belongsTo(variance::class, 'id_varian');
    }
}
