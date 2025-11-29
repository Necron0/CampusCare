<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mitra;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $mitrasData = [
            ['email' => 'mitra1@apotek.com', 'nama_apotek' => 'Apotek Sehat Sentosa', 'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat', 'telepon' => '021-5551234', 'rating' => 4.5, 'aktif' => true],
            ['email' => 'mitra2@apotek.com', 'nama_apotek' => 'Apotek Medika Farma', 'alamat' => 'Jl. Gatot Subroto No. 45, Jakarta Selatan', 'telepon' => '021-5555678', 'rating' => 4.7, 'aktif' => true],
            ['email' => 'mitra3@apotek.com', 'nama_apotek' => 'Apotek Kimia Farma 24 Jam', 'alamat' => 'Jl. MH Thamrin No. 78, Jakarta Pusat', 'telepon' => '021-5559012', 'rating' => 4.3, 'aktif' => true],
            ['email' => 'mitra4@apotek.com', 'nama_apotek' => 'Apotek K-24 Kesehatan', 'alamat' => 'Jl. Kuningan Raya No. 12, Jakarta Selatan', 'telepon' => '021-5553456', 'rating' => 4.6, 'aktif' => true],
            ['email' => 'mitra5@apotek.com', 'nama_apotek' => 'Apotek Guardian Plus', 'alamat' => 'Jl. HR Rasuna Said No. 34, Jakarta Selatan', 'telepon' => '021-5557890', 'rating' => 4.4, 'aktif' => false],
        ];

        foreach ($mitrasData as $mitra) {
            $user = User::where('email', $mitra['email'])->first();
            if ($user) {
                Mitra::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama_apotek' => $mitra['nama_apotek'],
                        'alamat' => $mitra['alamat'],
                        'telepon' => $mitra['telepon'],
                        'rating' => $mitra['rating'],
                        'aktif' => $mitra['aktif'],
                    ]
                );
            }
        }
    }
}
