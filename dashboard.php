<?php
    // index.php
    // This file is the main entry point for the application.
    // It includes the header template and can be extended with more functionality.
    include_once('templates/header.php');
?>

<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Gerenciar Pedidos</h2>
                <p>Bem-vindo ao painel de controle. Aqui você pode gerenciar seus pedidos.</p>
            </div>
            <div class="col-md-12 table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><span>Id do Pedido</span> #</th>
                            <th scope="col"><span>Borda</span> #</th>
                            <th scope="col"><span>Massa</span> #</th>
                            <th scope="col"><span>Sabores</span> #</th>
                            <th scope="col"><span>Status</span> #</th>
                            <th scope="col"><span>Ações</span> #</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1</td>
                            <td>Cheddar</td>
                            <td>Catupiry</td>
                            <td>4 Quejos</td>
                            
                            <td>
                                <form action="process/order.php" method="post" class="form-group update-form">
                                    <input type="hidden" name="type" value="update">
                                    <input type="hidden" name="order_id" value="1">
                                    <select name="status" class="form-control status-input">
                                        <option value="pending">Pendente</option>
                                        <option value="preparing">Preparando</option>
                                        <option value="delivered">Entregue</option>
                                    </select>
                                    <button type="submit" class="update-btn">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>    
                            </td>

                            <td>
                                <form action="process/order.php" method="post">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="hidden" name="order_id" value="1">
                                    <button type="submit" class="delete-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
    // Include the footer template
    include_once('templates/footer.php');
?>