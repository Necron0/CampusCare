@extends('admin.layouts.app')

@section('title', 'Detail Mitra - CampusCare')

@section('content')

<main class="p-6 sm:p-8">

    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.mitra-management.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Mitra Apotek</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap dan performa mitra</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $mitra->nama_apotek }}</h2>
                    <div class="flex items-center justify-center mt-2">
                        @if($mitra->aktif)
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">Aktif</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-200">Tidak Aktif</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Pemilik</div>
                            <div class="text-sm font-medium text-gray-900">{{ $mitra->user->name }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Email</div>
                            <div class="text-sm font-medium text-gray-900">{{ $mitra->user->email }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Telepon</div>
                            <div class="text-sm font-medium text-gray-900">{{ $mitra->telepon }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Alamat</div>
                            <div class="text-sm font-medium text-gray-900">{{ $mitra->alamat }}</div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Terdaftar</div>
                            <div class="text-sm font-medium text-gray-900">{{ $mitra->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Rating</h3>
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div class="text-5xl font-bold mb-2">{{ number_format($mitra->rating, 1) }}</div>
                <div class="text-sm opacity-90">Dari {{ $performance['total_reviews'] }} ulasan</div>
            </div>

        </div>

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Pesanan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $performance['total_orders'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">Total pesanan yang diterima</div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($performance['total_revenue'], 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">Total pendapatan</div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Konsultasi</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $performance['total_consultations'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">Total konsultasi dilayani</div>
                </div>

            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($order->status == 'selesai')
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Selesai</span>
                                    @elseif($order->status == 'proses')
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">Proses</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Belum ada pesanan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Ulasan Terbaru</h3>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($recentReviews as $review)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $review->user->name }}</div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        @if($review->komentar)
                        <p class="text-sm text-gray-600 ml-13">{{ $review->komentar }}</p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Belum ada ulasan
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</main>

@endsection
