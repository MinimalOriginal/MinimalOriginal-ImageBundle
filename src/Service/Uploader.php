<?php
namespace MinimalOriginal\ImageBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Gaufrette\Filesystem;

class Uploader
{
    private static $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/tiff'
    );

    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file)
    {
        // Check if the file's mime type is in the list of allowed mime types.

        if (!in_array($file->getClientMimeType(), self::$allowedMimeTypes)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }

        $hash = sha1(uniqid(mt_rand(), true));
        $dir = sprintf('%s/%s/', substr($hash, 0, 2), substr($hash, 2, 2));
        $filename = sprintf('%s.%s', substr($hash, 4), $file->getClientOriginalExtension());
        $path = $dir.$filename;

        $adapter = $this->filesystem->getAdapter();
        $adapter->setMetadata($path, array('contentType' => $file->getClientMimeType()));
        $adapter->write($path, file_get_contents($file->getPathname()));

        return array("dir"=>$dir,"filename"=>$filename);
    }
}
