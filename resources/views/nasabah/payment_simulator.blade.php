<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Payment Gateway - Bank Sampah Bumi Sai Wawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-slate-900 via-teal-950 to-slate-900 font-['Plus_Jakarta_Sans'] text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
        <!-- Header Gateway -->
        <div class="bg-emerald-800 p-6 text-white text-center relative">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-700/80 text-[10px] font-extrabold uppercase tracking-widest text-emerald-200 mb-2">
                Virtual Payment Gateway Simulator
            </span>
            <h1 class="text-xl font-extrabold">Pembayaran Tagihan Online</h1>
            <p class="text-xs text-emerald-200 mt-0.5">Invoice: {{ $pembayaran->kode_invoice }}</p>

            <div class="mt-4 pt-4 border-t border-emerald-700/60 flex items-center justify-between text-xs">
                <span class="text-emerald-200">Total Pembayaran:</span>
                <span class="text-xl font-extrabold text-white">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="p-6 space-y-5">
            <!-- Countdown Timer -->
            <div class="p-3 bg-amber-50 rounded-2xl border border-amber-200/80 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-semibold text-amber-800">
                    <span>⏱️</span> Selesaikan pembayaran dalam:
                </div>
                <span id="countdown" class="text-sm font-extrabold text-amber-900 font-mono">14:59</span>
            </div>

            <!-- Pilih Metode Simulasi -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                    Metode Pembayaran
                </label>
                <div class="grid grid-cols-2 gap-2" id="methodTabs">
                    <button type="button" onclick="setMethod('qris')" id="btn-qris"
                        class="p-3 rounded-xl border-2 border-emerald-600 bg-emerald-50/50 text-xs font-bold text-emerald-900 flex items-center justify-center gap-2">
                        📱 QRIS Dinamis
                    </button>
                    <button type="button" onclick="setMethod('va_bca')" id="btn-va_bca"
                        class="p-3 rounded-xl border-2 border-slate-200 hover:border-slate-300 text-xs font-bold text-slate-700 flex items-center justify-center gap-2">
                        🏦 Virtual Account
                    </button>
                </div>
            </div>

            <!-- Display QRIS -->
            <div id="qrisSection" class="p-5 bg-slate-50 rounded-2xl border border-slate-200 text-center">
                <p class="text-xs font-bold text-slate-700 mb-3">Scan QRIS Menggunakan BCA, GoPay, OVO, atau DANA</p>
                <div class="w-48 h-48 mx-auto bg-white p-3 rounded-2xl shadow-inner border border-slate-200 flex items-center justify-center">
                    <!-- SVG QR Code Visual -->
                    <svg class="w-40 h-40" viewBox="0 0 100 100" fill="currentColor">
                        <path d="M0 0h30v30H0zm5 5v20h20V5H5zm35-5h30v30H40zm5 5v20h20V5H45zM0 40h30v30H0zm5 5v20h20V45H5zm45 0h10v10H50zm15 0h10v10H65zm15 0h10v10H80zm-45 15h10v10H35zm30 0h10v10H65zm15 0h10v10H80zm-45 15h10v10H35zm15 0h10v10H50zm30 0h10v10H80zm-45 15h10v10H35zm30 0h10v10H65zm15 0h10v10H80zM0 80h30v20H0zm5 5v10h20V85H5zm70-45h20v20H75zm5 5v10h10V45H80z" />
                    </svg>
                </div>
                <p class="text-[11px] text-slate-400 mt-3">NMID: ID1020261104998 Bank Sampah Bumi Sai Wawai</p>
            </div>

            <!-- Display Virtual Account -->
            <div id="vaSection" class="p-5 bg-slate-50 rounded-2xl border border-slate-200 hidden">
                <p class="text-xs font-bold text-slate-600 mb-1">Nomor Rekening Virtual Account:</p>
                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-slate-200">
                    <span class="text-base font-extrabold font-mono text-emerald-800 tracking-wider">
                        {{ $pembayaran->nomor_va_atau_paycode ?? '8800123456789012' }}
                    </span>
                    <button type="button" onclick="alert('Nomor Virtual Account tersalin!')" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        Salin
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Dapat ditransfer dari ATM / m-Banking BCA, BRI, Mandiri, atau BNI.</p>
            </div>

            <!-- Panel Simulator Action -->
            <form method="POST" action="{{ route('nasabah.simulasi_bayar', $pembayaran->id_pembayaran) }}">
                @csrf
                <input type="hidden" name="metode_pembayaran" id="inputMetode" value="qris">

                <button type="submit"
                    class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                    <span>⚡ Simulasikan Pembayaran Berhasil</span>
                </button>
            </form>

            <a href="{{ route('nasabah.katalog') }}" class="block text-center text-xs font-semibold text-slate-400 hover:text-slate-600">
                Kembali ke Katalog
            </a>
        </div>
    </div>

    <script>
        function setMethod(method) {
            document.getElementById('inputMetode').value = method;
            const btnQris = document.getElementById('btn-qris');
            const btnVa = document.getElementById('btn-va_bca');
            const qrisSec = document.getElementById('qrisSection');
            const vaSec = document.getElementById('vaSection');

            if (method === 'qris') {
                btnQris.className = 'p-3 rounded-xl border-2 border-emerald-600 bg-emerald-50/50 text-xs font-bold text-emerald-900 flex items-center justify-center gap-2';
                btnVa.className = 'p-3 rounded-xl border-2 border-slate-200 hover:border-slate-300 text-xs font-bold text-slate-700 flex items-center justify-center gap-2';
                qrisSec.classList.remove('hidden');
                vaSec.classList.add('hidden');
            } else {
                btnVa.className = 'p-3 rounded-xl border-2 border-emerald-600 bg-emerald-50/50 text-xs font-bold text-emerald-900 flex items-center justify-center gap-2';
                btnQris.className = 'p-3 rounded-xl border-2 border-slate-200 hover:border-slate-300 text-xs font-bold text-slate-700 flex items-center justify-center gap-2';
                vaSec.classList.remove('hidden');
                qrisSec.classList.add('hidden');
            }
        }

        // Countdown Timer
        let time = 15 * 60;
        setInterval(() => {
            if (time <= 0) return;
            time--;
            const mins = Math.floor(time / 60);
            const secs = time % 60;
            document.getElementById('countdown').innerText = 
                (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
        }, 1000);
    </script>
</body>
</html>

