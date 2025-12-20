<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class SupabaseStorage
{
    public static function upload(UploadedFile $file, string $folder): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = trim($folder . '/' . $filename, '/');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.supabase.key'),
            'apikey' => config('services.supabase.key'),
            'Content-Type' => $file->getMimeType(),
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->put(
            config('services.supabase.url') . '/storage/v1/object/' .
                config('services.supabase.bucket') . '/' . $path
        );


        if (!$response->successful()) {
            // dump response for debugging
            throw new \Exception('Supabase upload Failed! ' . $response->body());
        }

        return config('services.supabase.url')
            . '/storage/v1/object/public/'
            . config('services.supabase.bucket')
            . '/' . $path;
    }
}
