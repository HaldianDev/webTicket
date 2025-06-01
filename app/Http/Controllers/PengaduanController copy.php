<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Tampilkan form pengaduan (tidak digunakan lagi;
     * kita pakai route create dengan parameter layanan).
     */
    public function index()
    {
        return view('form-ticket');
    }


    /**
     * Simpan pengaduan yang dikirim user.
     */
    public function store(Request $request)
    {
     $validated = $this->validateRequest($request);
        // Simpan file yang diunggah
        $filePath = $request->file('file')->store('uploads', 'public');

        // Generate nomor tiket (TKTYYYYMMDD-XXXX)
        $date       = date('Ymd');
        $countToday = Pengaduan::whereDate('created_at', now()->toDateString())->count() + 1;
        $ticketNumber = 'TKT' . $date . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);


        // Simpan ke database
        Pengaduan::create([
            'user_id'       => auth()->id(),
            'ticket_number'  => $ticketNumber,
            'jenis_laporan' => $validated['jenis_laporan'],
            'kategori'       => $validated['kategori'],
            'keterangan'     => $validated['keterangan'],
            'phone'          => $validated['phone'],
            'lokasi'         => $validated['lokasi'],
            'file_path'      => $filePath,
            'status'         => 'pending', // default status
        ]);

        return redirect()->route('pengaduan.history')->with('success', 'Pengaduan berhasil dikirim dengan nomor tiket: ' . $ticketNumber);
    }

    /**
     * Tampilkan detail satu
     */
    public function show(Pengaduan $pengaduan)
    {
          $pengaduan->load('user', 'layanan');

        // Mapping warna kategori
        $kategoriColor = [
            'low'    => 'bg-green-100 text-green-700',
            'medium' => 'bg-yellow-400 text-yellow-800',
            'high'   => 'bg-red-500 text-red-700',
        ];
        // Mapping warna status
        $statusColor = [
            'pending'  => 'bg-gray-100 text-gray-800',
            'diproses' => 'bg-yellow-400 text-yellow-800',
            'selesai'  => 'bg-green-100 text-green-700',
            'ditolak'  => 'bg-red-500 text-red-700',
        ];

        $kategoriKey = strtolower($pengaduan->kategori);
        $statusKey   = strtolower($pengaduan->status ?? 'pending');

        $pengaduan->kategori_label = ucfirst($kategoriKey);
        $pengaduan->kategori_class = $kategoriColor[$kategoriKey] ?? 'bg-gray-100 text-gray-800';

        $pengaduan->status_label = ucfirst($statusKey);
        $pengaduan->status_class = $statusColor[$statusKey] ?? 'bg-gray-100 text-gray-800';

        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Tampilkan form edit pengaduan (hanya jika status = pending).
     */
    public function edit(Pengaduan $pengaduan)
    {
        if ($pengaduan->status !== 'pending') {
            // Tidak boleh edit kalau bukan pending
            abort(403, 'Pengaduan tidak dapat diedit karena status sudah ' . $pengaduan->status);
        }

        return view('pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update pengaduan yang diedit user (hanya jika status = pending).
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->status !== 'pending') {
            abort(403, 'Pengaduan tidak dapat diedit karena status sudah ' . $pengaduan->status);
        }

        $validated = $request->validate([
            'kategori'   => 'required|string|max:255',
            'keterangan' => 'required|string',
            'phone'      => ['required','string','regex:/^(?:\+62|0)8[1-9][0-9]{6,10}$/'],
            'lokasi'     => 'required|string|max:255',
            'file'       => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ], [
            'phone.regex'    => 'Nomor telepon harus valid nomor Indonesia.',
            'file.mimes'     => 'File harus jpeg, jpg, png, atau pdf.',
            'file.max'       => 'Ukuran file maksimal 2MB.',
        ]);

        // Jika user mengupload file baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('file')) {
            if ($pengaduan->file_path) {
                Storage::disk('public')->delete($pengaduan->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('uploads', 'public');
        }

        // Update kolom yang boleh diubah
        $pengaduan->update([
            'kategori'   => $validated['kategori'],
            'keterangan' => $validated['keterangan'],
            'phone'      => $validated['phone'],
            'lokasi'     => $validated['lokasi'],
            'file_path'  => $validated['file_path'] ?? $pengaduan->file_path,
        ]);

        return redirect()
        ->route('pengaduan.show', $pengaduan)
        ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Tampilkan riwayat
     */
    public function history(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%$search%")
                ->orWhere('kategori', 'like', "%$search%")
                ->orWhere('jenis_laporan', 'like', "%$search%")
                ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        $pengaduans = $query->latest()->get();

        $kategoriColor = [
            'low' => 'bg-green-100 text-green-700',
            'medium' => 'bg-yellow-400 text-yellow-800',
            'high' => 'bg-red-500 text-red-700',
        ];

        $statusColor = [
            'pending' => 'bg-gray-100 text-gray-800',
            'diproses' => 'bg-yellow-400 text-yellow-800',
            'selesai' => 'bg-green-100 text-green-700',
            'ditolak' => 'bg-red-500 text-red-700',
        ];

        $pengaduans = $pengaduans->map(function ($item) use ($kategoriColor, $statusColor) {
            $kategoriKey = strtolower($item->kategori);
            $statusKey = strtolower($item->status ?? 'pending');

            $item->kategori_label = ucfirst($kategoriKey);
            $item->kategori_class = $kategoriColor[$kategoriKey] ?? 'bg-gray-100 text-gray-800';

            $item->status_label = ucfirst($statusKey);
            $item->status_class = $statusColor[$statusKey] ?? 'bg-gray-100 text-gray-800';

            return $item;
        });

        return view('pengaduan.history', compact('pengaduans'));
    }
    /**
     * Validasi input pengaduan.
     */
    private function validateRequest(Request $request): array
    {
        $messages = [
            'phone.regex'     => 'Nomor telepon harus valid nomor Indonesia, misal 081234567890.',
            'file.required'   => 'File wajib diunggah.',
            'file.mimes'      => 'File harus berupa jpeg, jpg, png, atau pdf.',
            'file.max'        => 'Ukuran file maksimal 2MB.',
        ];

        return $request->validate([
            'jenis_laporan' => 'required|string|max:255',
            'kategori'      => 'required|string|max:255',
            'keterangan'    => 'required|string',
            'phone'         => ['required', 'string', 'regex:/^(?:\+62|0)8[1-9][0-9]{6,10}$/'],
            'lokasi'        => 'required|string|max:255',
            'file'          => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ], $messages);
    }
}
