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
        @list($type, $file_data) = explode(';', $thumbnail);
        @list(, $file_data) = explode(',', $file_data);
        $imageName = time().rand(1, 1000).'.'.'png';
        $folderName = $imageName;
        Storage::disk()->put($folderName, base64_decode($file_data), '');

        return $imageName;
    }
}