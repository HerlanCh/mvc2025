<h1 class="page-title">
    <i class="bi bi-cart3"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if (isset($_GET["response"]) && $_GET["response"] === "added"): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <strong>¡Producto agregado!</strong> Se ha añadido el producto al carrito.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (empty($dataToView["data"]["items"])): ?>
    <div class="text-center py-5">
        <i class="bi bi-cart-x" style="font-size: 5rem; color: #cbd5e1;"></i>
        <h3 class="mt-3 text-muted">Tu carrito está vacío</h3>
        <p class="text-muted">Explora nuestro catálogo y agrega productos</p>
        <a href="?controller=balon&action=list" class="btn btn-primary mt-3">
            <i class="bi bi-grid"></i> Ver Catálogo
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <!-- Lista de productos -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-bag-check"></i>
                        Productos en el Carrito (<?php echo $dataToView["data"]["cantidad_items"]; ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php foreach ($dataToView["data"]["items"] as $item): ?>
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-2">
                                <?php if (!empty($item["imagen"])): ?>
                                    <img src="<?php echo $item["imagen"]; ?>" class="img-fluid rounded"
                                        alt="<?php echo htmlspecialchars($item["nombre"]); ?>">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="height: 80px;">
                                        <i class="bi bi-dribbble" style="font-size: 2rem;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1"><?php echo htmlspecialchars($item["nombre"]); ?></h6>
                                <small class="text-muted"><?php echo $item["marca"]; ?></small>
                            </div>
                            <div class="col-md-2 text-center">
                                <strong class="text-success">
                                    <?php echo constant("CURRENCY"); ?>        <?php echo number_format($item["precio"], 2); ?>
                                </strong>
                            </div>
                            <div class="col-md-2">
                                <form action="?controller=carrito&action=actualizar" method="POST" class="d-flex">
                                    <input type="hidden" name="balon_id" value="<?php echo $item["id"]; ?>">
                                    <input type="number" name="cantidad" class="form-control form-control-sm"
                                        value="<?php echo $item["cantidad"]; ?>" min="1" onchange="this.form.submit()">
                                </form>
                            </div>
                            
                            <div class="col-md-2 text-end">
                                <div class="d-flex flex-column align-items-end">
                                    <strong class="text-primary mb-2">
                                        <?php echo constant("CURRENCY"); ?>        <?php echo number_format($item["subtotal"], 2); ?>
                                    </strong>
                                    <a href="?controller=carrito&action=eliminar&id=<?php echo $item["id"]; ?>"
                                        class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>

                            <?php if (isset($_GET["response"]) && $_GET["response"] === "stock_exceeded"): ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    La cantidad ingresada supera el stock disponible.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>

                    <div class="text-end mt-3">
                        <a href="?controller=carrito&action=vaciar" class="btn btn-outline-danger"
                            onclick="return confirm('¿Vaciar todo el carrito?')">
                            <i class="bi bi-trash"></i> Vaciar Carrito
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt"></i>
                        Resumen de Compra
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Productos:</span>
                        <strong><?php echo $dataToView["data"]["cantidad_items"]; ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <strong><?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["total"], 2); ?></strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total:</h5>
                        <h5 class="text-success">
                            <?php echo constant("CURRENCY"); ?>    <?php echo number_format($dataToView["data"]["total"], 2); ?>
                        </h5>
                    </div>

                    <a href="?controller=carrito&action=checkout" class="btn btn-success w-100 mb-2">
                        <i class="bi bi-credit-card"></i> Proceder al Pago
                    </a>

                    <a href="?controller=balon&action=list" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left"></i> Seguir Comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>