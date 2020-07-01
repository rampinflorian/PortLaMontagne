<?php


namespace App\Service;


class FileService
{
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
}