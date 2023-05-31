<?php

namespace App\Twig\Runtime;

use App\Service\FileUploader;
use Symfony\Component\Asset\Packages;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private FileUploader $fileUploader,
        private Packages $packages
    ) {
    }

    public function getUploadedAssetPath(string $path): string
    {
        return $this->packages->getUrl($this->fileUploader->getPublicPath($path));
    }
}
