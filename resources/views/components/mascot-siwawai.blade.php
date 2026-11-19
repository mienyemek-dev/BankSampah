{{-- ============================================================ --}}
{{-- KOMPONEN ASISTEN INTERAKTIF: SI WAWAI (MASKOT RESMI)         --}}
{{-- ============================================================ --}}
@php
    $pos = $position ?? 'left';
    $isRight = ($pos === 'right');
@endphp
<div id="siwawai-container" class="fixed bottom-6 {{ $isRight ? 'right-6 flex-row-reverse' : 'left-6' }} z-50 flex items-end gap-3 select-none pointer-events-none transition-all duration-300">
    
    {{-- Balon Percakapan / Speech Bubble --}}
    <div id="siwawai-bubble"
         class="pointer-events-auto bg-white/95 backdrop-blur-md p-4 rounded-3xl {{ $isRight ? 'rounded-br-sm origin-bottom-right' : 'rounded-bl-sm origin-bottom-left' }} shadow-2xl border-2 border-emerald-400/50 max-w-xs sm:max-w-sm mb-6 transition-all duration-300 transform scale-100 opacity-100 relative">
        
        {{-- Header Balon --}}
        <div class="flex items-center justify-between gap-2 mb-2 pb-1.5 border-b border-emerald-100">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-black text-emerald-800 uppercase tracking-wider">Si Wawai Menyapa</span>
            </div>
            <button type="button" onclick="toggleSiWawaiBubble()"
                    class="text-slate-400 hover:text-slate-600 text-xs p-1 rounded-full hover:bg-slate-100 transition"
                    title="Sembunyikan Balon">
                ✕
            </button>
        </div>

        {{-- Isi Pesan Balon (Dinamis) --}}
        <p id="siwawai-text" class="text-xs sm:text-sm text-slate-700 leading-relaxed font-medium">
            Halo! Aku <strong>Si Wawai</strong>, maskot resmi Bank Sampah Bumi Sai Wawai! Klik aku untuk tips memilah sampah dan tabungan ya! 🌿
        </p>

        {{-- Tombol Aksi Cepat --}}
        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2">
            <button type="button" onclick="nextSiWawaiDialog()"
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[11px] font-bold transition">
                <span>💬 Ganti Tips</span>
            </button>

            <span class="text-[10px] text-slate-400 font-semibold" id="siwawai-counter">1/6</span>
        </div>

        {{-- Panah Lancip Balon ke arah Maskot --}}
        <div class="absolute -bottom-2.5 {{ $isRight ? 'right-4 border-b-2 border-r-2' : 'left-4 border-b-2 border-l-2' }} w-4 h-4 bg-white border-emerald-400/50 transform rotate-45"></div>
    </div>

    {{-- Karakter Maskot Si Wawai Mengambang --}}
    <div id="siwawai-avatar-container" class="pointer-events-auto relative cursor-pointer group" onclick="reactSiWawai()" title="Klik Si Wawai!">
        
        {{-- Tombol Minimize Halus saat Hover --}}
        <button type="button" onclick="event.stopPropagation(); minimizeSiWawai();"
                class="absolute -top-2 {{ $isRight ? '-left-2' : '-right-2' }} z-20 w-5 h-5 rounded-full bg-slate-800/80 hover:bg-rose-600 text-white text-[10px] font-bold flex items-center justify-center shadow transition opacity-0 group-hover:opacity-100"
                title="Sembunyikan Maskot">
            ✕
        </button>

        {{-- Aura Cahaya di Belakang Maskot --}}
        <div class="absolute inset-0 rounded-full bg-emerald-400/25 blur-xl group-hover:bg-emerald-400/45 transition-all duration-300 transform scale-90 group-hover:scale-110"></div>

        {{-- Efek Emotikon Melompat saat Diklik --}}
        <div id="siwawai-spark" class="absolute -top-6 left-1/2 -translate-x-1/2 text-xl font-bold opacity-0 transition-all duration-500 pointer-events-none">
            ✨
        </div>

        {{-- Gambar Pose Maskot Si Wawai (Dinamis) --}}
        <div id="siwawai-avatar-wrap" class="relative w-28 h-28 sm:w-32 sm:h-32 transition-transform duration-300 group-hover:scale-105 group-active:scale-95">
            <img id="siwawai-img"
                 src="{{ asset('images/mascot/siwawai-welcome.webp') }}"
                 alt="Maskot Si Wawai"
                 class="w-full h-full object-contain filter drop-shadow-xl animate-float">
        </div>

        {{-- Badge Nama di Bawah Maskot --}}
        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-gradient-to-r from-emerald-700 to-teal-800 text-white font-black text-[10px] tracking-wider uppercase shadow-md border border-emerald-300/40 whitespace-nowrap group-hover:scale-105 transition-transform">
            Si Wawai 🍃
        </div>
    </div>

    {{-- Tombol Kecil Muncul Saat Maskot Diminimize --}}
    <div id="siwawai-pill" class="pointer-events-auto hidden" onclick="restoreSiWawai()">
        <button type="button" 
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold shadow-lg border border-emerald-400/50 transition transform hover:scale-105">
            <span>🌿</span>
            <span>Si Wawai</span>
        </button>
    </div>

</div>

<script>
    // 0. Fungsi Minimize & Restore
    function minimizeSiWawai() {
        const bubble = document.getElementById('siwawai-bubble');
        const avatar = document.getElementById('siwawai-avatar-container');
        const pill = document.getElementById('siwawai-pill');

        if (bubble) bubble.style.display = 'none';
        if (avatar) avatar.style.display = 'none';
        if (pill) pill.classList.remove('hidden');
    }

    function restoreSiWawai() {
        const bubble = document.getElementById('siwawai-bubble');
        const avatar = document.getElementById('siwawai-avatar-container');
        const pill = document.getElementById('siwawai-pill');

        if (pill) pill.classList.add('hidden');
        if (avatar) avatar.style.display = 'block';
        if (bubble && isBubbleVisible) {
            bubble.style.display = 'block';
            bubble.style.opacity = '1';
            bubble.style.transform = 'scale(1)';
        }
    }
    // Data Pose Maskot
    const siwawaiPoses = [
        "{{ asset('images/mascot/siwawai-welcome.webp') }}",
        "{{ asset('images/mascot/siwawai-point.webp') }}",
        "{{ asset('images/mascot/siwawai-proud.webp') }}"
    ];

    // Dialog Edukatif & Interaktif Si Wawai
    const siwawaiDialogs = [
        {
            poseIndex: 0, // Welcome
            text: "Halo sahabat lingkungan! Aku <strong>Si Wawai</strong>, maskot Bank Sampah Bumi Sai Wawai! Siap membantumu mengelola sampah jadi berkah! 👋"
        },
        {
            poseIndex: 1, // Point
            text: "Kabar gembira! Sekarang penarikan tabungan sampah <strong>bisa langsung dicairkan ke E-Wallet</strong> (DANA, GoPay, OVO, ShopeePay, LinkAja) tanpa repot rekening bank! 📲"
        },
        {
            poseIndex: 2, // Proud
            text: "Pilah sampah organik & anorganik dari rumah ya! Sampah terpilah bernilai lebih tinggi dan langsung ditimbang digital di depo kita! ⚖️"
        },
        {
            poseIndex: 1, // Point
            text: "Punya sampah menumpuk tapi gak sempat ke depo? Manfaatkan layanan <strong>Jemput Bentor Desa Banjar Rejo</strong> langsung ke depan rumahmu! 🛵"
        },
        {
            poseIndex: 0, // Welcome
            text: "Pupuk kompos & produk daur ulang berkualitas tinggi juga tersedia di menu katalog, bisa dibeli pakai saldo tabunganmu lho! 🌱"
        },
        {
            poseIndex: 2, // Proud
            text: "<em>'Ubah sampah menjadi berkah, tabungan, dan kelestarian Desa Banjar Rejo.'</em> Terima kasih sudah jadi pahlawan lingkungan hari ini! 🏆"
        }
    ];

    let currentDialogIndex = 0;
    let isBubbleVisible = true;

    function renderSiWawaiDialog(index) {
        const item = siwawaiDialogs[index];
        const textEl = document.getElementById('siwawai-text');
        const imgEl = document.getElementById('siwawai-img');
        const counterEl = document.getElementById('siwawai-counter');

        if (textEl && imgEl && counterEl) {
            // Efek transisi halus
            textEl.style.opacity = '0';
            setTimeout(() => {
                textEl.innerHTML = item.text;
                textEl.style.opacity = '1';
            }, 150);

            // Ganti Pose Maskot
            imgEl.src = siwawaiPoses[item.poseIndex];
            counterEl.innerText = `${index + 1}/${siwawaiDialogs.length}`;
        }
    }

    function nextSiWawaiDialog() {
        currentDialogIndex = (currentDialogIndex + 1) % siwawaiDialogs.length;
        renderSiWawaiDialog(currentDialogIndex);
        showSpark('✨');
    }

    function reactSiWawai() {
        // Jika balon tertutup, buka kembali
        if (!isBubbleVisible) {
            toggleSiWawaiBubble();
            return;
        }

        // Animasi lompat ceria (bounce)
        const wrap = document.getElementById('siwawai-avatar-wrap');
        wrap.classList.add('-translate-y-3');
        setTimeout(() => wrap.classList.remove('-translate-y-3'), 250);

        // Munculkan emote acak
        const sparks = ['💚', '✨', '♻️', '🪙', '🍃', '🌟'];
        const randomSpark = sparks[Math.floor(Math.random() * sparks.length)];
        showSpark(randomSpark);

        // Pindah ke tips berikutnya
        nextSiWawaiDialog();
    }

    function showSpark(icon) {
        const spark = document.getElementById('siwawai-spark');
        if (spark) {
            spark.innerText = icon;
            spark.style.opacity = '1';
            spark.style.transform = 'translate(-50%, -20px) scale(1.3)';
            setTimeout(() => {
                spark.style.opacity = '0';
                spark.style.transform = 'translate(-50%, 0px) scale(1)';
            }, 600);
        }
    }

    function toggleSiWawaiBubble() {
        const bubble = document.getElementById('siwawai-bubble');
        if (bubble) {
            isBubbleVisible = !isBubbleVisible;
            if (isBubbleVisible) {
                bubble.style.display = 'block';
                setTimeout(() => {
                    bubble.style.opacity = '1';
                    bubble.style.transform = 'scale(1)';
                }, 10);
            } else {
                bubble.style.opacity = '0';
                bubble.style.transform = 'scale(0.85)';
                setTimeout(() => {
                    bubble.style.display = 'none';
                }, 300);
            }
        }
    }

    // Auto putar dialog setiap 15 detik jika tidak sedang diklik
    setInterval(() => {
        if (isBubbleVisible) {
            currentDialogIndex = (currentDialogIndex + 1) % siwawaiDialogs.length;
            renderSiWawaiDialog(currentDialogIndex);
        }
    }, 15000);

    // Fungsi Global untuk memicu pesan khusus Si Wawai dari elemen mana saja di halaman
    window.triggerSiWawaiMascot = function(customText, poseType) {
        const textEl = document.getElementById('siwawai-text');
        const imgEl = document.getElementById('siwawai-img');
        const bubble = document.getElementById('siwawai-bubble');

        if (!isBubbleVisible) {
            toggleSiWawaiBubble();
        }

        let pIdx = 0;
        if (poseType === 'point') pIdx = 1;
        else if (poseType === 'proud') pIdx = 2;

        if (imgEl) imgEl.src = siwawaiPoses[pIdx];
        if (textEl) {
            textEl.style.opacity = '0';
            setTimeout(() => {
                textEl.innerHTML = customText;
                textEl.style.opacity = '1';
            }, 150);
        }

        showSpark(pIdx === 2 ? '🏆' : (pIdx === 1 ? '💡' : '👋'));

        // Halus scroll ke arah maskot jika layar mobile
        if (window.innerWidth < 640) {
            const container = document.getElementById('siwawai-container');
            if (container) container.scrollIntoView({ behavior: 'smooth', block: 'end' });
        }
    };
</script>

