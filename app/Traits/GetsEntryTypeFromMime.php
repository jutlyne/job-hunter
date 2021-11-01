<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GetsEntryTypeFromMime
{
    protected function getTypeFromMime($file): string
    {
        $originalMime = $file->getMimeType();

        switch ($originalMime) {
            case Str::contains($originalMime, ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp']):
                return 'image';
            default:
                return 'file';
        }
    }
}