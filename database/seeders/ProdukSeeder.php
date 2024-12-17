<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produks')->insert([
            [
                'id_varian' => 1,
                'id_jenis' => 2,
                'durasi' => 30,
                'ket_durasi' => '30 Hari',
                'batas_pengguna' => 100,
                'deskripsi' => 'Deskripsi produk pertama',
                'deleted' => 0,
            ],
            [
                'id_varian' => 2,
                'id_jenis' => 3,
                'durasi' => 60,
                'ket_durasi' => '60 Hari',
                'batas_pengguna' => 200,
                'deskripsi' => 'Deskripsi produk kedua',
                'deleted' => 0,
            ],
            [
                'id_varian' => 3,
                'id_jenis' => 4,
                'durasi' => 90,
                'ket_durasi' => '90 Hari',
                'batas_pengguna' => 300,
                'deskripsi' => 'Deskripsi produk ketiga',
                'deleted' => 0,
            ],
        ]);
    }
}
