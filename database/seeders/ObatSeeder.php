<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        // biar gak dobel kalau seeder di-run berkali2
        Obat::truncate();

        Obat::insert([
            // === DEMAM / NYERI ===
            [
                'nama' => 'Paracetamol',
                'kategori' => 'Demam',
                'gejala' => 'Pusing, panas',
                'deskripsi' => 'Penurun demam dan pereda nyeri.',
                'stok' => 50, 'harga' => 5000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],
            [
                'nama' => 'Ibuprofen',
                'kategori' => 'Nyeri',
                'gejala' => 'Nyeri otot, sakit kepala',
                'deskripsi' => 'Anti nyeri dan anti inflamasi.',
                'stok' => 40, 'harga' => 12000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],
            [
                'nama' => 'Bodrex',
                'kategori' => 'Sakit Kepala',
                'gejala' => 'Pusing, migrain ringan',
                'deskripsi' => 'Pereda sakit kepala.',
                'stok' => 25, 'harga' => 8000,
                'lokasi_apotek' => 'Apotek Sehat', 'is_active' => true
            ],

            // === BATUK / FLU ===
            [
                'nama' => 'OBH Combi',
                'kategori' => 'Batuk',
                'gejala' => 'Batuk berdahak',
                'deskripsi' => 'Membantu melegakan tenggorokan.',
                'stok' => 30, 'harga' => 15000,
                'lokasi_apotek' => 'Apotek Sehat', 'is_active' => true
            ],
            [
                'nama' => 'Decolgen',
                'kategori' => 'Flu',
                'gejala' => 'Pilek, hidung tersumbat',
                'deskripsi' => 'Obat flu dan demam.',
                'stok' => 35, 'harga' => 10000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],
            [
                'nama' => 'Mixagrip Flu',
                'kategori' => 'Flu',
                'gejala' => 'Flu, meriang',
                'deskripsi' => 'Meredakan gejala flu.',
                'stok' => 28, 'harga' => 9000,
                'lokasi_apotek' => 'Apotek Medika', 'is_active' => true
            ],

            // === LAMBUNG / PENCERNAAN ===
            [
                'nama' => 'Antasida Doen',
                'kategori' => 'Lambung',
                'gejala' => 'Maag, perut perih',
                'deskripsi' => 'Mengurangi asam lambung berlebih.',
                'stok' => 20, 'harga' => 8000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],
            [
                'nama' => 'Promag',
                'kategori' => 'Lambung',
                'gejala' => 'Maag, mual',
                'deskripsi' => 'Obat maag cepat.',
                'stok' => 22, 'harga' => 11000,
                'lokasi_apotek' => 'Apotek Sehat', 'is_active' => true
            ],
            [
                'nama' => 'Diapet',
                'kategori' => 'Diare',
                'gejala' => 'Diare ringan',
                'deskripsi' => 'Mengurangi frekuensi BAB.',
                'stok' => 18, 'harga' => 7000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],

            // === ALERGI / KULIT ===
            [
                'nama' => 'CTM',
                'kategori' => 'Alergi',
                'gejala' => 'Gatal, bersin',
                'deskripsi' => 'Obat alergi ringan.',
                'stok' => 30, 'harga' => 6000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],
            [
                'nama' => 'Loratadine',
                'kategori' => 'Alergi',
                'gejala' => 'Biduran, gatal',
                'deskripsi' => 'Antihistamin non-mengantuk.',
                'stok' => 12, 'harga' => 18000,
                'lokasi_apotek' => 'Apotek Medika', 'is_active' => true
            ],
            [
                'nama' => 'Salep Hidrokortison',
                'kategori' => 'Kulit',
                'gejala' => 'Ruam, iritasi',
                'deskripsi' => 'Salep untuk radang kulit.',
                'stok' => 10, 'harga' => 22000,
                'lokasi_apotek' => 'Apotek Sehat', 'is_active' => true
            ],

            // === VITAMIN ===
            [
                'nama' => 'Vitamin C 500mg',
                'kategori' => 'Vitamin',
                'gejala' => 'Imunitas rendah',
                'deskripsi' => 'Menjaga daya tahan tubuh.',
                'stok' => 50, 'harga' => 15000,
                'lokasi_apotek' => 'Apotek Kampus', 'is_active' => true
            ],
            [
                'nama' => 'Sangobion',
                'kategori' => 'Suplemen',
                'gejala' => 'Kurang darah',
                'deskripsi' => 'Suplemen penambah darah.',
                'stok' => 20, 'harga' => 27000,
                'lokasi_apotek' => 'Apotek Medika', 'is_active' => true
            ],
            [
                'nama' => 'Vitacimin',
                'kategori' => 'Vitamin',
                'gejala' => 'Sariawan',
                'deskripsi' => 'Vitamin C tablet hisap.',
                'stok' => 40, 'harga' => 8000,
                'lokasi_apotek' => 'Apotek Sehat', 'is_active' => true
            ],

            // === ANTIBIOTIK (contoh nonaktif) ===
            [
                'nama' => 'Amoxicillin',
                'kategori' => 'Infeksi',
                'gejala' => 'Radang, infeksi bakteri',
                'deskripsi' => 'Antibiotik (butuh resep).',
                'stok' => 10, 'harga' => 25000,
                'lokasi_apotek' => 'Apotek Medika', 'is_active' => false
            ],
        ]);
    }
}
