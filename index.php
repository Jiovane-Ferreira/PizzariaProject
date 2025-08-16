<?php
    // index.php
    // This file is the main entry point for the application.
    // It includes the header template and can be extended with more functionality.
    include_once('templates/header.php');

    // Include the pizza processing file to handle pizza-related operations
    include_once('process/pizza.php');
?>

<div id="main-banner">
    <h1>Faça seu pedido de pizza!</h1>
    <p>Escolha entre nossas deliciosas opções e faça seu pedido agora mesmo!</p>
</div>

<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Monte a Pizza como desejar</h2>
                <p>Selecione os ingredientes, tamanho e borda da sua pizza.</p>
                <form action="process/order.php" id="pizza_form" method="post">
                    
                <div class="form-group">
                        <label for="borda">Borda da Pizza:</label>
                        <select name="borda" id="borda" class="form-control">
                            <option value="">Selecione a Borda</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="massa">Massa da Pizza:</label>
                        <select name="massa" id="massa" class="form-control">
                            <option value="">Selecione a Massa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sabor">Sabores (máximo 3):</label>
                        <select multiple name="sabor[]" id="sabor" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Enviar Pedido" class="btn btn-primary">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>


<?php
    // Include the footer template
    include_once('templates/footer.php');
?>