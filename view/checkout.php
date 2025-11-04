<h1 class="page-title">
    <i class="bi bi-credit-card"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(empty($dataToView["data"]["carrito"]["items"])): ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i> 
        El carrito está vacío. Agrega productos antes de continuar.
    </div>
    <a href="?controller=balon&action=list" class="btn btn-primary">
        <i class="bi bi-grid"></i> Ver Catálogo
    </a>
<?php else: ?>
    <div class="row g-4">
        <!-- Formulario de checkout -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-check"></i> 
                        Selecciona el Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <form action="?controller=carrito&action=procesar" method="POST" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="cliente_id" class="form-label">
                                <i class="bi bi-people"></i> Cliente *
                            </label>
                            <select class="form-select form-select-lg" id="cliente_id" name="cliente_id" required>
                                <option value="">Selecciona un cliente...</option>
                                <?php foreach($dataToView["data"]["clientes"] as $cliente): ?>
                                <option value="<?php echo $cliente["id"]; ?>">
                                    <?php echo htmlspecialchars($cliente["nombre"] . ' ' . $cliente["apellido"]); ?> 
                                    - <?php echo htmlspecialchars($cliente["email"]); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor selecciona un cliente.
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            ¿Cliente nuevo? 
                            <a href="?controller=cliente&action=create" target="_blank" class="alert-link">
                                Regístralo aquí
                            </a>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">Resumen de Productos</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">Precio Unit.</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($dataToView["data"]["carrito"]["items"] as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item["nombre"]); ?></td>
                                        <td class="text-center"><?php echo $item["cantidad"]; ?></td>
                                        <td class="text-end">
                                            <?php echo constant("CURRENCY"); ?><?php echo number_format($item["precio"], 2); ?>
                                        </td>
                                        <td class="text-end">
                                            <strong><?php echo constant("CURRENCY"); ?><?php echo number_format($item["subtotal"], 2); ?></strong>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end text-success">
                                            <?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["carrito"]["total"], 2); ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="bi bi-check-circle"></i> Confirmar Venta
                            </button>
                            <a href="?controller=carrito&action=index" class="btn btn-secondary flex-fill">
                                <i class="bi bi-arrow-left"></i> Volver al Carrito
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Resumen lateral -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt"></i> 
                        Total a Pagar
                    </h5>
                </div>
                <div class="card-body text-center">
                    <h2 class="text-success mb-0">
                        <?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["carrito"]["total"], 2); ?>
                    </h2>
                    <p class="text-muted mb-3">
                        <?php echo $dataToView["data"]["carrito"]["cantidad_items"]; ?> productos
                    </p>

                    <div class="text-start">
                        <h6 class="mb-2">Información de pago:</h6>
                        <ul class="list-unstyled small text-muted">
                            <li><i class="bi bi-check text-success"></i> Proceso seguro</li>
                            <li><i class="bi bi-check text-success"></i> Stock actualizado automáticamente</li>
                            <li><i class="bi bi-check text-success"></i> Registro de venta</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>