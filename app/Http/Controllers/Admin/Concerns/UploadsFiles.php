<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait UploadsFiles
{
    private function uploadPublicFile(?UploadedFile $file, string $folder): ?string
    {
        if (! $file) {
            return null;
        }

        $name = Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = 'uploads/'.$folder.'/'.$name;

        try {
            $stored = $file->storeAs('uploads/'.$folder, $name, 'public');
            if ($stored) {
                return $stored;
            }
        } catch (Throwable) {
            //
        }

        $target = public_path('uploads/'.$folder);
        if (! is_dir($target)) {
            mkdir($target, 0755, true);
        }

        $file->move($target, $name);

        return $path;
    }
}
