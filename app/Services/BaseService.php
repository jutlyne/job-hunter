<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;




class BaseService 
{
    protected $file;

    public function resizeImage($file)
    {
        return $img = Image::make(base64_decode($file))->resize(300, 150)->encode('jpg');
    }

    public function uploadImagesBase64($thumbnail)
    {
        $fileName = Str::uuid() . '.jpg';
        $fullPath = 'blogs/' . time() . $fileName;
        @list($type, $file_data) = explode(';', $thumbnail);
        @list(, $file_data) = explode(',', $file_data);
        Storage::disk('public')->put($fullPath, base64_decode($file_data), 'public');

        return $fullPath;
    }
}