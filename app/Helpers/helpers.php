<?php

use App\Helpers\Helper;

if (!function_exists('storeFile')) {
    function storeFile(string $key, string $folder = 'files', string $disk = 'public'): ?string
    {
        return Helper::storeFile($key, $folder, $disk);
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile(?string $path, string $disk = 'public'): void
    {
        Helper::deleteFile($path, $disk);
    }
}

if (!function_exists('fileUpload')) {
    function fileUpload($file, string $folder = 'uploads', string $disk = 'public'): ?string
    {
        return Helper::fileUpload($file, $folder, $disk);
    }
}

if (!function_exists('removeFile')) {
    function removeFile(?string $path, string $disk = 'public'): bool
    {
        return Helper::removeFile($path, $disk);
    }
}
