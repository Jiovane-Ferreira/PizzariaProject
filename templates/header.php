<?php

// Include the connection file to establish a database connection
include_once('process/connection.php'); 
// Include the pizza processing file to handle pizza-related operations
include_once('process/pizza.php');

$msg = "";

if (isset($_SESSION['msg'])) {
    
    $msg = $_SESSION['msg'];
    $status = $_SESSION['status'];

    unset($_SESSION['msg']);
    unset($_SESSION['status']);
}   


?>


<!DOCTYPE html>
<html lang="PT-BR">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> 

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">   
</head>


<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <a href="index.php" class="navbar-brand">
                <img src="img/pizza.svg" alt="Pizzaria Logo" id="brand-logo">
            </a>

            <div class="collapse navbar-collapse" id="nav-bar">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a href="index.php" class="nav-link">Peça sua pizza</a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <?php if ($msg != ""): ?>
        <div class="alert alert-<?= $status ?> alert-dismissible fade show" role="alert">
            <p><?= $msg ?></p>
        </div>
    <?php endif; ?>   