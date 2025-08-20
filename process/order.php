<?php
include_once 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    // 1. Buscar todos os status uma única vez
    $statusQuery = $conn->prepare("SELECT * FROM status");
    $statusQuery->execute();
    $statusData = $statusQuery->fetchAll(PDO::FETCH_ASSOC);

    // Criar array associativo id => nome
    $statusOptions = [];
    foreach ($statusData as $s) {
        $statusOptions[$s['id']] = $s['tipo'];
    }

    // 2. Buscar todos os pedidos
    $pedidosQuery = $conn->query("SELECT * FROM pedidos");
    $pedidos = $pedidosQuery->fetchAll(PDO::FETCH_ASSOC);

    $pizzas = [];

    foreach ($pedidos as $pedido) {

        $pizza = [];
        $pizza['id_pedido'] = $pedido['id'];
        $pizza['status'] = $pedido['id_status']; // id do status
        $pizza['status_nome'] = $statusOptions[$pedido['id_status']] ?? 'Status desconhecido'; // nome do status

        // 3. Buscar dados da pizza
        $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :id_pizza");
        $pizzaQuery->bindValue(':id_pizza', $pedido['id_pizza'], PDO::PARAM_INT);
        $pizzaQuery->execute();
        $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

        if (!$pizzaData) continue;

        // 4. Buscar a borda
        $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE id = :id_borda");
        $bordaQuery->bindValue(':id_borda', $pizzaData['id_borda'], PDO::PARAM_INT);
        $bordaQuery->execute();
        $bordaData = $bordaQuery->fetch(PDO::FETCH_ASSOC);
        $pizza['borda'] = $bordaData['tipo'] ?? 'Sem borda';

        // 5. Buscar a massa
        $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :id_massa");
        $massaQuery->bindValue(':id_massa', $pizzaData['id_massa'], PDO::PARAM_INT);
        $massaQuery->execute();
        $massaData = $massaQuery->fetch(PDO::FETCH_ASSOC);
        $pizza['massa'] = $massaData['tipo'] ?? 'Sem massa';

        // 6. Buscar os sabores da pizza (com JOIN, mais eficiente)
        $saboresQuery = $conn->prepare("
            SELECT s.nome
            FROM pizza_sabor ps
            JOIN sabores s ON s.id = ps.id_sabor
            WHERE ps.id_pizza = :id_pizza
        ");
        $saboresQuery->bindValue(':id_pizza', $pedido['id_pizza'], PDO::PARAM_INT);
        $saboresQuery->execute();
        $saboresList = $saboresQuery->fetchAll(PDO::FETCH_COLUMN); // já retorna array de nomes

        $pizza['sabores'] = $saboresList;

        // 7. Adicionar pizza completa ao array final
        $pizzas[] = $pizza;
    }

} elseif ($method === 'POST') {

    // Exemplo de atualização de status
    if (isset($_POST['type']) && $_POST['type'] === 'update') {
        $id_pedido = $_POST['id_pedido'] ?? null;
        $novo_status = $_POST['status'] ?? null;

        if ($id_pedido && $novo_status) {
            $updateQuery = $conn->prepare("UPDATE pedidos SET id_status = :status WHERE id = :id_pedido");
            $updateQuery->bindValue(':status', $novo_status, PDO::PARAM_INT);
            $updateQuery->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
            $updateQuery->execute();

            // Redireciona para a página de pedidos após atualizar
            header("Location: /dashboard.php");
            exit;
        }
    }
}
