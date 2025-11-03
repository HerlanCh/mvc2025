<div class="container-fluid">
    <?php if(isset($_GET["response"]) && $_GET["response"] === true) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>Operación realizada exitosamente!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-basketball-ball me-2"></i>Catálogo de Balones</h2>
        <a href="?controller=ball&action=edit" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuevo Balón
        </a>
    </div>

    <div class="row">
        <?php if(!empty($dataToView["data"])) { ?>
            <?php foreach($dataToView["data"] as $ball) { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card ball-card h-100">
                        <div class="position-relative">
                            <img src="<?php echo $ball['image'] ?: 'https://via.placeholder.com/300x200/667eea/white?text=Balón+Deportivo'; ?>" 
                                 class="card-img-top ball-image" 
                                 alt="<?php echo $ball['name']; ?>">
                            <div class="price-tag">$<?php echo number_format($ball['price'], 2); ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $ball['name']; ?></h5>
                            <p class="card-text text-muted"><?php echo substr($ball['description'], 0, 100); ?>...</p>
                            
                            <div class="mb-3">
                                <span class="badge bg-primary"><?php echo $ball['brand']; ?></span>
                                <span class="badge bg-secondary"><?php echo $ball['category']; ?></span>
                                <span class="badge bg-<?php echo $ball['stock'] > 0 ? 'success' : 'danger'; ?>">
                                    Stock: <?php echo $ball['stock']; ?>
                                </span>
                            </div>
                            
                            <div class="btn-group w-100">
                                <a href="?controller=ball&action=detail&id=<?php echo $ball['id']; ?>" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?controller=ball&action=edit&id=<?php echo $ball['id']; ?>" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?controller=ball&action=confirmDelete&id=<?php echo $ball['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-basketball-ball fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">No hay balones disponibles</h3>
                <p class="text-muted">Agrega el primer balón a tu catálogo</p>
                <a href="?controller=ball&action=edit" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Agregar Primer Balón
                </a>
            </div>
        <?php } ?>
    </div>
</div>