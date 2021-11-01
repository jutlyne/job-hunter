<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



trait ImageHandle
{
    public function imageUpload(Request $request)
    {
        foreach ($request->file('image') as $item) {
            $extension = $item->getClientOriginalExtension();
            $fileName = Str::uuid() . '.' . $extension;
            $fullPath = 'blogs/' . time() . $fileName;

            Storage::disk('public')->put($fullPath, file_get_contents($item), 'public');
            $storagePath[]  = Storage::disk('public')->url($fullPath);
            $arrPath[] = $fullPath;
        };
        
        return response()->json([
            'arrPath' => $arrPath,
            'image' => $storagePath
        ]);
    }

    public function removeImage(Request $request)
    {
        $explodeUrl = explode('/',$request->img);
        $url = 'blogs/'. end($explodeUrl);

        Storage::disk('public')->delete($url);
        
        return response()->json([
            'messenger' => 'Done'
        ]);
    }
}
