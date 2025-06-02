<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PengaduanComment;
use Illuminate\Http\Request;

class DaftarPengaduanController extends Controller
{
    /**
     * Tampilkan daftar pengaduan.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Pengaduan::where('status', '!=', 'selesai');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%$search%")
                ->orWhere('kategori', 'like', "%$search%")
                ->orWhere('jenis_laporan', 'like', "%$search%")
                ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        $pengaduans = $query->latest()->paginate(10);

        $kategoriColors = [
            'low' => 'bg-green-100 text-green-700',
            'medium' => 'bg-yellow-400 text-yellow-800',
            'high' => 'bg-red-500 text-red-700',
        ];

        $statusColors = [
            'pending' => 'bg-yellow-300 text-yellow-800',
            'diproses' => 'bg-blue-300 text-blue-800',
            'selesai' => 'bg-green-400 text-green-800',
            'batal' => 'bg-red-300 text-red-800',
        ];

        $pengaduans->getCollection()->transform(function ($item) use ($kategoriColors, $statusColors) {
            $kategoriKey = strtolower(trim($item->kategori));
            $item->kategori_color = $kategoriColors[$kategoriKey] ?? 'bg-gray-400 text-gray-800';

            $statusKey = strtolower(trim($item->status));
            $item->status_color = $statusColors[$statusKey] ?? 'bg-gray-200 text-gray-700';

            return $item;
        });

        $statuses = [
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'batal' => 'Batal',
        ];

        return view('admin.pengaduan.index', compact('pengaduans', 'statuses'));
    }


    /**
     * Perbarui status dari suatu pengaduan.
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,diproses,selesai,batal',
        ]);

        $pengaduan->update(['status' => $validated['status']]);

         return redirect()->route('admin.pengaduan.index')
                     ->with('success', 'Status berhasil diperbaharui');
    }

    public function show(Pengaduan $pengaduan)
    {

        $pengaduan = $this->mapColors($pengaduan);

        // Tambahan untuk file
        if ($pengaduan->file_path) {
            $ext = strtolower(pathinfo($pengaduan->file_path, PATHINFO_EXTENSION));
            $pengaduan->file_ext = $ext;
            $pengaduan->file_url = asset('storage/' . $pengaduan->file_path);
        } else {
            $pengaduan->file_ext = null;
            $pengaduan->file_url = null;
        }

        $statuses = [
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'batal' => 'Batal',
        ];

        return view('admin.pengaduan.show', compact('pengaduan', 'statuses'));
    }

    public function comment(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $pengaduan->comments()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function statistik()
    {
        $total = Pengaduan::count();
        $aktif = Pengaduan::whereIn('status', ['pending', 'diproses'])->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();
        $ditolak = Pengaduan::where('status', 'ditolak')->count();

        // Rata-rata waktu penyelesaian
        $rataRataJam = Pengaduan::whereNotNull('updated_at')
            ->where('status', 'selesai')
            ->get()
            ->map(function ($item) {
                return $item->created_at->diffInHours($item->updated_at);
            })->avg();

        $terbaru = Pengaduan::latest()->take(3)->get()->map(fn ($item) => $this->mapColors($item));

        $statusDistribusi = [
            'open'       => Pengaduan::where('status', 'pending')->count(),
            'onprogress' => Pengaduan::where('status', 'diproses')->count(),
            'resolved'   => Pengaduan::where('status', 'selesai')->count(),
            'rejected'   => Pengaduan::where('status', 'ditolak')->count(),
        ];

        return view('admin.statistik', compact(
            'total', 'aktif', 'selesai', 'ditolak',
            'rataRataJam', 'terbaru', 'statusDistribusi'
        ));
    }

    private function mapColors($pengaduan)
    {
        $kategoriColor = [
            'low'    => 'bg-green-100 text-green-700',
            'medium' => 'bg-yellow-400 text-yellow-800',
            'high'   => 'bg-red-500 text-red-700',
        ];

        $statusColor = [
            'pending'  => 'bg-gray-100 text-gray-800',
            'diproses' => 'bg-yellow-400 text-yellow-800',
            'selesai'  => 'bg-green-100 text-green-700',
            'ditolak'  => 'bg-red-500 text-red-700',
        ];

        $kategoriKey = strtolower($pengaduan->kategori);
        $statusKey = strtolower($pengaduan->status ?? 'pending');

        $pengaduan->kategori_label = ucfirst($kategoriKey);
        $pengaduan->kategori_class = $kategoriColor[$kategoriKey] ?? 'bg-gray-100 text-gray-800';

        $pengaduan->status_label = ucfirst($statusKey);
        $pengaduan->status_class = $statusColor[$statusKey] ?? 'bg-gray-100 text-gray-800';

        return $pengaduan;
    }


    public function getComments(Pengaduan $pengaduan)
    {
        $comments = $pengaduan->comments()->with('user')->latest()->get();

        $data = $comments->map(function($c) {
            return [
                'id' => $c->id,
                'user' => $c->user->name,
                'message' => e($c->message),  // escape HTML untuk aman
                'time' => $c->created_at->diffForHumans(),
                'is_author' => $c->user_id === auth()->id(),
            ];
        });

        return response()->json($data);
    }

    public function postComment(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $comment = $pengaduan->comments()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'user' => $comment->user->name,
                'message' => e($comment->message),
                'time' => $comment->created_at->diffForHumans(),
                'is_author' => true,
            ]
        ]);
    }

}
