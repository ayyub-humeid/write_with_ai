<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    // helper function to store file and return path without using model
    public static function storeFile(string $key, string $folder = 'files', string $disk = 'public'): ?string
    {
        $request = request();

        if (!$request->hasFile($key)) {
            return null;
        }

        $file = $request->file($key);
        if (!$file->isValid()) {
            return null;
        }

        // Store the file in storage/app/public/{$folder}/ and get the relative path
        // Returns path like: "posts/filename.ext"
        $path = $file->store($folder, $disk);

        // Normalize backslashes to forward slashes for cross-platform compatibility
        return $path ? str_replace('\\', '/', $path) : null;
    }

    public static function deleteFile(?string $path, string $disk = 'public'): void
    {
        if (!$path) {
            return;
        }

        Storage::disk($disk)->delete($path);
    }

    /**
     * Upload a file and return its path.
     */
    public static function fileUpload($file, string $folder = 'uploads', string $disk = 'public'): ?string
    {
        if (!$file) {
            return null;
        }

        $path = $file->store($folder, $disk);
        return $path ? str_replace('\\', '/', $path) : null;
    }

    /**
     * Remove a file from storage.
     */
    public static function removeFile(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        return false;
    }
}