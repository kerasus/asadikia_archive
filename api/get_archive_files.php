<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/Archive.php';

if (!isset($_GET['lesson']) || !isset($_GET['grade']) || !isset($_GET['archive'])) {
    die('params not set');
}

$archive = $_GET['archive'];
$lesson = $_GET['lesson'];
$grade = $_GET['grade'];

$archive = new Archive();
$fileInfo = $archive->getListOfFilesInArchiveDir($lesson, $grade, $archive);

die(json_encode($fileInfo));