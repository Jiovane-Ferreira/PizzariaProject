<?php
// index.php
include_once('templates/header.php');
include_once('process/order.php'); // aqui já temos $pizzas e $statusOptions disponíveis
?>

<div class="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Gerenciar Pedidos</h2>
                <p>Bem-vindo ao painel de controle. Aqui você pode gerenciar seus pedidos.</p>
            </div>

            <div class="col-md-12 table-container">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Id do Pedido</th>
                            <th>Borda</th>
                            <th>Massa</th>
                            <th>Sabores</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pizzas)): ?>
                            <?php foreach ($pizzas as $pizza): ?>
                                <tr>
                                    <td><?= htmlspecialchars($pizza['id_pedido']); ?></td>
                                    <td><?= htmlspecialchars($pizza['borda']); ?></td>
                                    <td><?= htmlspecialchars($pizza['massa']); ?></td>
                                    <td>
                                        <ul>
                                            <?php foreach ($pizza['sabores'] as $sabor): ?>
                                                <li><?= htmlspecialchars($sabor); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <form action="process/order.php" method="post" class="form-inline">
                                            <input type="hidden" name="type" value="update">
                                            <input type="hidden" name="id_pedido" value="<?= $pizza['id_pedido']; ?>">
                                            <select name="status" class="form-control">
                                                <?php foreach ($statusOptions as $statusId => $statusName): ?>
                                                    <option value="<?= $statusId; ?>" <?= $pizza['status'] == $statusId ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($statusName); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="update-btn" title="Atualizar status">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?= $pizza['id_pedido']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <a href="delete.php?id=<?= $pizza['id_pedido']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Nenhum pedido encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once('templates/footer.php');
?>
