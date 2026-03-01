<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    private const ALLOWED_EXTENSIONS = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
    private const MIME_EXTENSION_MAP  = [
        'image/jpeg' => 'jpg',
        'image/jpg'  => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    public function uploadFile(UploadedFile $file, string $directory): string
    {
        $fileName  = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $imagePath = $file->storeAs($directory, $fileName, 'public');

        Log::info("Image uploaded to: {$imagePath}");

        return $imagePath;
    }

    public function downloadFromUrl(string $url, string $directory): string
    {
        try {
            $response    = Http::timeout(30)->get($url);
            $contentType = $response->header('Content-Type');

            if (! $response->successful() || ! str_starts_with($contentType, 'image/')) {
                Log::warning("Failed to download image from URL: {$url}");
                return $url; // Fall back to storing the URL directly
            }

            $extension = self::MIME_EXTENSION_MAP[$contentType] ?? 'jpg';
            $fileName  = $directory . '/' . Str::random(40) . '.' . $extension;

            Storage::disk('public')->put($fileName, $response->body());

            Log::info("Image downloaded from URL and stored: {$fileName}");

            return $fileName;
        } catch (\Exception $e) {
            Log::error("Image URL download failed: {$e->getMessage()}");
            return $url;
        }
    }

    public function deleteFile(?string $imagePath): void
    {
        if (! $imagePath || filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return;
        }

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            Log::info("Image deleted: {$imagePath}");
        }
    }

    public function validateImageUrl(string $url): bool
    {
        try {
            $response    = Http::timeout(10)->head($url);
            $contentType = $response->header('Content-Type');

            return $response->successful() && str_starts_with($contentType, 'image/');
        } catch (\Exception $e) {
            return false;
        }
    }
}
