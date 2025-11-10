<h1 class="page-title">
    <i class="bi bi-heart-fill text-danger"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(isset($_GET["response"])): ?>
    <?php if($_GET["response"] === "added"): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Agregado!</strong> El producto se agregó a tus favoritos.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "exists"): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <i class="bi bi-info-circle-fill"></i> 
        Este producto ya está en tus favoritos.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "removed"): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="bi bi-trash-fill"></i> 
        Producto eliminado de favoritos.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "cleared"): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <i class="bi bi-trash-fill"></i> 
        Todos los favoritos han sido eliminados.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "added_to_cart"): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-cart-check-fill"></i> 
        <strong>¡Agregado al carrito!</strong>
        <a href="?controller=carrito&action=index" class="alert-link">Ver carrito</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "no_stock"): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill"></i> 
        Este producto no tiene stock disponible.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php if(isset($_GET["wishlist_response"]) && $_GET["wishlist_response"] === "added"): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-heart-fill"></i> 
    <strong>¡Agregado a favoritos!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(empty($dataToView["data"])): ?>
    <div class="text-center py-5">
        <i class="bi bi-heart" style="font-size: 5rem; color: #cbd5e1;"></i>
        <h3 class="mt-3 text-muted">No tienes favoritos aún</h3>
        <p class="text-muted">Explora nuestro catálogo y marca tus productos favoritos</p>
        <a href="?controller=balon&action=list" class="btn btn-primary mt-3">
            <i class="bi bi-grid"></i> Ver Catálogo
        </a>
    </div>
<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">
            <i class="bi bi-heart-fill text-danger"></i> Tienes 
            <strong><?php echo count($dataToView["data"]); ?></strong> 
            <?php echo count($dataToView["data"]) === 1 ? 'favorito' : 'favoritos'; ?>
        </p>
        <a href="?controller=wishlist&action=clear" 
           class="btn btn-outline-danger btn-sm"
           onclick="return confirm('¿Eliminar todos los favoritos?')">
            <i class="bi bi-trash"></i> Limpiar Todo
        </a>
    </div>

    <div class="row g-4">
        <?php foreach($dataToView["data"] as $item): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="position-relative">
                    <?php if($item["stock"] > 0): ?>
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">
                            <i class="bi bi-check-circle"></i> Disponible
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            <i class="bi bi-x-circle"></i> Agotado
                        </span>
                    <?php endif; ?>
                    
                    

                    <div style="overflow: hidden; height: 250px;">
                        <?php if(!empty($item["imagen"])): ?>
                            <img src="<?php echo $item["imagen"]; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($item["nombre"]); ?>"
                                 style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center" 
                                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 250px;">
                                <i class="bi bi-dribbble text-white" style="font-size: 5rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-danger position-absolute top-0 end-0 m-2" 
                            onclick="removeFromWishlist(<?php echo $item['balon_id']; ?>)"
                            title="Eliminar de favoritos">
                        <i class="bi bi-heart-fill"></i>
                    </button>
                </div>

                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($item["nombre"]); ?></h5>
                    
                    <div class="mb-2">
                        <span class="badge bg-primary">
                            <i class="bi bi-tag-fill"></i> 
                            <?php echo htmlspecialchars($item["marca"]); ?>
                        </span>
                        <span class="badge bg-info text-dark">
                            <i class="bi bi-trophy-fill"></i> 
                            <?php echo htmlspecialchars($item["deporte"]); ?>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="price-tag">
                            <?php echo constant("CURRENCY"); ?><?php echo number_format($item["precio"], 2); ?>
                        </span>
                        <span class="badge bg-secondary">
                            <i class="bi bi-box-seam"></i> 
                            Stock: <?php echo $item["stock"]; ?>
                        </span>
                    </div>

                    <div class="d-flex gap-2">
                        <?php if($item["stock"] > 0): ?>
                        <a href="?controller=wishlist&action=addToCart&balon_id=<?php echo $item["balon_id"]; ?>" 
                           class="btn btn-success flex-fill">
                            <i class="bi bi-cart-plus"></i> Agregar al Carrito
                        </a>
                        <?php else: ?>
                        <button class="btn btn-secondary flex-fill" disabled>
                            <i class="bi bi-x-circle"></i> Sin Stock
                        </button>
                        <?php endif; ?>
                        
                        <a href="?controller=balon&action=edit&id=<?php echo $item["balon_id"]; ?>" 
                           class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <small>
                        <i class="bi bi-clock"></i> 
                        Agregado el <?php echo date('d/m/Y', strtotime($item["fecha_agregado"])); ?>
                    </small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
        <a href="?controller=balon&action=list" class="btn btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Agregar Más Favoritos
        </a>
    </div>
<?php endif; ?>

<script>
function removeFromWishlist(balonId) {
    if(confirm('¿Eliminar este producto de favoritos?')) {
        window.location.href = `?controller=wishlist&action=remove&balon_id=${balonId}`;
    }
}
</script>