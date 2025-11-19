<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Obat;
use App\Models\Promosi;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Ulasan;
use App\Models\Konsultasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Users
        $users = [
            [
                'role' => 'admin',
                'name' => 'Admin Utama',
                'email' => 'admin@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Budi Apotek',
                'email' => 'mitra1@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Siti Farma',
                'email' => 'mitra2@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Andi Medika',
                'email' => 'mitra3@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Dewi Kesehatan',
                'email' => 'mitra4@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'mitra',
                'name' => 'Eko Guardian',
                'email' => 'mitra5@apotek.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'pengguna',
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
            [
                'role' => 'pengguna',
                'name' => 'Siti Rahmawati',
                'email' => 'siti@email.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // Cari berdasarkan email
                $user // Update atau create dengan data ini
            );
        }

        // Seed Mitras (1 user = 1 apotek)
        $mitras = [
            [
                'user_id' => 2, // Budi Apotek
                'nama_apotek' => 'Apotek Sehat Sentosa',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'telepon' => '021-5551234',
                'rating' => 4.5,
                'aktif' => true,
            ],
            [
                'user_id' => 3, // Siti Farma
                'nama_apotek' => 'Apotek Medika Farma',
                'alamat' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan',
                'telepon' => '021-5555678',
                'rating' => 4.7,
                'aktif' => true,
            ],
            [
                'user_id' => 4, // Andi Medika
                'nama_apotek' => 'Apotek Kimia Farma 24 Jam',
                'alamat' => 'Jl. MH Thamrin No. 78, Jakarta Pusat',
                'telepon' => '021-5559012',
                'rating' => 4.3,
                'aktif' => true,
            ],
            [
                'user_id' => 5, // Dewi Kesehatan
                'nama_apotek' => 'Apotek K-24 Kesehatan',
                'alamat' => 'Jl. Kuningan Raya No. 12, Jakarta Selatan',
                'telepon' => '021-5553456',
                'rating' => 4.6,
                'aktif' => true,
            ],
            [
                'user_id' => 6, // Eko Guardian
                'nama_apotek' => 'Apotek Guardian Plus',
                'alamat' => 'Jl. HR Rasuna Said No. 34, Jakarta Selatan',
                'telepon' => '021-5557890',
                'rating' => 4.4,
                'aktif' => false,
            ],
        ];

        foreach ($mitras as $mitra) {
            Mitra::create($mitra);
        }

        // Seed Obats
        $obats = [
            [
                'mitra_id' => 1,
                'nama' => 'Paracetamol 500mg',
                'deskripsi' => 'Obat penurun panas dan pereda nyeri',
                'harga' => 15000,
                'stok' => 100,
                'foto' => 'paracetamol.jpg',
            ],
            [
                'mitra_id' => 1,
                'nama' => 'Amoxicillin 500mg',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri',
                'harga' => 35000,
                'stok' => 50,
                'foto' => 'amoxicillin.jpg',
            ],
            [
                'mitra_id' => 2,
                'nama' => 'Vitamin C 1000mg',
                'deskripsi' => 'Suplemen vitamin C untuk daya tahan tubuh',
                'harga' => 45000,
                'stok' => 80,
                'foto' => 'vitamin-c.jpg',
            ],
            [
                'mitra_id' => 2,
                'nama' => 'OBH Combi Batuk',
                'deskripsi' => 'Obat batuk dan flu',
                'harga' => 28000,
                'stok' => 60,
                'foto' => 'obh-combi.jpg',
            ],
            [
                'mitra_id' => 3,
                'nama' => 'Antasida DOEN',
                'deskripsi' => 'Obat maag dan sakit perut',
                'harga' => 12000,
                'stok' => 120,
                'foto' => 'antasida.jpg',
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }

        // Seed Promosis
        $promosis = [
            [
                'obat_id' => 1,
                'diskon' => 10,
                'mulai' => now()->subDays(5),
                'berakhir' => now()->addDays(25),
            ],
            [
                'obat_id' => 2,
                'diskon' => 15,
                'mulai' => now()->subDays(3),
                'berakhir' => now()->addDays(27),
            ],
            [
                'obat_id' => 3,
                'diskon' => 20,
                'mulai' => now(),
                'berakhir' => now()->addDays(30),
            ],
            [
                'obat_id' => 4,
                'diskon' => 5,
                'mulai' => now()->subDays(10),
                'berakhir' => now()->addDays(20),
            ],
            [
                'obat_id' => 5,
                'diskon' => 12,
                'mulai' => now()->subDays(2),
                'berakhir' => now()->addDays(28),
            ],
        ];

        foreach ($promosis as $promosi) {
            Promosi::create($promosi);
        }

        // Seed Pesanans
        $pesanans = [
            [
                'user_id' => 7, // Budi Santoso (pengguna)
                'mitra_id' => 1,
                'total' => 150000,
                'status' => 'selesai',
                'alamat_pengantaran' => 'Jl. Kebon Jeruk No. 56, Jakarta Barat',
            ],
            [
                'user_id' => 8, // Siti Rahmawati (pengguna)
                'mitra_id' => 2,
                'total' => 85000,
                'status' => 'dikirim',
                'alamat_pengantaran' => 'Jl. Mangga Dua No. 23, Jakarta Utara',
            ],
            [
                'user_id' => 7,
                'mitra_id' => 1,
                'total' => 120000,
                'status' => 'pending',
                'alamat_pengantaran' => 'Jl. Kebon Jeruk No. 56, Jakarta Barat',
            ],
            [
                'user_id' => 8,
                'mitra_id' => 3,
                'total' => 95000,
                'status' => 'selesai',
                'alamat_pengantaran' => 'Jl. Cempaka Putih No. 78, Jakarta Pusat',
            ],
            [
                'user_id' => 7,
                'mitra_id' => 2,
                'total' => 65000,
                'status' => 'dibatalkan',
                'alamat_pengantaran' => 'Jl. Kebon Jeruk No. 56, Jakarta Barat',
            ],
        ];

        foreach ($pesanans as $pesanan) {
            Pesanan::create($pesanan);
        }

        // Seed Pesanan Details
        $pesananDetails = [
            [
                'pesanan_id' => 1,
                'obat_id' => 1,
                'jumlah' => 5,
                'subtotal' => 75000,
            ],
            [
                'pesanan_id' => 1,
                'obat_id' => 2,
                'jumlah' => 2,
                'subtotal' => 70000,
            ],
            [
                'pesanan_id' => 2,
                'obat_id' => 3,
                'jumlah' => 1,
                'subtotal' => 45000,
            ],
            [
                'pesanan_id' => 2,
                'obat_id' => 4,
                'jumlah' => 1,
                'subtotal' => 28000,
            ],
            [
                'pesanan_id' => 3,
                'obat_id' => 1,
                'jumlah' => 8,
                'subtotal' => 120000,
            ],
        ];

        foreach ($pesananDetails as $detail) {
            PesananDetail::create($detail);
        }

        // Seed Ulasans
        $ulasans = [
            [
                'pesanan_id' => 1,
                'mitra_id' => 1,
                'user_id' => 7,
                'rating' => 5,
                'komentar' => 'Pelayanan sangat memuaskan, obat lengkap dan pengiriman cepat!',
            ],
            [
                'pesanan_id' => 4,
                'mitra_id' => 3,
                'user_id' => 8,
                'rating' => 4,
                'komentar' => 'Bagus, hanya saja pengiriman sedikit terlambat.',
            ],
            [
                'pesanan_id' => 1,
                'mitra_id' => 1,
                'user_id' => 7,
                'rating' => 5,
                'komentar' => 'Apotek terpercaya, harga bersaing!',
            ],
            [
                'pesanan_id' => 2,
                'mitra_id' => 2,
                'user_id' => 8,
                'rating' => 4,
                'komentar' => 'Pelayanan ramah, packaging rapi.',
            ],
            [
                'pesanan_id' => 4,
                'mitra_id' => 3,
                'user_id' => 8,
                'rating' => 3,
                'komentar' => 'Cukup baik, namun bisa lebih ditingkatkan lagi.',
            ],
        ];

        foreach ($ulasans as $ulasan) {
            Ulasan::create($ulasan);
        }

        // Seed Konsultasis
        $konsultasis = [
            [
                'user_id' => 7,
                'mitra_id' => 1,
                'topik' => 'Konsultasi Demam',
                'pesan' => 'Saya mengalami demam tinggi sudah 2 hari, obat apa yang cocok?',
                'respon' => 'Sebaiknya konsumsi Paracetamol 500mg setiap 6 jam. Jika demam tidak turun dalam 3 hari, segera ke dokter.',
                'status' => 'closed',
            ],
            [
                'user_id' => 8,
                'mitra_id' => 2,
                'topik' => 'Vitamin untuk Daya Tahan Tubuh',
                'pesan' => 'Vitamin apa yang bagus untuk meningkatkan imunitas?',
                'respon' => 'Vitamin C 1000mg sangat baik untuk daya tahan tubuh. Konsumsi 1x sehari.',
                'status' => 'closed',
            ],
            [
                'user_id' => 7,
                'mitra_id' => 1,
                'topik' => 'Batuk Berdahak',
                'pesan' => 'Saya batuk berdahak sudah seminggu, obat apa yang efektif?',
                'respon' => null,
                'status' => 'open',
            ],
            [
                'user_id' => 8,
                'mitra_id' => 3,
                'topik' => 'Sakit Maag',
                'pesan' => 'Maag saya sering kambuh, obat apa yang aman dikonsumsi jangka panjang?',
                'respon' => 'Antasida DOEN dapat membantu meredakan gejala. Namun sebaiknya periksa ke dokter untuk penanganan jangka panjang.',
                'status' => 'closed',
            ],
            [
                'user_id' => 7,
                'mitra_id' => 2,
                'topik' => 'Alergi Kulit',
                'pesan' => 'Kulit saya gatal-gatal dan memerah, ada rekomendasi obat?',
                'respon' => null,
                'status' => 'open',
            ],
        ];

        foreach ($konsultasis as $konsultasi) {
            Konsultasi::create($konsultasi);
        }
    }
}
