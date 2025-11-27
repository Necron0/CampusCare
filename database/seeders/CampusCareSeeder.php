<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Obat;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Hash;

class CampusCareSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'rassya@mail.com'],
            ['name' => 'Rassya', 'password' => Hash::make('password')]
        );

        $para = Obat::create([
            'nama' => 'Paracetamol',
            'kategori' => 'Demam',
            'gejala' => 'Pusing, demam',
            'harga' => 8000
        ]);

        $obh = Obat::create([
            'nama' => 'OBH Combi',
            'kategori' => 'Batuk',
            'gejala' => 'Batuk',
            'harga' => 15000
        ]);

        $antasida = Obat::create([
            'nama' => 'Antasida',
            'kategori' => 'Maag',
            'gejala' => 'Nyeri lambung',
            'harga' => 12000
        ]);

        $order1 = Order::create(['user_id' => $user->id]);
        OrderItem::create([
            'order_id' => $order1->id,
            'obat_id' => $para->id,
            'qty' => 2,
            'price' => $para->harga
        ]);

        $order2 = Order::create(['user_id' => $user->id]);
        OrderItem::create([
            'order_id' => $order2->id,
            'obat_id' => $obh->id,
            'qty' => 1,
            'price' => $obh->harga
        ]);

        Konsultasi::create([
            'user_id' => $user->id,
            'topik' => 'Batuk 3 hari',
            'hasil' => 'Disarankan obat batuk dan istirahat.'
        ]);

        Konsultasi::create([
            'user_id' => $user->id,
            'topik' => 'Pusing dan demam',
            'hasil' => 'Minum paracetamol 3x sehari.'
        ]);
    }
}
