<h1 class="page-title">
    <i class="bi bi-grid-fill"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(isset($_GET["response"]) && $_GET["response"] === true): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Éxito!</strong> Operación realizada correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">
        <i class="bi bi-box"></i> Total de productos: 
        <strong><?php echo count($dataToView["data"]); ?></strong>
    </p>
    <a href="?controller=balon&action=create" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nuevo Balón
    </a>
</div>

<?php if(empty($dataToView["data"])): ?>
    <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 5rem; color: #cbd5e1;"></i>
        <h3 class="mt-3 text-muted">No hay balones registrados</h3>
        <p class="text-muted">Comienza agregando tu primer producto</p>
        <a href="?controller=balon&action=create" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i> Agregar Primer Balón
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach($dataToView["data"] as $balon): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <?php if($balon["stock"] > 0): ?>
                        <span class="badge bg-success stock-badge">
                            <i class="bi bi-check-circle"></i> Disponible
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger stock-badge">
                            <i class="bi bi-x-circle"></i> Agotado
                        </span>
                    <?php endif; ?>

                    <div style="overflow: hidden; height: 250px;">
                        <?php if(!empty($balon["imagen"])): ?>
                            <img src="<?php echo $balon["imagen"]; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($balon["nombre"]); ?>">
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center" 
                                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-dribbble text-white" style="font-size: 5rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($balon["nombre"]); ?>
                        </h5>
                        
                        <div class="mb-2">
                            <span class="badge bg-primary">
                                <i class="bi bi-tag-fill"></i> 
                                <?php echo htmlspecialchars($balon["marca"]); ?>
                            </span>
                            <span class="badge bg-info text-dark">
                                <i class="bi bi-trophy-fill"></i> 
                                <?php echo htmlspecialchars($balon["deporte"]); ?>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-tag">
                                <?php echo constant("CURRENCY"); ?><?php echo number_format($balon["precio"], 2); ?>
                            </span>
                            <span class="badge bg-secondary">
                                <i class="bi bi-box-seam"></i> 
                                Stock: <?php echo $balon["stock"]; ?>
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="?controller=balon&action=edit&id=<?php echo $balon["id"]; ?>" 
                               class="btn btn-warning flex-fill">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a href="?controller=balon&action=confirmDelete&id=<?php echo $balon["id"]; ?>" 
                               class="btn btn-danger flex-fill">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>