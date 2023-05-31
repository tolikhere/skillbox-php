<?php

namespace App\Service;

use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public const ARTICLE_IMAGE = 'articles';

    public function __construct(
        private Filesystem $publicUploadsFilesystem,
        private SluggerInterface $slugger,
        private string $uploadedAssetsBaseUrl
    ) {
    }

    public function uploadArticleImage(File $file, ?string $existingFilename): string
    {
        $originalFilename = pathinfo(
            $file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename(),
            PATHINFO_FILENAME
        );
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        $stream = fopen($file->getPathname(), 'r');

        $this->publicUploadsFilesystem->writeStream(
            self::ARTICLE_IMAGE . '/' . $fileName,
            $stream
        );

        if (is_resource($stream)) {
            fclose($stream);
        }
        if ($existingFilename) {
            $this->publicUploadsFilesystem->delete(self::ARTICLE_IMAGE . '/' . $existingFilename);
        }


        return $fileName;
    }

    public function getPublicPath(string $path): string
    {
        return $this->uploadedAssetsBaseUrl . '/' . $path;
    }
}
