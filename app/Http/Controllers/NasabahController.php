<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksiProduk;
use App\Models\MutasiSaldo;
use App\Models\Pembayaran;
use App\Models\PenarikanSaldo;
use App\Models\PermohonanJemput;
use App\Models\ProdukOlahan;
use App\Models\Sampah;
use App\Models\TransaksiProduk;
use App\Models\TransaksiSetor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NasabahController extends Controller
{
    /**
     * Dashboard Utama Nasabah
     */
    public function dashboard()
    {
        $user = Auth::user();
        $riwayatSetor = TransaksiSetor::where('id_user', $user->id_user)
            ->with('details.sampah')
            ->latest('tanggal_setor')
            ->take(5)
            ->get();

        $penarikanTerakhir = PenarikanSaldo::where('id_user', $user->id_user)
            ->latest('tanggal_pengajuan')
            ->take(3)
            ->get();

        $jemputTerakhir = PermohonanJemput::where('id_user', $user->id_user)
            ->latest('created_at')
            ->take(3)
            ->get();

        $produkRekomendasi = ProdukOlahan::where('is_aktif', true)->take(3)->get();
        $daftarSampah = Sampah::where('is_aktif', true)->with('kategori')->get();

        return view('nasabah.dashboard', compact('user', 'riwayatSetor', 'penarikanTerakhir', 'jemputTerakhir', 'produkRekomendasi', 'daftarSampah'));
    }

    /**
     * Halaman & Proses Penarikan Saldo
     */
    public function tarikSaldoIndex()
    {
        $user = Auth::user();
        $riwayatPenarikan = PenarikanSaldo::where('id_user', $user->id_user)
            ->latest('tanggal_pengajuan')
            ->paginate(10);

        return view('nasabah.tarik_saldo', compact('user', 'riwayatPenarikan'));
    }

    public function tarikSaldoStore(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nominal_penarikan' => ['required', 'numeric', 'min:20000'],
            'metode_pencairan' => ['required', 'in:transfer_bank,ewallet,tunai'],
            'nama_bank' => ['required', 'string', 'max:100'],
            'nomor_rekening' => ['required', 'string', 'max:50'],
            'atas_nama' => ['required', 'string', 'max:150'],
        ], [
            'nominal_penarikan.required' => 'Nominal penarikan wajib diisi.',
            'nominal_penarikan.min' => 'Batas minimal penarikan adalah Rp 20.000.',
            'nama_bank.required' => 'Pilihan e-wallet wajib dipilih.',
            'nomor_rekening.required' => 'Nomor HP e-wallet wajib diisi.',
            'atas_nama.required' => 'Nama pemilik akun e-wallet wajib diisi.',
        ]);

        $nominal = (float) $validated['nominal_penarikan'];
        $saldoMengendapMinimal = 10000;

        // Cek kecukupan saldo
        if ($user->saldo < ($nominal + $saldoMengendapMinimal)) {
            $tersedia = max(0, $user->saldo - $saldoMengendapMinimal);
            return back()->with('error', 'Saldo tidak mencukupi! Saldo Anda saat ini Rp ' . number_format($user->saldo, 0, ',', '.') . '. Terdapat saldo mengendap minimal Rp 10.000, sehingga maksimal penarikan Anda adalah Rp ' . number_format($tersedia, 0, ',', '.'))->withInput();
        }

        // Cek apakah ada penarikan yang masih berstatus 'diajukan' atau 'diproses'
        $pending = PenarikanSaldo::where('id_user', $user->id_user)
            ->whereIn('status_penarikan', ['diajukan', 'diproses'])
            ->exists();

        if ($pending) {
            return back()->with('error', 'Anda masih memiliki permohonan penarikan yang sedang diproses. Mohon tunggu hingga proses selesai.');
        }

        DB::transaction(function () use ($user, $validated, $nominal) {
            $kodePenarikan = 'WD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // Simpan permohonan
            PenarikanSaldo::create([
                'kode_penarikan' => $kodePenarikan,
                'id_user' => $user->id_user,
                'nominal_penarikan' => $nominal,
                'biaya_admin' => 0.00,
                'total_diterima' => $nominal,
                'metode_pencairan' => $validated['metode_pencairan'],
                'nama_bank' => $validated['nama_bank'],
                'nomor_rekening' => $validated['nomor_rekening'],
                'atas_nama' => $validated['atas_nama'],
                'status_penarikan' => 'diajukan',
                'tanggal_pengajuan' => now(),
            ]);

            // Potong saldo langsung (Balance Lock) agar tidak terjadi double spending
            $saldoSebelum = $user->saldo;
            $saldoSesudah = $saldoSebelum - $nominal;

            $user->update(['saldo' => $saldoSesudah]);

            // Catat ke Mutasi Kas
            MutasiSaldo::create([
                'id_user' => $user->id_user,
                'jenis_mutasi' => 'debit',
                'jumlah' => $nominal,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'kategori_transaksi' => 'penarikan_saldo',
                'referensi_kode' => $kodePenarikan,
                'keterangan' => 'Pengajuan penarikan dana ke ' . $validated['nama_bank'] . ' (' . $validated['nomor_rekening'] . ') an. ' . $validated['atas_nama'],
            ]);
        });

        return redirect()->route('nasabah.tarik_saldo')->with('success', 'Permohonan penarikan saldo berhasil diajukan! Admin keuangan akan memverifikasi dan mengirimkan dana.');
    }

    /**
     * Halaman & Proses Permohonan Jemput Armada Bentor
     */
    public function jemputSampahIndex()
    {
        $user = Auth::user();
        $riwayatJemput = PermohonanJemput::with('petugas')
            ->where('id_user', $user->id_user)
            ->latest('created_at')
            ->paginate(10);

        return view('nasabah.jemput_sampah', compact('user', 'riwayatJemput'));
    }

    public function jemputSampahStore(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tanggal_rencana_jemput' => ['required', 'date', 'after_or_equal:today'],
            'waktu_preferensi' => ['required', 'string'],
            'estimasi_berat' => ['required', 'numeric', 'min:5'],
            'alamat_jemput' => ['required', 'string'],
            'patokan_lokasi' => ['nullable', 'string'],
            'catatan_nasabah' => ['nullable', 'string'],
        ], [
            'tanggal_rencana_jemput.required' => 'Tanggal rencana jemput wajib diisi.',
            'tanggal_rencana_jemput.after_or_equal' => 'Tanggal jemput tidak boleh di masa lampau.',
            'estimasi_berat.required' => 'Estimasi berat sampah wajib diisi.',
            'estimasi_berat.min' => 'Minimal berat sampah untuk jemputan Bentor adalah 5 Kg.',
            'alamat_jemput.required' => 'Alamat penjemputan wajib diisi.',
        ]);

        $kodeJemput = 'JMP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        PermohonanJemput::create([
            'kode_penjemputan' => $kodeJemput,
            'id_user' => $user->id_user,
            'tanggal_rencana_jemput' => $validated['tanggal_rencana_jemput'],
            'waktu_preferensi' => $validated['waktu_preferensi'],
            'estimasi_berat' => $validated['estimasi_berat'],
            'alamat_jemput' => $validated['alamat_jemput'],
            'patokan_lokasi' => $validated['patokan_lokasi'] ?? null,
            'catatan_nasabah' => $validated['catatan_nasabah'] ?? null,
            'status_jemput' => 'menunggu',
        ]);

        return redirect()->route('nasabah.jemput_sampah')->with('success', 'Permohonan jemput sampah armada Bentor berhasil dikirim! Petugas kami akan mengonfirmasi jadwal Anda.');
    }

    /**
     * Riwayat Buku Tabungan & Mutasi
     */
    public function riwayatTabungan()
    {
        $user = Auth::user();
        $mutasi = MutasiSaldo::where('id_user', $user->id_user)
            ->latest('created_at')
            ->paginate(15);

        $riwayatSetor = TransaksiSetor::where('id_user', $user->id_user)
            ->with(['details.sampah', 'petugas'])
            ->latest('tanggal_setor')
            ->paginate(10);

        return view('nasabah.riwayat_tabungan', compact('user', 'mutasi', 'riwayatSetor'));
    }

    /**
     * Katalog Produk Olahan (Pupuk Organik, Lilin Jelantah)
     */
    public function katalogProduk()
    {
        $user = Auth::user();
        $produk = ProdukOlahan::where('is_aktif', true)->get();

        $pesananSaya = TransaksiProduk::where('id_user', $user->id_user)
            ->with(['details.produk', 'pembayaran'])
            ->latest('created_at')
            ->get();

        return view('nasabah.katalog_produk', compact('user', 'produk', 'pesananSaya'));
    }

    /**
     * Order Beli Produk Olahan
     */
    public function beliProduk(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'id_produk' => ['required', 'exists:produk_olahan,id_produk'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'metode_bayar' => ['required', 'in:virtual_gateway,saldo_sampah'],
            'alamat_pengiriman' => ['required', 'string'],
        ], [
            'jumlah.min' => 'Minimal pembelian 1 item.',
            'alamat_pengiriman.required' => 'Alamat pengiriman / pengambilan wajib diisi.',
        ]);

        $produk = ProdukOlahan::findOrFail($validated['id_produk']);

        if ($produk->stok < $validated['jumlah']) {
            return back()->with('error', 'Maaf, stok produk tidak mencukupi! Sisa stok: ' . $produk->stok);
        }

        $totalTagihan = $produk->harga_rupiah * $validated['jumlah'];

        // Jika bayar pakai Saldo Sampah
        if ($validated['metode_bayar'] === 'saldo_sampah') {
            if ($user->saldo < $totalTagihan) {
                return back()->with('error', 'Saldo tabungan sampah Anda tidak mencukupi untuk membeli produk ini! Saldo Anda: Rp ' . number_format($user->saldo, 0, ',', '.') . ', total tagihan: Rp ' . number_format($totalTagihan, 0, ',', '.'));
            }

            DB::transaction(function () use ($user, $produk, $validated, $totalTagihan) {
                $kodeOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

                $order = TransaksiProduk::create([
                    'kode_order' => $kodeOrder,
                    'id_user' => $user->id_user,
                    'total_tagihan' => $totalTagihan,
                    'metode_bayar' => 'saldo_sampah',
                    'status_order' => 'dibayar',
                    'alamat_pengiriman' => $validated['alamat_pengiriman'],
                    'tanggal_order' => now(),
                ]);

                DetailTransaksiProduk::create([
                    'id_transaksi_produk' => $order->id_transaksi_produk,
                    'id_produk' => $produk->id_produk,
                    'jumlah' => $validated['jumlah'],
                    'harga_saat_transaksi' => $produk->harga_rupiah,
                    'subtotal' => $totalTagihan,
                ]);

                // Kurangi stok
                $produk->decrement('stok', $validated['jumlah']);

                // Potong saldo nasabah
                $saldoSebelum = $user->saldo;
                $saldoSesudah = $saldoSebelum - $totalTagihan;
                $user->update(['saldo' => $saldoSesudah]);

                // Catat mutasi
                MutasiSaldo::create([
                    'id_user' => $user->id_user,
                    'jenis_mutasi' => 'debit',
                    'jumlah' => $totalTagihan,
                    'saldo_sebelum' => $saldoSebelum,
                    'saldo_sesudah' => $saldoSesudah,
                    'kategori_transaksi' => 'beli_produk',
                    'referensi_kode' => $kodeOrder,
                    'keterangan' => 'Pembelian produk ' . $produk->nama_produk . ' (' . $validated['jumlah'] . ' ' . $produk->satuan . ') menggunakan saldo tabungan',
                ]);
            });

            return redirect()->route('nasabah.katalog')->with('success', 'Pembelian berhasil menggunakan saldo tabungan! Produk akan segera disiapkan petugas.');
        }

        // Jika bayar via Virtual Gateway (QRIS / VA)
        $pembayaran = null;
        DB::transaction(function () use ($user, $produk, $validated, $totalTagihan, &$pembayaran) {
            $kodeOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $order = TransaksiProduk::create([
                'kode_order' => $kodeOrder,
                'id_user' => $user->id_user,
                'total_tagihan' => $totalTagihan,
                'metode_bayar' => 'virtual_gateway',
                'status_order' => 'menunggu_pembayaran',
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'tanggal_order' => now(),
            ]);

            DetailTransaksiProduk::create([
                'id_transaksi_produk' => $order->id_transaksi_produk,
                'id_produk' => $produk->id_produk,
                'jumlah' => $validated['jumlah'],
                'harga_saat_transaksi' => $produk->harga_rupiah,
                'subtotal' => $totalTagihan,
            ]);

            // Generate invoice & nomor VA / QRIS
            $bankCode = '8800' . rand(1000, 9999) . rand(1000, 9999);
            $kodeInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            $pembayaran = Pembayaran::create([
                'kode_invoice' => $kodeInvoice,
                'id_transaksi_produk' => $order->id_transaksi_produk,
                'id_user' => $user->id_user,
                'metode_pembayaran' => 'va_bca',
                'nomor_va_atau_paycode' => $bankCode,
                'nominal' => $totalTagihan,
                'status_pembayaran' => 'menunggu',
                'waktu_transaksi' => now(),
                'waktu_kedaluwarsa' => now()->addMinutes(30),
            ]);
        });

        return redirect()->route('nasabah.payment_simulator', $pembayaran->id_pembayaran);
    }

    /**
     * Halaman Virtual Payment Gateway Simulator (Solusi 2 - Mandiri Tanpa Tunnel)
     */
    public function paymentSimulator($id_pembayaran)
    {
        $pembayaran = Pembayaran::with(['transaksi.details.produk', 'user'])->findOrFail($id_pembayaran);

        // Hanya pemilik invoice yang boleh mengakses
        if ($pembayaran->id_user !== Auth::id()) {
            abort(403);
        }

        return view('nasabah.payment_simulator', compact('pembayaran'));
    }

    /**
     * Eksekusi Simulasi Bayar Berhasil
     */
    public function simulasiBayarSuccess(Request $request, $id_pembayaran)
    {
        $pembayaran = Pembayaran::with('transaksi.details.produk')->findOrFail($id_pembayaran);

        if ($pembayaran->status_pembayaran !== 'menunggu') {
            return back()->with('info', 'Tagihan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($pembayaran, $request) {
            $metode = $request->input('metode_pembayaran', 'va_bca');

            $pembayaran->update([
                'status_pembayaran' => 'lunas',
                'waktu_lunas' => now(),
                'metode_pembayaran' => $metode,
                'simulasi_bank_ref' => 'REF-' . strtoupper(Str::random(10)),
            ]);

            // Update status pesanan produk jadi dibayar
            $order = $pembayaran->transaksi;
            $order->update(['status_order' => 'dibayar']);

            // Kurangi stok produk
            foreach ($order->details as $d) {
                $d->produk->decrement('stok', $d->jumlah);
            }
        });

        return redirect()->route('nasabah.katalog')->with('success', 'Simulasi Pembayaran Berhasil! Tagihan lunas dan pesanan Anda sedang disiapkan.');
    }

    /**
     * Daftar Harga Komoditas Sampah
     */
    public function hargaSampah()
    {
        $kategori = \App\Models\KategoriSampah::with('sampah')->get();
        return view('nasabah.harga_sampah', compact('kategori'));
    }

    /**
     * Cetak Resi Tabungan Sampah Nasabah
     */
    public function cetakResi($id_transaksi_setor)
    {
        $transaksi = TransaksiSetor::where('id_user', Auth::id())
            ->with(['nasabah', 'petugas', 'details.sampah.kategori'])
            ->findOrFail($id_transaksi_setor);

        return view('shared.nota_timbangan', compact('transaksi'));
    }
}

