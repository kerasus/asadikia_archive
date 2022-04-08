<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/Archive.php';

$archive = new Archive();
$fileInfo = $archive->getArchives();
die(json_encode($fileInfo));