<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;
use App\Models\Mitra;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $mitras = Mitra::all();

        if ($mitras->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada mitra. Jalankan MitraSeeder terlebih dahulu.');
            return;
        }

        $obatsData = [
            // DEMAM / NYERI
            [
                'nama_obat' => 'Paracetamol 500mg',
                'kategori' => 'Demam',
                'gejala' => 'Demam, sakit kepala, nyeri ringan',
                'deskripsi' => 'Obat penurun panas dan pereda nyeri ringan hingga sedang',
                'stok' => 100,
                'harga' => 8000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Ibuprofen 400mg',
                'kategori' => 'Nyeri',
                'gejala' => 'Nyeri otot, sakit gigi, demam',
                'deskripsi' => 'Anti inflamasi non-steroid untuk nyeri dan demam',
                'stok' => 80,
                'harga' => 12000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],

            // BATUK & FLU
            [
                'nama_obat' => 'OBH Combi',
                'kategori' => 'Batuk',
                'gejala' => 'Batuk berdahak, flu',
                'deskripsi' => 'Obat batuk kombinasi untuk meredakan batuk dan flu',
                'stok' => 60,
                'harga' => 15000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Woods Peppermint',
                'kategori' => 'Batuk',
                'gejala' => 'Batuk, tenggorokan gatal',
                'deskripsi' => 'Permen pelega tenggorokan dengan peppermint',
                'stok' => 120,
                'harga' => 5000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Actifed',
                'kategori' => 'Flu',
                'gejala' => 'Hidung tersumbat, bersin-bersin',
                'deskripsi' => 'Obat untuk meredakan gejala flu dan alergi',
                'stok' => 50,
                'harga' => 18000,
                'lokasi_apotek' => 'Apotek Utama',
                'is_active' => true,
            ],

            // PENCERNAAN
            [
                'nama_obat' => 'Antasida DOEN',
                'kategori' => 'Maag',
                'gejala' => 'Nyeri lambung, mual, perih',
                'deskripsi' => 'Obat untuk mengatasi asam lambung berlebih',
                'stok' => 70,
                'harga' => 10000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Mylanta',
                'kategori' => 'Maag',
                'gejala' => 'Maag, kembung, nyeri ulu hati',
                'deskripsi' => 'Antasida cair untuk meredakan maag dengan cepat',
                'stok' => 45,
                'harga' => 25000,
                'lokasi_apotek' => 'Apotek Utama',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Oralit',
                'kategori' => 'Diare',
                'gejala' => 'Diare, dehidrasi',
                'deskripsi' => 'Larutan elektrolit untuk rehidrasi saat diare',
                'stok' => 90,
                'harga' => 3000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'New Diatabs',
                'kategori' => 'Diare',
                'gejala' => 'Diare akut',
                'deskripsi' => 'Obat diare untuk menghentikan diare dengan cepat',
                'stok' => 65,
                'harga' => 8000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],

            // ALERGI
            [
                'nama_obat' => 'Cetirizine 10mg',
                'kategori' => 'Alergi',
                'gejala' => 'Gatal, biduran, bersin',
                'deskripsi' => 'Antihistamin untuk mengatasi reaksi alergi',
                'stok' => 55,
                'harga' => 7000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Loratadine',
                'kategori' => 'Alergi',
                'gejala' => 'Alergi rhinitis, gatal kulit',
                'deskripsi' => 'Antihistamin yang tidak menyebabkan kantuk',
                'stok' => 48,
                'harga' => 9000,
                'lokasi_apotek' => 'Apotek Utama',
                'is_active' => true,
            ],

            // VITAMIN & SUPLEMEN
            [
                'nama_obat' => 'Vitamin C 500mg',
                'kategori' => 'Vitamin',
                'gejala' => 'Daya tahan tubuh lemah',
                'deskripsi' => 'Suplemen vitamin C untuk meningkatkan imunitas',
                'stok' => 150,
                'harga' => 15000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Multivitamin',
                'kategori' => 'Vitamin',
                'gejala' => 'Lelah, kurang vitamin',
                'deskripsi' => 'Kombinasi vitamin dan mineral untuk kesehatan',
                'stok' => 100,
                'harga' => 20000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],

            // LUKA & PERAWATAN
            [
                'nama_obat' => 'Betadine Solution',
                'kategori' => 'Antiseptik',
                'gejala' => 'Luka ringan',
                'deskripsi' => 'Antiseptik untuk membersihkan luka',
                'stok' => 40,
                'harga' => 30000,
                'lokasi_apotek' => 'Apotek Utama',
                'is_active' => true,
            ],
            [
                'nama_obat' => 'Hansaplast',
                'kategori' => 'Perawatan Luka',
                'gejala' => 'Luka lecet, goresan',
                'deskripsi' => 'Plester luka untuk melindungi luka ringan',
                'stok' => 200,
                'harga' => 5000,
                'lokasi_apotek' => 'Semua Apotek',
                'is_active' => true,
            ],
        ];

        // Distribusi obat ke mitra secara acak
        foreach ($obatsData as $obatData) {
            $mitra = $mitras->random(); // Pilih mitra secara acak

            Obat::create(array_merge($obatData, [
                'mitra_id' => $mitra->id
            ]));
        }

        $this->command->info('✅ ' . count($obatsData) . ' obat berhasil ditambahkan');
    }
}
