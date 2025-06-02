<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request
     * @param  string
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Validasi tipe file yang diizinkan
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf', 'docx'])) {
            abort(404);
        }


        $path = "openTicket/{$filename}";

        // Periksa apakah file ada
        if (!Storage::disk('s3')->exists($path)) {
            abort(404);
        }

        // Ambil MIME type dari file
        $mimeType = Storage::disk('s3')->mimeType($path);

        // Kembalikan file sebagai stream response
        return response()->stream(function () use ($path) {
            $stream = Storage::disk('s3')->readStream($path);
            while (!feof($stream)) {
                echo fread($stream, 1024 * 8);
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
