<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Konsultasi;
use App\Models\User;
use App\Models\Mitra;

class KonsultasiSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'pengguna')->get();
        $mitras = Mitra::all();

        if ($users->isEmpty() || $mitras->isEmpty()) {
            $this->command->warn('Tidak ada user atau mitra. Skip seeding konsultasi.');
            return;
        }

        $dataKonsultasi = [
            [
                'user_id' => $users->random()->id,
                'mitra_id' => $mitras->random()->id,
                'kategori' => 'Batuk',
                'topik' => 'Batuk Berdahak 3 Hari',
                'keluhan' => 'Saya batuk berdahak sudah 3 hari, kadang disertai demam ringan. Obat apa yang cocok?',
                'gejala_tambahan' => 'Tenggorokan agak sakit, sedikit sesak napas',
                'riwayat_alergi' => null,
                'urgensi' => 'sedang',
                'catatan' => 'Mohon rekomendasi obat yang aman',
                'jawaban' => 'Untuk batuk berdahak bisa menggunakan OBH Combi 3x sehari. Jika disertai demam, tambahkan Paracetamol. Perbanyak minum air hangat dan istirahat.',
                'dokter' => 'apt. Dr. Budi Santoso',
                'rekomendasi_obat' => 'OBH Combi, Paracetamol 500mg',
                'dijawab_pada' => now()->subHours(2),
                'status' => 'selesai',
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => $users->random()->id,
                'mitra_id' => $mitras->random()->id,
                'kategori' => 'Demam',
                'topik' => 'Demam Tinggi Sejak Kemarin',
                'keluhan' => 'Demam tinggi 38.5°C sejak kemarin malam, disertai pusing dan lemas',
                'gejala_tambahan' => 'Badan pegal-pegal, tidak ada nafsu makan',
                'riwayat_alergi' => 'Alergi antibiotik golongan penisilin',
                'urgensi' => 'tinggi',
                'catatan' => null,
                'jawaban' => 'Segera konsumsi Paracetamol 500mg setiap 6 jam. Kompres air hangat, banyak minum air putih. Jika demam tidak turun dalam 3 hari, segera ke dokter.',
                'dokter' => 'apt. Siti Nurhaliza',
                'rekomendasi_obat' => 'Paracetamol 500mg, Vitamin C',
                'dijawab_pada' => now()->subHours(1),
                'status' => 'selesai',
                'created_at' => now()->subHours(5),
            ],
            [
                'user_id' => $users->random()->id,
                'mitra_id' => $mitras->random()->id,
                'kategori' => 'Pencernaan',
                'topik' => 'Sakit Perut dan Diare',
                'keluhan' => 'Sakit perut sejak pagi, sudah BAB 5 kali dengan konsistensi cair',
                'gejala_tambahan' => 'Mual tapi tidak muntah',
                'riwayat_alergi' => null,
                'urgensi' => 'sedang',
                'catatan' => 'Kemarin makan di luar',
                'jawaban' => null,
                'dokter' => null,
                'rekomendasi_obat' => null,
                'dijawab_pada' => null,
                'status' => 'diproses',
                'created_at' => now()->subHours(2),
            ],
            [
                'user_id' => $users->random()->id,
                'mitra_id' => null,
                'kategori' => 'Kepala',
                'topik' => 'Sakit Kepala Berkepanjangan',
                'keluhan' => 'Sakit kepala sebelah kiri sudah 2 hari, terasa berdenyut',
                'gejala_tambahan' => 'Mata agak kabur saat sakit kepala muncul',
                'riwayat_alergi' => null,
                'urgensi' => 'sedang',
                'catatan' => null,
                'jawaban' => null,
                'dokter' => null,
                'rekomendasi_obat' => null,
                'dijawab_pada' => null,
                'status' => 'menunggu',
                'created_at' => now()->subMinutes(30),
            ],
            [
                'user_id' => $users->random()->id,
                'mitra_id' => $mitras->random()->id,
                'kategori' => 'Kulit',
                'topik' => 'Gatal-gatal dan Ruam Kulit',
                'keluhan' => 'Muncul bintik-bintik merah di tangan dan kaki yang sangat gatal sejak 3 hari lalu',
                'gejala_tambahan' => 'Kulit kering dan bersisik di area yang gatal',
                'riwayat_alergi' => 'Alergi debu dan udara dingin',
                'urgensi' => 'rendah',
                'catatan' => 'Sudah coba pakai bedak tapi tidak membaik',
                'jawaban' => null,
                'dokter' => null,
                'rekomendasi_obat' => null,
                'dijawab_pada' => null,
                'status' => 'menunggu',
                'created_at' => now()->subMinutes(15),
            ],
        ];

        foreach ($dataKonsultasi as $data) {
            Konsultasi::create($data);
        }

        $this->command->info('✅ Seeder konsultasi berhasil dijalankan!');
    }
}
