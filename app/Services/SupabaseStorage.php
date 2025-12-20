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
    public static function deleteByUrl(?string $publicUrl): void
    {
        if (!$publicUrl) {
            // Nothing to delete
            return;
        }

        // Extract path inside the bucket
        $bucket = config('services.supabase.bucket');
        $pattern = '/\/storage\/v1\/object\/public\/' . preg_quote($bucket, '/') . '\/(.+)$/';
        if (!preg_match($pattern, $publicUrl, $matches)) {
            // Could not extract path, skip deletion to be safe
            return;
        }

        $path = $matches[1];

        // Send DELETE request to Supabase
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.supabase.key'),
            'apikey' => config('services.supabase.key'),
        ])->delete(config('services.supabase.url') . '/storage/v1/object/' . $bucket . '/' . $path);

        if (!$response->successful()) {
            // Log the error but don’t crash
            \Log::warning('Supabase delete failed: ' . $response->body());
        }
    }
}
