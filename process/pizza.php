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

    $borda = $_POST['borda'];
    $massa = $_POST['massa'];
    $sabores = $_POST['sabor'];

    if (empty($borda) || empty($massa) || empty($sabores)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }

    if (count($sabores) > 3) {

        $_SESSION['msg'] = "Você pode selecionar no máximo 3 sabores.";
        $_SESSION['status'] = "warning";

        } else {
        
        try {
            // Inserção dos sabores no banco de dados
            $stmt = $conn->prepare("INSERT INTO pizzas(id_borda, id_massa) VALUES (:id_borda, :id_massa)");
         
            foreach ($sabores as $sabor) {
                $stmt->bindParam(':id_borda', $borda, PDO::PARAM_INT);
                $stmt->bindParam(':id_massa', $massa, PDO::PARAM_INT);
                $stmt->execute();
            }

            $pizzaId = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO pizza_sabor (id_pizza, id_sabor) VALUES (:id_pizza, :id_sabor)");
            foreach ($sabores as $sabor) {
                $stmt->bindParam(':id_pizza', $pizzaId, PDO::PARAM_INT);
                $stmt->bindParam(':id_sabor', $sabor, PDO::PARAM_INT);
                $stmt->execute();
            }  

             //criar o pedido da pizza
            $stmt = $conn->prepare("INSERT INTO pedidos(id_pizza, id_status) 
            VALUES (:pizza, :status)");
            $statusId = 1; // status 1 é o status de pedido realizado, "em produção."

            $stmt->bindParam(':pizza', $pizzaId, PDO::PARAM_INT);
            $stmt->bindParam(':status', $statusId, PDO::PARAM_INT);
            $stmt->execute();

            // Mensagem de sucesso
            echo "Pedido realizado com sucesso!";
            $_SESSION['msg'] = "Pedido realizado com sucesso!";
            $_SESSION['status'] = "success";
            header("Location: ../index.php");
            exit;

            } catch (PDOException $e) {
                echo "Erro ao inserir os sabores: " . $e->getMessage();
            exit;
       
        }

       


    } 



}

?>