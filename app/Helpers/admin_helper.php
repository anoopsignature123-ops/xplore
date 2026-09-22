<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\WebSettings;



if (!function_exists('settingData')) {
    function settingData()
    {
        return WebSettings::first();
    }
}
 


if (!function_exists('deleteFile')) {
    function deleteFile($filePath)
    {
        if (!$filePath) {
            return;
        }
 
        // If it's a new file stored in storage/app/public
        if (stripos($filePath, 'storage/') === 0) {
            $relativePath = substr($filePath, 8); // remove 'storage/' 
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        } 
        // Backward compatibility: If it's an old file stored in public folder
        else {
            $fullPath = public_path($filePath);
            if (file_exists($fullPath) && !is_dir($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}



if (!function_exists("validate_slug")) {
    function validate_slug($text, string $divider = '-') {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}
 



if (!function_exists('uploadImage')) {
    function uploadImage($file, $uploadDir = null, $oldImage = null)
    {
        // Delete old image
        if (!empty($oldImage)) {
            deleteFile($oldImage);
        }

        // Filename generation
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $limitedName  = substr($originalName, 0, 20);
        $slugName     = validate_slug($limitedName);
        $uniqueSuffix = uniqid() . '_' . mt_rand(100, 999);
        $extension    = strtolower($file->getClientOriginalExtension());

        $filename = "{$slugName}-{$uniqueSuffix}.{$extension}";

        // Base upload path in storage
        $relativePath = '';
        if (!empty($uploadDir)) {
            $relativePath = trim($uploadDir, '/');
        }

        $destinationPath = storage_path('app/public' . ($relativePath ? '/' . $relativePath : ''));

        // Create folder if not exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Move file
        $file->move($destinationPath, $filename);

        $returnPath = 'storage/' . ($relativePath ? $relativePath . '/' : '') . $filename;

        return [
            'image' => $returnPath
        ];
    }
}




