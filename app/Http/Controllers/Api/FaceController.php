<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FaceController extends Controller
{
    public function list()
    {
        $files = Storage::disk('local')->files('faces');
        $filenames = array_map(fn($f) => basename($f), $files);

        return response()->json([
            'success' => true,
            'files'   => array_values($filenames),
            'total'   => count($filenames),
        ]);
    }

    public function download(string $filename)
    {
        $filename = basename($filename);
        $path     = 'faces/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan',
            ], 404);
        }

        return Storage::disk('local')->response($path);
    }
}