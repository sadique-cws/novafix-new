<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use ImageKit\ImageKit;
class ImageKitHelper
{
    public static function uploadImage($file, $folder = 'default')
    {
        if (!$file) {
            return null;
        }

        $publicKey = config('services.imagekit.public_key');
        $privateKey = config('services.imagekit.private_key');
        $urlEndpoint = config('services.imagekit.url_endpoint');

        if (!$publicKey || !$privateKey || !$urlEndpoint) {
            Log::error('ImageKit configuration is missing in .env or config/services.php');
            return null;
        }

        try {
            $imageKit = new ImageKit(
                publicKey: $publicKey,
                privateKey: $privateKey,
                urlEndpoint: $urlEndpoint
            );

            $fileData = [
                'file' => base64_encode(file_get_contents($file->getRealPath())),
                'fileName' => uniqid() . '.' . $file->getClientOriginalExtension(),
                'folder' => $folder,
            ];

            $upload = $imageKit->upload($fileData);

            if (isset($upload->result->url) && isset($upload->result->fileId)) {
                return [
                    'url' => $upload->result->url,
                    'fileId' => $upload->result->fileId,
                ];
            }

            Log::error('ImageKit upload failed: ' . json_encode($upload->error ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('ImageKit Exception: ' . $e->getMessage());
        }

        return null;
    }

    public static function deleteImage($fileId)
    {
        if (!$fileId) {
            return;
        }

        $publicKey = config('services.imagekit.public_key');
        $privateKey = config('services.imagekit.private_key');
        $urlEndpoint = config('services.imagekit.url_endpoint');

        if (!$publicKey || !$privateKey || !$urlEndpoint) {
            Log::error('ImageKit configuration is missing in .env or config/services.php');
            return;
        }

        try {
            $imageKit = new ImageKit(
                publicKey: $publicKey,
                privateKey: $privateKey,
                urlEndpoint: $urlEndpoint
            );

            $result = $imageKit->deleteFile($fileId);
            if (isset($result->error)) {
                Log::error('ImageKit deletion failed for fileId ' . $fileId . ': ' . json_encode($result->error));
            }
        } catch (\Exception $e) {
            Log::error('ImageKit Exception during deletion: ' . $e->getMessage());
        }
    }
}