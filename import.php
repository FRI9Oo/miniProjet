<?php
$host = 'trolley.proxy.rlwy.net';
$port = '56341';
$db   = 'railway';
$user = 'root';
$pass = 'CWzgrUryoiVtdCdITUYNoGbiaHOfgFEH';

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
$sql = file_get_contents('database_dump.sql');
$pdo->exec($sql);
echo "Imported!";