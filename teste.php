<?php
$user = 'root';
$password = 'logospc1'; // ou 'logospc1'
$dbname = 'pizzaria';
$host = 'localhost';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    echo "✅ Conexão bem sucedida!";
} catch (PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage();
}