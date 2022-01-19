<?php

namespace Modules\Dashboard\Services;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
Use RealRashid\SweetAlert\Facades\Alert;

class DashServices
{
    public static function uploadImage($file , $folder)
    {
        return Storage::disk('public')->putFile($folder . '/' . Carbon::now()->getTimestamp(), $file);
    }

    public static function generateSlug($text): string
    {
        return Str::slug($text , '-');
    }
}
