<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadsFiles
{
    private function uploadPublicFile(?UploadedFile $file, string $folder): ?string
    {
        if (! $file) {
            return null;
        }

        $target = public_path('uploads/'.$folder);
        if (! is_dir($target)) {
            mkdir($target, 0755, true);
        }

        $name = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($target, $name);

        return 'uploads/'.$folder.'/'.$name;
    }
}
