<?php

namespace App\Helpers;

use App\Models\Notifikasi;

class NotifikasiHelper
{
    /**
     * Buat notifikasi pesanan baru
     */
    public static function pesananBaru($mitra_id, $order)
    {
        return Notifikasi::create([
            'mitra_id' => $mitra_id,
            'type' => 'pesanan_baru',
            'judul' => 'Pesanan Baru #' . $order->id,
            'pesan' => 'Anda mendapat pesanan baru dari ' . $order->user->name . ' senilai Rp ' . number_format($order->total_harga, 0, ',', '.'),
            'link' => route('mitra.pesanan.show', $order->id),
            'data' => [
                'order_id' => $order->id,
                'user_name' => $order->user->name,
                'total' => $order->total_harga
            ]
        ]);
    }

    /**
     * Buat notifikasi pertanyaan obat
     */
    public static function pertanyaanObat($mitra_id, $konsultasi)
    {
        return Notifikasi::create([
            'mitra_id' => $mitra_id,
            'type' => 'pertanyaan_obat',
            'judul' => 'Pertanyaan Baru',
            'pesan' => $konsultasi->user->name . ' bertanya tentang ' . $konsultasi->obat->nama_obat,
            'link' => route('mitra.konsultasi.show', $konsultasi->id),
            'data' => [
                'konsultasi_id' => $konsultasi->id,
                'obat_id' => $konsultasi->obat_id
            ]
        ]);
    }

    /**
     * Buat notifikasi pesanan dibatalkan
     */
    public static function pesananDibatalkan($mitra_id, $order)
    {
        return Notifikasi::create([
            'mitra_id' => $mitra_id,
            'type' => 'pesanan_dibatalkan',
            'judul' => 'Pesanan Dibatalkan #' . $order->id,
            'pesan' => 'Pesanan dari ' . $order->user->name . ' telah dibatalkan',
            'link' => route('mitra.pesanan.show', $order->id),
            'data' => [
                'order_id' => $order->id
            ]
        ]);
    }

    /**
     * Buat notifikasi review baru
     */
    public static function reviewBaru($mitra_id, $ulasan)
    {
        return Notifikasi::create([
            'mitra_id' => $mitra_id,
            'type' => 'review_baru',
            'judul' => 'Review Baru ⭐' . $ulasan->rating,
            'pesan' => $ulasan->user->name . ' memberikan review untuk ' . $ulasan->obat->nama_obat,
            'link' => route('mitra.obat.show', $ulasan->obat_id),
            'data' => [
                'ulasan_id' => $ulasan->id,
                'rating' => $ulasan->rating
            ]
        ]);
    }

    /**
     * Buat notifikasi stok rendah
     */
    public static function stokRendah($mitra_id, $obat)
    {
        return Notifikasi::create([
            'mitra_id' => $mitra_id,
            'type' => 'stok_rendah',
            'judul' => 'Stok Rendah!',
            'pesan' => $obat->nama_obat . ' tersisa ' . $obat->stok . ' unit. Segera restok!',
            'link' => route('mitra.obat.edit', $obat->id),
            'data' => [
                'obat_id' => $obat->id,
                'stok' => $obat->stok
            ]
        ]);
    }

    /**
     * Buat notifikasi promosi akan berakhir
     */
    public static function promosiBerakhir($mitra_id, $promosi)
    {
        return Notifikasi::create([
            'mitra_id' => $mitra_id,
            'type' => 'promosi_berakhir',
            'judul' => 'Promosi Akan Berakhir',
            'pesan' => 'Promosi "' . ($promosi->nama_promosi ?? 'Diskon ' . $promosi->diskon . '%') . '" akan berakhir dalam 3 hari',
            'link' => route('mitra.promosi.edit', $promosi->id),
            'data' => [
                'promosi_id' => $promosi->id
            ]
        ]);
    }
}
