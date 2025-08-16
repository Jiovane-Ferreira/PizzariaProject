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
} else {

}

?>