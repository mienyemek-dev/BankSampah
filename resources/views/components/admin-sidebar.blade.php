{{-- ============================================================ --}}
{{-- SIDEBAR STAF ADMIN — TEMA HIJAU EMERALD KONSISTEN           --}}
{{-- Usage: @include('components.admin-sidebar', ['active' => 'dashboard']) --}}
{{-- ============================================================ --}}
@php $active = $active ?? ''; @endphp
<aside class="w-64 bg-gradient-to-b from-emerald-950 via-emerald-900 to-emerald-950 text-white flex flex-col flex-shrink-0 min-h-screen sticky top-0 border-r border-emerald-800/70 z-30 shadow-2xl">
    {{-- Brand Header --}}
    <div class="p-5 border-b border-emerald-800/70 bg-emerald-950/50">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-circle.png') }}" alt="Logo" class="w-10 h-10 rounded-full border border-emerald-400/50 object-cover shadow-md">
            <div>
                <h2 class="font-extrabold text-sm leading-tight text-white drop-shadow-sm">Bank Sampah</h2>
                <p class="text-xs text-emerald-300 font-semibold drop-shadow-sm">Bumi Sai Wawai</p>
            </div>
        </div>
        <div class="mt-3.5 px-3 py-1.5 rounded-xl bg-emerald-900/80 border border-emerald-700/60 flex items-center justify-between shadow-inner">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-bold text-emerald-100 uppercase tracking-wider">Staf Admin</span>
            </div>
            <span class="text-[10px] text-emerald-300 font-extrabold">Online</span>
        </div>
    </div>

    {{-- Nav Menu --}}
    <nav class="p-3.5 space-y-1 flex-1 overflow-y-auto">
        @php
        $navItems = [
            ['route' => 'admin.dashboard',          'icon' => '📊', 'label' => 'Dashboard',              'key' => 'dashboard'],
            ['route' => 'admin.timbang',             'icon' => '⚖️', 'label' => 'Timbang & Setor',        'key' => 'timbang',   'badge' => 'Input'],
            ['route' => 'admin.stok_sampah',         'icon' => '📦', 'label' => 'Stok & Gudang Depo',     'key' => 'stok',      'badge' => 'Gudang'],
            ['route' => 'admin.penjualan_pengepul',  'icon' => '🏭', 'label' => 'Penjualan Pengepul',     'key' => 'penjualan'],
            ['route' => 'admin.nasabah',             'icon' => '👥', 'label' => 'Data Nasabah',            'key' => 'nasabah'],
            ['route' => 'admin.jemput',              'icon' => '🛺', 'label' => 'Jemput Bentor',           'key' => 'jemput'],
            ['route' => 'admin.harga_sampah',        'icon' => '🏷️', 'label' => 'Master Sampah & Harga',  'key' => 'harga'],
            ['route' => 'admin.transit_limbah',      'icon' => '🏥', 'label' => 'Transit Limbah RS',      'key' => 'transit'],
            ['route' => 'admin.berita',              'icon' => '📰', 'label' => 'Berita & Edukasi',        'key' => 'berita'],
        ];
        @endphp

        @foreach($navItems as $item)
            @php $isActive = ($active === $item['key']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition group
                      {{ $isActive
                           ? 'bg-emerald-600 text-white shadow-md shadow-emerald-950/40 border border-emerald-400/40'
                           : 'text-emerald-100/85 hover:bg-emerald-800/70 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="text-base {{ $isActive ? '' : 'group-hover:scale-110 transition' }}">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </div>
                @if(isset($item['badge']))
                    <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded-full bg-amber-400 text-amber-900">{{ $item['badge'] }}</span>
                @endif
            </a>
        @endforeach
    </nav>

    {{-- User Info + Logout --}}
    <div class="p-4 border-t border-emerald-800/70 bg-emerald-950/50">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-full bg-emerald-700 border border-emerald-500/50 flex items-center justify-center font-extrabold text-sm text-white shadow-sm flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</p>
                <p class="text-[10px] text-emerald-400 truncate">{{ Auth::user()->email ?? 'admin@saiwawai.id' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition flex items-center justify-center gap-2 shadow-sm">
                <span>🚪</span> Keluar Sistem
            </button>
        </form>
    </div>
</aside>

