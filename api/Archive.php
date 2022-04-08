<?php

require __DIR__ . '/GoogleDrive.php';

class Archive
{
    private $currentArchive = '1401-01';
    private $googleDrive = null;
    private $fileInfo = null;
    private $lesson = null;
    private $grade = null;
    private $fileId = null;

    public function __construct($developerKey = '')
    {
    }

    public function setGoogleDrive ($developerKey) {
      $this->googleDrive = new GoogleDrive($developerKey);
      return $this;
    }

    public function setFileData ($lesson, $grade, $fileId) {
      $this->lesson = $lesson;
      $this->grade = $grade;
      $this->fileId = $fileId;
      return $this;
    }

    public function setFileInfoFromGoogleDrive () {
      $this->fileInfo = $this->googleDrive->getFileInfo($this->fileId);
      return $this;
    }

    public function downloadFileFromGoogleDrive () {
      $path = $this->getFileDirectionInArchive($this->lesson, $this->grade);
      $this->googleDrive->saveFile($this->fileId, $path, $this->fileInfo['name']);
      return $this;
    }

    public function getSavedFileInArchiveInfo () {
      $this->fileInfo['url'] = $this->getUrlOfFileInArchive($this->lesson, $this->grade, $this->fileInfo['name']);
      return $this->fileInfo;
    }

    public function getPathInArchive ($lesson, $grade, $customArchive = false) {
      return $this->getArchivePath($customArchive).'/'.$lesson.'/'.$grade;
    }

    public function getArchivesPath () {
      return '/archive';
    }

    public function getArchivePath ($customArchive = false) {
        $archive = $this->currentArchive;
        if ($customArchive !== false) {
            $archive = $customArchive;
        }
      return $this->getArchivesPath().'/'.$this->currentArchive;
    }

    public function getUrlOfFileInArchive ($lesson, $grade, $fileName) {
      return $this->getArchiveAppUrl().$this->getPathInArchive($lesson, $grade).'/'.$fileName;
    }

    public function getFolderUrlInArchive ($lesson, $grade) {
      return $this->getArchiveAppUrl().$this->getPathInArchive($lesson, $grade);
    }

    public function getFileDirectionInArchive ($lesson, $grade, $customArchive = false) {
      return $this->getArchiveAppDir().$this->getPathInArchive($lesson, $grade, $customArchive);
    }

    public function getArchiveAppDir () {
      return substr(__DIR__,0, strrpos(__DIR__,'/'));
    }

    public function getArchiveAppUrl () {
      return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]".substr($_SERVER['PHP_SELF'],0, strrpos($_SERVER['PHP_SELF'],'/api'));
    }

    public function getListOfFilesInArchiveDir ($lesson, $grade, $customArchive = false) {
        $dir = $this->getFileDirectionInArchive($lesson, $grade, $customArchive);
        if (!is_dir($dir)) {
            return [];
        }
        $dir = $this->getFileDirectionInArchive($lesson, $grade);
        $scandir = scandir($dir);
        $files = [];
        $folderUrl = $this->getFolderUrlInArchive($lesson, $grade);
        foreach ($scandir as $item) {
            if ($item !== '.' && $item !== '..') {
                $files []= [
                    'url'=> $folderUrl.'/'.$item,
                    'name'=> $item
                ];
            }
        }

        return $files;
    }

    public function getArchives () {
        $folders = [];
        $archiveDir = $this->getArchiveAppDir().$this->getArchivesPath();
        if (!is_dir($archiveDir)) {
            return $folders;
        }
        $scan = scandir($archiveDir);
        foreach($scan as $file) {
            if ($file !== '.' && $file !== '..' && is_dir($archiveDir.'/'.$file)) {
                $folders []= $file;
            }
        }
        return $folders;
    }

}
