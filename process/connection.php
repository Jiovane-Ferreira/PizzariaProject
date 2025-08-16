<?php

session_start();

$user = 'root'  ;
$password = 'logospc1';
$dbname = 'pizzaria';
$host = 'localhost';

try {

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

