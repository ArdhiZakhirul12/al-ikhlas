<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UploadedFileController extends Controller
{
    public function show(string $path): BinaryFileResponse|Response
    {
        abort_if(str_contains($path, '..'), 404);

        $storagePath = 'uploads/'.$path;
        if (Storage::disk('public')->exists($storagePath)) {
            return response()->file(Storage::disk('public')->path($storagePath));
        }

        $legacyPublicPath = public_path($storagePath);
        if (is_file($legacyPublicPath)) {
            return response()->file($legacyPublicPath);
        }

        abort(404);
    }
}
