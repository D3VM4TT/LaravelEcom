<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FileHelper
{

    public static function uploadImage(UploadedFile $file, string $path):string {
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path($path), $filename);
        return $filename;
    }

}
