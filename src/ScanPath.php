<?php


namespace App;


use App\Model\File;
use App\Model\Folder;
use App\Model\ResourceInterface;

class ScanPath
{
    /**
     * @param $path
     * @return ResourceInterface
     * @throws \Exception
     */
    public static function scan($path){
        if (is_dir($path)) {
            $folder = new Folder();
            $folder->setName(basename($path));
            self::dirToObject($path, $folder);
            
            return $folder;
        }
        if(is_file($path)){
            $file = new File();
            $file->setName(basename($path));
            $file->setRealPath(realpath($path));
            $file->setSize(filesize($path));
            $file->setMineType(mime_content_type($path));
            
            return $file;
        }
        
        throw new \Exception(sprintf('Can not find anything at %s', $path));
    }
    
    public static function dirToObject($dir, Folder $folderParent) {
        $scan = scandir($dir);
        foreach ($scan as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                $path = $dir . DIRECTORY_SEPARATOR . $value;
                if (is_dir($path)) {
                    $folder = new Folder();
                    $folder->setName($value);
                    if($folderParent){
                        $folderParent->addFolder($folder);
                    }
                    self::dirToObject($path, $folder);
                } else {
                    $file = new File();
                    $file->setName($value);
                    $file->setRealPath(realpath($path));
                    $file->setSize(filesize($path));
                    $file->setMineType(mime_content_type($path));
                    $folderParent->addFile($file);
                }
            }
        }
    }
}