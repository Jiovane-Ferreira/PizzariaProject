<?php

include_once 'connection.php';
$method = $_SERVER['REQUEST_METHOD'];

//Resgate dos dados e montagem do pedido
if ($method === 'GET') {

    $bordasQuerry = $conn->query("SELECT * FROM bordas");
    $bordas = $bordasQuerry->fetchAll(PDO::FETCH_ASSOC);

    $massasQuerry = $conn->query("SELECT * FROM massas");
    $massas = $massasQuerry->fetchAll(PDO::FETCH_ASSOC);

    $saboresQuerry = $conn->query("SELECT * FROM sabores");
    $sabores = $saboresQuerry->fetchAll(PDO::FETCH_ASSOC); 

// criação do pedido
} else if ($method === 'POST') {

    $borda = $_POST['borda'] ?? null;
    $massa = $_POST['massa'] ?? null;
    $sabores = $_POST['sabor'] ?? [];

    if (empty($borda) || empty($massa) || empty($sabores)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    if (count($sabores) > 3) {

        $_SESSION['msg'] = "Você pode selecionar no máximo 3 sabores.";
        $_SESSION['status'] = "warning";

    } else {
        
        echo "Passou da validação";
        exit;

    }

     header('Location: ../index.php');

} 

?>