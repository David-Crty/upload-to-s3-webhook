<?php


namespace App\Model;


class File
{
    protected string $name;
    protected int $size;
    protected string $mineType;
    protected ?Folder $folder;
    
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
            $path .= $this->getFolder()->getPath();
        }
        
        return $path.$this->getName();
    }
}