<h1 class="page-title">
    <i class="bi bi-check-circle-fill text-success"></i> ¡Venta Completada!
</h1>

<?php if(isset($dataToView["data"]["venta"])): ?>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    <h3 class="mt-3 mb-3">¡Compra Exitosa!</h3>
                    <p class="text-muted mb-4">
                        La venta se ha registrado correctamente en el sistema.
                    </p>

                    <div class="card mb-4">
                        <div class="card-body text-start">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-receipt"></i> 
                                Detalles de la Venta
                            </h5>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Número de Venta:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    #<?php echo $dataToView["data"]["venta"]["id"]; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Cliente:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <?php echo htmlspecialchars($dataToView["data"]["venta"]["cliente_nombre"]); ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <?php echo htmlspecialchars($dataToView["data"]["venta"]["email"]); ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Fecha:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <?php echo date('d/m/Y H:i', strtotime($dataToView["data"]["venta"]["fecha_venta"])); ?>
                                </div>
                            </div>

                            <hr>

                            <h6 class="mt-3 mb-3">Productos Vendidos:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th class="text-center">Cant.</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($dataToView["data"]["detalle"] as $item): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($item["nombre"]); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo $item["marca"]; ?></small>
                                            </td>
                                            <td class="text-center"><?php echo $item["cantidad"]; ?></td>
                                            <td class="text-end">
                                                <?php echo constant("CURRENCY"); ?><?php echo number_format($item["precio_unitario"], 2); ?>
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
                                            <th class="text-end">
                                                <h5 class="text-success mb-0">
                                                    <?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["venta"]["total"], 2); ?>
                                                </h5>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="?controller=dashboard&action=index" class="btn btn-primary btn-lg">
                            <i class="bi bi-speedometer2"></i> Ir al Dashboard
                        </a>
                        <a href="?controller=balon&action=list" class="btn btn-outline-primary">
                            <i class="bi bi-grid"></i> Ver Catálogo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle"></i> 
        No se encontraron los detalles de la venta.
    </div>
    <a href="?controller=dashboard&action=index" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Volver al Dashboard
    </a>
<?php endif; ?>