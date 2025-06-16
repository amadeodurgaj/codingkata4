<?php
    $host = '-'; 
    $port = 1;
    $dbname = '';
    $user = '';
    $password = '';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    ]);
    
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
