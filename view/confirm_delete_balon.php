<h1 class="page-title">
    <i class="bi bi-exclamation-triangle"></i> <?php echo $controller->page_title; ?>
</h1>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card border-danger">
            <div class="card-body p-4 text-center">
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                </div>

                <h3 class="mb-3">¿Estás seguro?</h3>
                <p class="text-muted mb-4">
                    Esta acción eliminará permanentemente el siguiente balón:
                </p>

                <?php if(isset($dataToView["data"]["id"])): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php if(!empty($dataToView["data"]["imagen"])): ?>
                                <img src="<?php echo $dataToView["data"]["imagen"]; ?>" 
                                     class="img-thumbnail mb-3" 
                                     alt="<?php echo htmlspecialchars($dataToView["data"]["nombre"]); ?>"
                                     style="max-height: 150px;">
                            <?php endif; ?>

                            <h5 class="card-title"><?php echo htmlspecialchars($dataToView["data"]["nombre"]); ?></h5>
                            
                            <div class="mb-2">
                                <span class="badge bg-primary">
                                    <i class="bi bi-tag-fill"></i> 
                                    <?php echo htmlspecialchars($dataToView["data"]["marca"]); ?>
                                </span>
                                <span class="badge bg-info text-dark">
                                    <i class="bi bi-trophy-fill"></i> 
                                    <?php echo htmlspecialchars($dataToView["data"]["deporte"]); ?>
                                </span>
                            </div>

                            <p class="price-tag mb-2">
                                <?php echo constant("CURRENCY"); ?><?php echo number_format($dataToView["data"]["precio"], 2); ?>
                            </p>

                            <span class="badge bg-secondary">
                                <i class="bi bi-box-seam"></i> 
                                Stock: <?php echo $dataToView["data"]["stock"]; ?>
                            </span>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle"></i> 
                        Esta acción no se puede deshacer.
                    </div>

                    <form action="?controller=balon&action=delete" method="POST" class="d-flex gap-2">
                        <input type="hidden" name="id" value="<?php echo $dataToView["data"]["id"]; ?>">
                        
                        <button type="submit" class="btn btn-danger flex-fill">
                            <i class="bi bi-trash"></i> Sí, eliminar
                        </button>
                        
                        <a href="?controller=balon&action=list" class="btn btn-secondary flex-fill">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i> 
                        No se encontró el balón especificado.
                    </div>
                    <a href="?controller=balon&action=list" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Volver al catálogo
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>