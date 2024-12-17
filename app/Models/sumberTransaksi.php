<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sumberTransaksi extends Model
{
    use HasFactory;

    public static function indexPlatform(){
        $query='
            select st.*,p.nama_platform
            from sumber_transaksis st join platforms p on st.id_platform=p.id
            where st.deleted=false
        ';

        return DB::select($query);
    }
}
