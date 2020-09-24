<?php

use PHPUnit\Framework\TestCase;
use App\Model\Folder;
use App\ScanPath;
use App\Model\File;

final class FolderTest extends TestCase
{
    public function testFolderPath(){
        $folder = new Folder();
        $folder->setName('my-folder');
    
        $this->assertEquals(
            'my-folder/',
            $folder->getFullPath()
        );
        
        $subFolder = new Folder();
        $subFolder->setName('my sub-folder');
        $folder->addFolder($subFolder);
        
        $this->assertEquals(
            'my-folder/my sub-folder/',
            $subFolder->getFullPath()
        );
        
        $subSubFolder = new Folder();
        $subSubFolder->setName('my Sub sub-folder');
        $subFolder->addFolder($subSubFolder);
        
        $this->assertEquals(
            'my-folder/my sub-folder/my Sub sub-folder/',
            $subSubFolder->getFullPath()
        );
    }
    
    public function testFolderScan(){
        $folder = ScanPath::scan(__DIR__ . DIRECTORY_SEPARATOR.'folder');
        $this->assertEquals(
            'folder/',
            $folder->getFullPath()
        );
    
        $this->assertEquals(
            2,
            $folder->getFolders()->count()
        );
        
        /** @var File $firstFile */
        $firstFile = $folder->getFiles()->first();
        $this->assertEquals(
            'test.txt',
            $firstFile->getName()
        );
        
        /** @var Folder $firstFolder */
        $firstFolder = $folder->getFolders()->first();
        $this->assertEquals(
            'folder/a folder/',
            $firstFolder->getFullPath()
        );
        
        /** @var Folder $subFolder */
        $subFolder = $firstFolder->getFolders()->first();
        $this->assertEquals(
            'folder/a folder/sub folder/',
            $subFolder->getFullPath()
        );
        $this->assertEquals(
            2,
            $subFolder->getFiles()->count()
        );
    }
}