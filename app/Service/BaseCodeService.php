<?php

namespace App\Service;

use ErrorException;

class BaseCodeService
{
    public function encodeLogoMail($path=null): string
    {
        if (is_null($path)) {
            $imagePath = $this->imagePath('/storage/' . config('media.default.mail_logo'));
            $imageData = $this->imageData($imagePath);
        } else {
            $imageData = $this->imageData($path);
        }
        return $this->imageSrc($imageData);
    }

    public function imagePath($path): string
    {
        return public_path($path);
    }

    public function imageData($path): string|null
    {
        try {
            return base64_encode(file_get_contents($path));
        } catch (ErrorException $e) {
            return null;
        }
    }

    public function imageSrc($data): string
    {
        return 'data:image/png;base64,' . $data;
    }
}
