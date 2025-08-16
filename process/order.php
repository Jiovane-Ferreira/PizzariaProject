<?php

include_once 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    $pedidosQuery = $conn->query("SELECT * FROM pedidos");
    $pedidos = $pedidosQuery->fetchAll(PDO::FETCH_ASSOC); // Melhor sempre usar FETCH_ASSOC

    $pizzas = [];
    
    //montando a pizza
    foreach ($pedidos as $pedido) {

        $pizza = [];
        $pizza['id'] = $pedido['id_pizza'];

        //resgatando a pizza
        $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :id_pizza");
        $pizzaQuery->bindParam(':id_pizza', $pizza['id'], PDO::PARAM_INT); 
        $pizzaQuery->execute();
        $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

        if (!$pizzaData) {
            continue; // se não achar a pizza, pula
        }

        //resgatando a borda
        $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :id_borda");
        $bordaQuery->bindParam(':id_borda', $pizzaData['id_borda'], PDO::PARAM_INT);
        $bordaQuery->execute();
        $bordaData = $bordaQuery->fetch(PDO::FETCH_ASSOC);
        $pizza['borda'] = $bordaData['tipo'] ?? 'Sem borda'; // aqui estava errado, era $bordaData

        //resgatando a massa
        $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :id_massa");
        $massaQuery->bindParam(':id_massa', $pizzaData['id_massa'], PDO::PARAM_INT);
        $massaQuery->execute();
        $massaData = $massaQuery->fetch(PDO::FETCH_ASSOC);
        $pizza['massa'] = $massaData['tipo'] ?? 'Sem massa';

        //resgatando os sabores
        $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE id_pizza = :id_pizza");
        $saboresQuery->bindParam(':id_pizza', $pizza['id'], PDO::PARAM_INT);
        $saboresQuery->execute();
        $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);

        //resgatando nome dos sabores
        $saboresList = [];
        $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :id_sabor"); // corrigido typo
        foreach ($sabores as $sabor) {
            $saborQuery->bindParam(':id_sabor', $sabor['id_sabor'], PDO::PARAM_INT);
            $saborQuery->execute();
            $saborData = $saborQuery->fetch(PDO::FETCH_ASSOC);
            if ($saborData) {
                $saboresList[] = $saborData['nome'];
            } else {
                $saboresList[] = 'Sabor desconhecido';
            }
        }

        $pizza['sabores'] = implode(', ', $saboresList);
        $pizza['status'] = $pedido['id_status'];
        $pizza['id_pedido'] = $pedido['id'];
        array_push($pizzas, $pizza);

        //resgatando os status
        $statusQuery = $conn->prepare("SELECT * FROM status");
        $statusQuery->execute();
        $status = $statusQuery->fetchAll(PDO::FETCH_ASSOC);
    }


} else if ($method === 'POST') {
    // implementar se precisar
}

?>
