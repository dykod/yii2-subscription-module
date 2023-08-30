<?php
namespace common\modules\SubscriptionModule\components;


class FileLock
{
    private $lockFilePath;
    private $fileHandle;

    public function __construct($lockFilePath)
    {
        $this->lockFilePath = $lockFilePath;
    }

    public function lock()
    {
        $this->fileHandle = fopen($this->lockFilePath, 'w');
        if ($this->fileHandle === false) {
            return false;
        }

        return flock($this->fileHandle, LOCK_EX | LOCK_NB);
    }

    public function unlock()
    {
        if ($this->fileHandle) {
            flock($this->fileHandle, LOCK_UN);
            fclose($this->fileHandle);
            unlink($this->lockFilePath);
        }
    }
}



