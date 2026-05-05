<?php
$host = 'trolley.proxy.rlwy.net';
$port = '22168';
$db   = 'railway';
$user = 'root';
$pass = 'SYwonwLBGeETVYPayHLzFpnwzibIlCUQ';

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
$sql = file_get_contents('database_dump.sql');
$pdo->exec($sql);
echo "Imported!";