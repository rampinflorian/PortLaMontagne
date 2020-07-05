<?php


namespace App\Service;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;

class FileService
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * FileService constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param $image
     * @return string
     */
    public function getFileName($image): string
    {
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        return $newFilename;
    }

    public function deleteFile(string $completeLink): void
    {
        try {
            $this->filesystem->remove($completeLink);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

    }
}