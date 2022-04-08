<?php

if (!isset($_GET['user']) || !isset($_GET['pass'])) {
    die('params not set');
}

$user = $_GET['user'];
$pass = $_GET['pass'];

$result = [
    'authenticated'=> false,
    'role'=> null,
];
$authenticated = false;
$role = null;

if ($user=== 'asadikia' && $pass === 'asd1354') {
    $result['role'] = 'admin';
    $result['authenticated'] = true;
}

die(json_encode($result));