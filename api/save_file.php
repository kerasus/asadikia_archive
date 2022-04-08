<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/Archive.php';

//GoogleDrive
$developerKey = 'AIzaSyDFCn0SKIgvaJkk6fEcVG40Wu6aKPvR2jQ';

$fileId = '16ij6rlx5DoD36oiRHB9UpP9RqNMAxQbA';

if (!isset($_GET['file_id']) || !isset($_GET['lesson']) || !isset($_GET['grade'])) {
  die('params not set');
}

$fileId = $_GET['file_id'];
$lesson = $_GET['lesson'];
$grade = $_GET['grade'];

$archive = new Archive();
$fileInfo = $archive->setGoogleDrive($developerKey)
  ->setFileData($lesson, $grade, $fileId)
  ->setFileInfoFromGoogleDrive()
  ->downloadFileFromGoogleDrive()
  ->getSavedFileInArchiveInfo();

die(json_encode($fileInfo));
