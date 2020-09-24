<?php


namespace App;


use App\Model\File;
use App\Model\Folder;

class ScanPath
{
    private string $path;
    
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    public function dirToObject($dir, Folder $folderParent) {
        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                $path = $dir . DIRECTORY_SEPARATOR . $value;
                if (is_dir($path)) {
                    $folder = new Folder();
                    $folder->setName($value);
                    $folder->setParent($folderParent);
                    $this->dirToObject($path, $folder);
                } else {
                    $file = new File();
                    $file->setName($value);
                    $file->setSize(filesize($path));
                    $file->setMineType(mime_content_type($path));
                    $file->setFolder($folderParent);
                }
            }
        }
    }
}