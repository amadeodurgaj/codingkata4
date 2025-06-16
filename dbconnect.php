<?php
    $host = 'caboose.proxy.rlwy.net'; 
    $port = 30701;
    $dbname = 'railway';
    $user = 'postgres';
    $password = 'KHxoHQhdmkMMRlXoDVnmcNIgwEhWSgMu';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    ]);
    
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
