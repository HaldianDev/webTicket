<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PengaduanComment;


class PengaduanController extends Controller
{
    public function index()
    {
        return view('form-ticket');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $filePath = $request->file('file')->store('uploads', 'public');

        $ticketNumber = $this->generateTicketNumber();

        Pengaduan::create([
            'user_id'        => auth()->id(),
            'ticket_number'  => $ticketNumber,
            'jenis_laporan'  => $validated['jenis_laporan'],
            'kategori'       => $validated['kategori'],
            'keterangan'     => $validated['keterangan'],
            'phone'          => $validated['phone'],
            'lokasi'         => $validated['lokasi'],
            'file_path'      => $filePath,
            'status'         => 'pending',
        ]);

        return redirect()->route('pengaduan.history')
            ->with('success', 'Pengaduan berhasil dikirim dengan nomor tiket: ' . $ticketNumber);
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan = $this->mapColors($pengaduan);

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        if ($pengaduan->status !== 'pending') {
            abort(403, 'Pengaduan tidak dapat diedit karena status sudah ' . $pengaduan->status);
        }

        return view('pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->status !== 'pending') {
            abort(403, 'Pengaduan tidak dapat diedit karena status sudah ' . $pengaduan->status);
        }

        $validated = $request->validate([
            'kategori'   => 'required|string|max:255',
            'keterangan' => 'required|string',
            'phone'      => ['required', 'string', 'regex:/^(?:\+62|0)8[1-9][0-9]{6,10}$/'],
            'lokasi'     => 'required|string|max:255',
            'file'       => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ], [
            'phone.regex' => 'Nomor telepon harus valid nomor Indonesia.',
            'file.mimes'  => 'File harus jpeg, jpg, png, atau pdf.',
            'file.max'    => 'Ukuran file maksimal 2MB.',
        ]);

        if ($request->hasFile('file')) {
            if ($pengaduan->file_path) {
                Storage::disk('public')->delete($pengaduan->file_path);
            }

            $validated['file_path'] = $request->file('file')->store('uploads', 'public');
        }

        $pengaduan->update([
            'kategori'   => $validated['kategori'],
            'keterangan' => $validated['keterangan'],
            'phone'      => $validated['phone'],
            'lokasi'     => $validated['lokasi'],
            'file_path'  => $validated['file_path'] ?? $pengaduan->file_path,
        ]);

        return redirect()->route('pengaduan.history', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function history(Request $request)
    {
        $userId = auth()->id();

        $pengaduans = Pengaduan::query()
            ->where('user_id', $userId)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('ticket_number', 'like', "%{$request->search}%")
                        ->orWhere('kategori', 'like', "%{$request->search}%")
                        ->orWhere('jenis_laporan', 'like', "%{$request->search}%")
                        ->orWhere('keterangan', 'like', "%{$request->search}%");
                });
            })
            ->latest()
            ->get()
            ->map(fn ($item) => $this->mapColors($item));

        return view('pengaduan.history', compact('pengaduans'));
    }


    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'jenis_laporan' => 'required|string|max:255',
            'kategori'      => 'required|string|max:255',
            'keterangan'    => 'required|string',
            'phone'         => ['required', 'string', 'regex:/^(?:\+62|0)8[1-9][0-9]{6,10}$/'],
            'lokasi'        => 'required|string|max:255',
            'file'          => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ], [
            'phone.regex'   => 'Nomor telepon harus valid nomor Indonesia.',
            'file.required' => 'File wajib diunggah.',
            'file.mimes'    => 'File harus berupa jpeg, jpg, png, atau pdf.',
            'file.max'      => 'Ukuran file maksimal 2MB.',
        ]);
    }

    private function generateTicketNumber(): string
    {
        $date = now()->format('Ymd');
        $countToday = Pengaduan::whereDate('created_at', now()->toDateString())->count() + 1;

        return 'TKT' . $date . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
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



    public function addComment(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $pengaduan->comments()->create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
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
            'message' => 'required|string|max:1000',
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
            ],
        ]);
    }


    public function statistik()
{
    $userId = auth()->id();

    $total = Pengaduan::where('user_id', $userId)->count();

    $aktif = Pengaduan::where('user_id', $userId)
        ->whereIn('status', ['pending', 'diproses'])
        ->count();

    $selesai = Pengaduan::where('user_id', $userId)
        ->where('status', 'selesai')
        ->count();

    $ditolak = Pengaduan::where('user_id', $userId)
        ->where('status', 'ditolak')
        ->count();

    $rataRataJam = Pengaduan::where('user_id', $userId)
        ->where('status', 'selesai')
        ->whereNotNull('updated_at')
        ->get()
        ->map(fn($item) => $item->created_at->diffInHours($item->updated_at))
        ->avg();

    $terbaru = Pengaduan::where('user_id', $userId)
        ->latest()
        ->take(3)
        ->get()
        ->map(fn($item) => $this->mapColors($item));

    $statusDistribusi = [
        'open'       => Pengaduan::where('user_id', $userId)->where('status', 'pending')->count(),
        'onprogress' => Pengaduan::where('user_id', $userId)->where('status', 'diproses')->count(),
        'resolved'   => Pengaduan::where('user_id', $userId)->where('status', 'selesai')->count(),
        'rejected'   => Pengaduan::where('user_id', $userId)->where('status', 'ditolak')->count(),
    ];

    return view('statistik', compact(
        'total',
        'aktif',
        'selesai',
        'ditolak',
        'rataRataJam',
        'terbaru',
        'statusDistribusi'
    ));
}





}
