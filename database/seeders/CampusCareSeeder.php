<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Obat;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Konsultasi;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Hash;

class CampusCareSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user pengguna
        $user = User::firstOrCreate(
            ['email' => 'rassya@mail.com'],
            [
                'name' => 'Rassya Mahasiswa',
                'password' => Hash::make('password'),
                'role' => 'pengguna',
                'email_verified_at' => now(),
            ]
        );

        // Ambil mitra pertama
        $mitra = Mitra::first();

        if (!$mitra) {
            $this->command->warn('⚠️ Tidak ada mitra. Jalankan MitraSeeder terlebih dahulu.');
            return;
        }

        // Ambil obat-obatan
        $paracetamol = Obat::where('nama_obat', 'like', '%Paracetamol%')->first();
        $obh = Obat::where('nama_obat', 'like', '%OBH%')->first();
        $antasida = Obat::where('nama_obat', 'like', '%Antasida%')->first();

        if (!$paracetamol || !$obh || !$antasida) {
            $this->command->warn('⚠️ Obat tidak ditemukan. Jalankan ObatSeeder terlebih dahulu.');
            return;
        }

        // ✅ ORDER 1 - Selesai
        $order1 = Order::create([
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'nama_penerima' => 'Rassya Mahasiswa',
            'no_hp' => '081234567890',
            'alamat_pengiriman' => 'Kampus POLIJE, Gedung A, Lantai 2',
            'opsi_pengiriman' => 'delivery',
            'ongkir' => 10000,
            'total_harga' => 26000, // (8000 * 2) + 10000
            'status' => 'selesai',
            'catatan' => 'Antar ke resepsionis gedung A',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'obat_id' => $paracetamol->id,
            'qty' => 2,
            'price' => $paracetamol->harga,
            'subtotal' => 2 * $paracetamol->harga,
        ]);

        // ✅ ORDER 2 - Dikirim
        $order2 = Order::create([
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'nama_penerima' => 'Rassya Mahasiswa',
            'no_hp' => '081234567890',
            'alamat_pengiriman' => 'Asrama Mahasiswa Blok C No. 12',
            'opsi_pengiriman' => 'delivery',
            'ongkir' => 10000,
            'total_harga' => 25000, // 15000 + 10000
            'status' => 'dikirim',
            'catatan' => null,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'obat_id' => $obh->id,
            'qty' => 1,
            'price' => $obh->harga,
            'subtotal' => $obh->harga,
        ]);

        // ✅ ORDER 3 - Pickup
        $order3 = Order::create([
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'nama_penerima' => 'Rassya Mahasiswa',
            'no_hp' => '081234567890',
            'alamat_pengiriman' => $mitra->alamat, // Alamat apotek untuk pickup
            'opsi_pengiriman' => 'pickup',
            'ongkir' => 0,
            'total_harga' => 10000,
            'status' => 'diproses',
            'catatan' => 'Akan diambil sore hari',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'obat_id' => $antasida->id,
            'qty' => 1,
            'price' => $antasida->harga,
            'subtotal' => $antasida->harga,
        ]);


        // ✅ ULASAN untuk order yang sudah selesai
        Ulasan::create([
            'order_id' => $order1->id,
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'rating' => 5,
            'komentar' => 'Pelayanan cepat dan ramah. Obat sampai dengan selamat. Terima kasih!',
        ]);

        $this->command->info('✅ Data CampusCare berhasil ditambahkan');
        $this->command->info('   - User: ' . $user->email);
        $this->command->info('   - Orders: 3');
        $this->command->info('   - Konsultasi: 3');
        $this->command->info('   - Ulasan: 1');
    }
}
