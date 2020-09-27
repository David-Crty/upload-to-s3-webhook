<?php


namespace App\Model;


use Cocur\Slugify\Slugify;

class File
{
    protected string $name;
    protected string $realPath;
    protected int $size;
    protected string $mineType;
    protected ?Folder $folder = null;
    protected string $s3Key;
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getRealPath(): string
    {
        return $this->realPath;
    }
    
    /**
     * @param string $realPath
     */
    public function setRealPath(string $realPath): void
    {
        $this->realPath = $realPath;
    }
    
    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }
    
    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
    
    /**
     * @return string
     */
    public function getMineType(): string
    {
        return $this->mineType;
    }
    
    /**
     * @param string $mineType
     */
    public function setMineType(string $mineType): void
    {
        $this->mineType = $mineType;
    }
    
    /**
     * @return ?Folder
     */
    public function getFolder(): ?Folder
    {
        return $this->folder;
    }
    
    /**
     * @param Folder $folder
     */
    public function setFolder(?Folder $folder): void
    {
        $this->folder = $folder;
    }
    
    public function getPath(){
        $path = '';
        if($this->getFolder()){
            $path .= $this->getFolder()->getFullPath();
        }
        
        return $path.$this->getName();
    }
    
    /**
     * @return string
     */
    public function getS3Key(): ?string
    {
        return $this->s3Key;
    }
    
    /**
     * @param string $s3Key
     */
    public function setS3Key(string $s3Key): void
    {
        $this->s3Key = $s3Key;
    }
    
    public function generateS3Key($mainFolder, $uid = null){
        $slugify = new Slugify();
        $start = trim(substr($slugify->slugify($mainFolder),0,20), '-');
        $end = trim(substr($slugify->slugify($this->getName()),0,20), '-');
        $uid = ($uid) ? $uid : uniqid();
        $this->setS3Key($start.'/'.$end.'_'.$uid);
        
        return $this->getS3Key();
    }
}