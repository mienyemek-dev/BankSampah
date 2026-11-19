<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Eksekutif Pimpinan - Bank Sampah Bumi Sai Wawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen flex flex-col">

    {{-- ============================================================ --}}
    {{-- TOP EXECUTIVE HEADER                                         --}}
    {{-- ============================================================ --}}
    <header class="bg-emerald-950 text-white shadow-xl sticky top-0 z-40 border-b border-emerald-800/60 no-print">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between gap-4">
            {{-- Brand --}}
            <div class="flex items-center gap-3.5">
                <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-9 h-9 rounded-full border-2 border-emerald-400/40 object-cover shadow">
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="font-extrabold text-sm leading-tight text-white">Bank Sampah Bumi Sai Wawai</h1>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-amber-400 text-amber-950 uppercase tracking-wider">PIMPINAN</span>
                    </div>
                    <p class="text-[10px] text-emerald-400 mt-0.5">Desa Banjar Rejo, Kec. Batanghari, Kab. Lampung Timur</p>
                </div>
            </div>

            {{-- Live Clock + Actions --}}
            <div class="flex items-center gap-2.5">
                <div class="hidden md:block text-right mr-1">
                    <p id="liveClock" class="text-sm font-extrabold text-white font-mono">00:00:00</p>
                    <p id="liveDate" class="text-[10px] text-emerald-400"></p>
                </div>
                <button onclick="window.print()"
                    class="px-3 py-1.5 rounded-lg bg-emerald-800 hover:bg-emerald-700 text-xs font-bold text-emerald-100 transition flex items-center gap-1.5">
                    🖨️ Cetak
                </button>
                <a href="{{ route('home') }}" target="_blank"
                    class="px-3 py-1.5 rounded-lg bg-emerald-800/60 hover:bg-emerald-700 text-xs font-semibold text-white transition flex items-center gap-1.5">
                    🌐 Web Publik
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-xs font-bold text-white transition">
                        🚪 Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- ============================================================ --}}
    {{-- SUB-NAV AKSES CEPAT — Warna beda agar tidak menyatu          --}}
    {{-- ============================================================ --}}
    <div class="bg-emerald-800 border-b border-emerald-700 no-print">
        <div class="max-w-7xl mx-auto px-6 py-2 flex flex-wrap items-center gap-1.5">
            <span class="text-[10px] font-bold text-emerald-300 uppercase tracking-widest mr-2">Akses Cepat:</span>
            @foreach([
                ['route' => 'admin.dashboard',         'icon' => '⚙️', 'label' => 'Operasional Admin'],
                ['route' => 'keuangan.dashboard',       'icon' => '💰', 'label' => 'Keuangan & Kas'],
                ['route' => 'admin.timbang',            'icon' => '⚖️', 'label' => 'Timbang Sampah'],
                ['route' => 'admin.penjualan_pengepul', 'icon' => '🏭', 'label' => 'Penjualan Pabrik'],
                ['route' => 'admin.nasabah',            'icon' => '👥', 'label' => 'Data Nasabah'],
                ['route' => 'admin.berita',             'icon' => '📰', 'label' => 'Berita & Edukasi'],
            ] as $link)
                <a href="{{ route($link['route']) }}"
                    class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-700/60 hover:bg-emerald-600 text-[11px] font-semibold text-white transition">
                    {{ $link['icon'] }} {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- HERO WELCOME BANNER — Latar putih agar terpisah jelas        --}}
    {{-- ============================================================ --}}
    <div class="bg-white border-b border-slate-200 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-wrap items-center justify-between gap-4">
            {{-- Greeting kiri --}}
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center font-extrabold text-xl text-white shadow flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'P', 0, 1)) }}
                </div>
                <div>
                    @php
                        $hour = now('Asia/Jakarta')->hour;
                        $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                    @endphp
                    <p class="text-xs text-slate-500 font-medium"><span id="greeting-text">{{ $greet }}</span>, Pimpinan 👋</p>
                    <h2 class="text-lg font-extrabold text-slate-800 leading-tight">{{ Auth::user()->nama_lengkap }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Ringkasan Kinerja Eksekutif • Pembaruan real-time</p>
                </div>
            </div>

            {{-- KPI highlight kanan --}}
            <div class="flex items-center gap-3">
                <div class="text-center px-4 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200">
                    <p class="text-xl font-extrabold text-emerald-700">{{ number_format($totalNasabah) }}</p>
                    <p class="text-[10px] text-slate-500 font-semibold">Total Nasabah</p>
                </div>
                <div class="text-center px-4 py-2.5 rounded-xl bg-teal-50 border border-teal-200">
                    <p class="text-xl font-extrabold text-teal-700">{{ number_format($totalKgSampah, 0) }}<span class="text-xs font-normal ml-0.5">Kg</span></p>
                    <p class="text-[10px] text-slate-500 font-semibold">Sampah Terkelola</p>
                </div>
                <div class="text-center px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-200">
                    <p class="text-lg font-extrabold text-blue-700">Rp{{ number_format($totalPenjualanPabrik/1000, 0) }}k</p>
                    <p class="text-[10px] text-slate-500 font-semibold">Pendapatan Kas</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT                                                 --}}
    {{-- ============================================================ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-6 flex-1 w-full">

        {{-- ==================== 6 KARTU METRIK UTAMA ==================== --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            @php
                $metrikCards = [
                    ['label' => 'Total Nasabah',     'icon' => '👥', 'value' => number_format($totalNasabah),    'sub' => number_format($totalNasabahAktif).' akun aktif',    'color' => 'emerald'],
                    ['label' => 'Sampah Terkelola',  'icon' => '♻️', 'value' => number_format($totalKgSampah,1).' Kg', 'sub' => number_format($totalTransaksiSetor).' transaksi', 'color' => 'teal'],
                    ['label' => 'Jemput Bentor',     'icon' => '🛺', 'value' => number_format($totalJemputBentor), 'sub' => 'Penjemputan selesai',                               'color' => 'sky'],
                    ['label' => 'Penjualan Pabrik',  'icon' => '🏭', 'value' => 'Rp '.number_format($totalPenjualanPabrik,0,',','.'), 'sub' => 'Kas masuk riil',               'color' => 'blue'],
                    ['label' => 'Pencairan Saldo',   'icon' => '💸', 'value' => 'Rp '.number_format($totalPencairanNasabah,0,',','.'), 'sub' => 'Disalurkan ke nasabah',       'color' => 'rose'],
                    ['label' => 'Surplus Bersih',    'icon' => $surplusOperasional >= 0 ? '📈' : '📉', 'value' => 'Rp '.number_format(abs($surplusOperasional),0,',','.'), 'sub' => $surplusOperasional >= 0 ? 'Surplus kas' : 'Defisit kas', 'color' => $surplusOperasional >= 0 ? 'emerald' : 'rose'],
                ];
            @endphp
            @foreach($metrikCards as $card)
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider leading-tight">{{ $card['label'] }}</span>
                        <span class="text-base group-hover:scale-110 transition">{{ $card['icon'] }}</span>
                    </div>
                    <p class="text-lg font-extrabold text-slate-800 leading-tight">{{ $card['value'] }}</p>
                    <p class="text-[10px] text-slate-400 font-medium mt-1">{{ $card['sub'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- ==================== GRAFIK CHART.JS ==================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Donut: Komposisi Sampah (3 kolom) --}}
            <div class="lg:col-span-3 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-5">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Komposisi Sampah Terpilah</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Distribusi volume per kategori komoditas (Kg)</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">
                        ♻️ {{ number_format($totalKgSampah, 1) }} Kg
                    </span>
                </div>
                <div class="relative h-64">
                    <canvas id="komposisiChart"></canvas>
                    @if($komposisiSampah->isEmpty())
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                            <div class="text-4xl mb-2">📊</div>
                            <p class="text-sm font-semibold">Belum ada data komposisi sampah</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bar: Finansial (2 kolom) --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-5">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Posisi Keuangan Kas</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Penjualan vs Pencairan (Rp)</p>
                    </div>
                </div>

                {{-- Fallback visual bars jika nilai nol semua --}}
                <div class="space-y-4 mb-4">
                    @php
                        $maxVal = max($totalPenjualanPabrik, $totalPencairanNasabah, 1);
                        $finansialItems = [
                            ['label' => 'Penjualan Pabrik', 'value' => $totalPenjualanPabrik, 'color' => 'bg-emerald-500', 'text' => 'text-emerald-700'],
                            ['label' => 'Pencairan Nasabah','value' => $totalPencairanNasabah,'color' => 'bg-rose-400',    'text' => 'text-rose-600'],
                            ['label' => 'Surplus Bersih',   'value' => abs($surplusOperasional), 'color' => $surplusOperasional>=0 ? 'bg-blue-500' : 'bg-amber-400', 'text' => $surplusOperasional>=0 ? 'text-blue-700' : 'text-amber-700'],
                        ];
                    @endphp
                    @foreach($finansialItems as $item)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-semibold text-slate-600">{{ $item['label'] }}</span>
                                <span class="text-xs font-extrabold {{ $item['text'] }}">Rp {{ number_format($item['value'], 0, ',', '.') }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full {{ $item['color'] }} rounded-full transition-all duration-700"
                                     style="width: {{ $maxVal > 0 ? round($item['value'] / $maxVal * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Saldo Nasabah (kewajiban) --}}
                <div class="mt-5 p-4 rounded-xl bg-amber-50 border border-amber-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-amber-800">🏦 Saldo Mengendap Nasabah</p>
                            <p class="text-[10px] text-amber-600">Kewajiban simpanan warga di sistem</p>
                        </div>
                        <p class="text-base font-extrabold text-amber-700">Rp {{ number_format($totalSaldoNasabah, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Limbah medis --}}
                <div class="mt-3 p-4 rounded-xl bg-rose-50 border border-rose-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-rose-800">🏥 Limbah Medis Transit</p>
                            <p class="text-[10px] text-rose-500">Total volume tercatat di depo</p>
                        </div>
                        <p class="text-base font-extrabold text-rose-700">{{ number_format($totalLimbahMedisKg, 1) }} Kg</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ==================== TABEL MONITORING ==================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Setoran Terkini --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">⚖️ Transaksi Penimbangan Terkini</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Aktivitas setor sampah dari warga</p>
                    </div>
                    <a href="{{ route('admin.timbang') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                        Buka Operasional →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">Kode</th>
                                <th class="p-3">Nasabah</th>
                                <th class="p-3 text-center">Berat</th>
                                <th class="p-3 text-right">Nilai (Rp)</th>
                                <th class="p-3 text-center">Nota</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transaksiTerbaru as $trx)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3 font-mono font-bold text-slate-800 text-[11px]">{{ $trx->kode_transaksi }}</td>
                                    <td class="p-3 font-semibold text-slate-700">{{ $trx->nasabah->nama_lengkap ?? 'Nasabah' }}</td>
                                    <td class="p-3 text-center font-bold text-slate-700">{{ number_format($trx->total_berat, 1) }} Kg</td>
                                    <td class="p-3 text-right font-extrabold text-emerald-700">+Rp {{ number_format($trx->total_nominal, 0, ',', '.') }}</td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.nota', $trx->id_transaksi_setor) }}" target="_blank"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 hover:bg-emerald-100 text-slate-500 hover:text-emerald-700 transition text-sm"
                                            title="Cetak Nota">🖨️</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-slate-400">
                                        <div class="text-2xl mb-1">⚖️</div>
                                        Belum ada transaksi setor
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pencairan Terkini --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">💸 Pengajuan Pencairan Saldo</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Penarikan tabungan sampah oleh nasabah</p>
                    </div>
                    <a href="{{ route('keuangan.penarikan') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                        Kelola Keuangan →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-100 text-[10px] tracking-wider">
                            <tr>
                                <th class="p-3">Nasabah</th>
                                <th class="p-3">Metode / Bank</th>
                                <th class="p-3 text-right">Nominal</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($pencairanTerbaru as $tarik)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3 font-semibold text-slate-800">{{ $tarik->nasabah->nama_lengkap ?? 'Nasabah' }}</td>
                                    <td class="p-3">
                                        @php
                                            $bank = strtoupper($tarik->nama_bank ?? 'Tunai');
                                            $bc = match(true) {
                                                str_contains($bank,'DANA')  => 'bg-blue-100 text-blue-800',
                                                str_contains($bank,'GOPAY') => 'bg-sky-100 text-sky-800',
                                                str_contains($bank,'OVO')   => 'bg-purple-100 text-purple-800',
                                                default                     => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $bc }}">{{ $bank }}</span>
                                    </td>
                                    <td class="p-3 text-right font-extrabold text-slate-800">Rp {{ number_format($tarik->nominal_penarikan, 0, ',', '.') }}</td>
                                    <td class="p-3 text-center">
                                        @if(in_array($tarik->status_penarikan, ['selesai','disetujui']))
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">✅ Cair</span>
                                        @elseif(in_array($tarik->status_penarikan, ['diajukan','menunggu_konfirmasi']))
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">⏳ Proses</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">❌ Tolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-400">
                                        <div class="text-2xl mb-1">💸</div>
                                        Belum ada pengajuan pencairan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- ==================== RINGKASAN STATUS SISTEM ==================== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-sm text-slate-800 mb-4">📋 Ringkasan Status Operasional Sistem</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-center">
                    <div class="text-2xl mb-1">⚖️</div>
                    <p class="text-xl font-extrabold text-emerald-700">{{ number_format($totalTransaksiSetor) }}</p>
                    <p class="text-xs text-slate-500 font-semibold">Transaksi Timbang</p>
                </div>
                <div class="p-4 rounded-xl bg-sky-50 border border-sky-100 text-center">
                    <div class="text-2xl mb-1">🛺</div>
                    <p class="text-xl font-extrabold text-sky-700">{{ number_format($totalJemputBentor) }}</p>
                    <p class="text-xs text-slate-500 font-semibold">Penjemputan Selesai</p>
                </div>
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-100 text-center">
                    <div class="text-2xl mb-1">🏦</div>
                    <p class="text-xl font-extrabold text-amber-700">Rp {{ number_format($totalSaldoNasabah, 0, ',', '.') }}</p>
                    <p class="text-xs text-slate-500 font-semibold">Saldo Tabungan Aktif</p>
                </div>
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-center">
                    <div class="text-2xl mb-1">🏥</div>
                    <p class="text-xl font-extrabold text-rose-700">{{ number_format($totalLimbahMedisKg, 1) }} Kg</p>
                    <p class="text-xs text-slate-500 font-semibold">Limbah Medis Transit</p>
                </div>
            </div>
        </div>

    </main>

    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500 mt-auto no-print">
        © {{ date('Y') }} Bank Sampah Bumi Sai Wawai &bull; Panel Eksekutif Pimpinan &bull; Desa Banjar Rejo, Lampung Timur
    </footer>

    {{-- ============================================================ --}}
    {{-- SCRIPTS                                                      --}}
    {{-- ============================================================ --}}
    <script>
        // Live Clock & Sapaan Dinamis
        function updateClock() {
            const now = new Date();
            const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
            const time = [now.getHours(), now.getMinutes(), now.getSeconds()]
                .map(v => String(v).padStart(2,'0')).join(':');
            const date = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
            document.getElementById('liveClock').textContent = time;
            document.getElementById('liveDate').textContent = date;

            const hour = now.getHours();
            let greeting = 'Selamat Pagi';
            if (hour >= 11 && hour < 15) greeting = 'Selamat Siang';
            else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';
            else if (hour >= 18 || hour < 5) greeting = 'Selamat Malam';
            const greetEl = document.getElementById('greeting-text');
            if (greetEl) greetEl.textContent = greeting;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Chart.js — Donut Komposisi Sampah
        document.addEventListener('DOMContentLoaded', () => {
            const komposisiLabels = {!! json_encode($komposisiSampah->pluck('nama_kategori')) !!};
            const komposisiData   = {!! json_encode($komposisiSampah->pluck('total_berat')) !!};

            const ctxK = document.getElementById('komposisiChart')?.getContext('2d');
            if (ctxK && komposisiData.length > 0) {
                new Chart(ctxK, {
                    type: 'doughnut',
                    data: {
                        labels: komposisiLabels,
                        datasets: [{
                            data: komposisiData,
                            backgroundColor: ['#059669','#0284c7','#d97706','#7c3aed','#e11d48','#475569','#0d9488'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12,
                                    padding: 12,
                                    font: { family: '"Plus Jakarta Sans"', size: 11 }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` ${ctx.label}: ${Number(ctx.raw).toLocaleString('id-ID')} Kg`
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>
