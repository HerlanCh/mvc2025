<h1 class="page-title">
    <i class="bi bi-grid-fill"></i> <?php echo $controller->page_title; ?>
</h1>

<!-- Barra de Búsqueda -->
<div class="row mb-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control form-control-lg" 
                           id="searchInput" 
                           placeholder="Buscar productos por nombre, marca o deporte..."
                           autocomplete="off">
                    <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <!-- Historial de Búsqueda -->
                <div id="searchHistory" class="mt-2" style="display: none;">
                    <small class="text-muted d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-clock-history"></i> Búsquedas recientes:</span>
                        <button class="btn btn-sm btn-link text-danger" onclick="clearSearchHistory()">
                            Limpiar historial
                        </button>
                    </small>
                    <div id="historyList" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($_GET["response"]) && $_GET["response"] === true): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Éxito!</strong> Operación realizada correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Script de Búsqueda y Historial -->
<script>

// ========================================
// BÚSQUEDA EN TIEMPO REAL - CORREGIDO
// ========================================

let searchInitialized = false;
let allProducts = [];
let productsContainer = null;

function initializeSearch() {
    if (searchInitialized) return;
    
    productsContainer = document.querySelector('.row.g-4');
    if (!productsContainer) {
        console.warn('No se encontró el contenedor de productos');
        return;
    }
    
    allProducts = Array.from(productsContainer.children);
    searchInitialized = true;
    console.log('Búsqueda inicializada con', allProducts.length, 'productos');
}

// Búsqueda en tiempo real corregida
function performSearch(searchTerm) {
    if (!searchInitialized) initializeSearch();
    
    let visibleCount = 0;
    
    allProducts.forEach(product => {
        const productText = product.textContent.toLowerCase();
        const productName = product.querySelector('.card-title')?.textContent.toLowerCase() || '';
        
        if (searchTerm === '' || productText.includes(searchTerm) || productName.includes(searchTerm)) {
            product.style.display = 'block';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });
    
    // Mensaje si no hay resultados
    showNoResultsMessage(visibleCount === 0);
    
    return visibleCount;
}

function showNoResultsMessage(show) {
    const existingMsg = document.getElementById('noResultsMsg');
    
    if (show && !existingMsg) {
        const noResults = document.createElement('div');
        noResults.id = 'noResultsMsg';
        noResults.className = 'col-12 text-center py-5';
        noResults.innerHTML = `
            <i class="bi bi-search" style="font-size: 4rem; color: #cbd5e1;"></i>
            <h4 class="mt-3 text-muted">No se encontraron resultados</h4>
            <p class="text-muted">Intenta con otros términos de búsqueda</p>
            <button class="btn btn-primary mt-2" onclick="clearSearch()">
                <i class="bi bi-arrow-counterclockwise"></i> Mostrar todos
            </button>
        `;
        
        if (productsContainer) {
            productsContainer.appendChild(noResults);
        }
    } else if (!show && existingMsg) {
        existingMsg.remove();
    }
}

// Event Listeners corregidos
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    
    if (!searchInput) {
        console.error('No se encontró el input de búsqueda');
        return;
    }
    
    // Inicializar búsqueda después de un pequeño delay
    setTimeout(initializeSearch, 100);
    
    // Búsqueda en tiempo real con debounce
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = e.target.value.toLowerCase().trim();
            performSearch(searchTerm);
        }, 300);
    });
    
    // Guardar búsqueda al presionar Enter
    searchInput.addEventListener('keypress', function(e) {
        if(e.key === 'Enter') {
            const searchTerm = e.target.value.trim();
            if(searchTerm !== '') {
                saveSearchToHistory(searchTerm);
                if (typeof BallStore !== 'undefined') {
                    BallStore.notifications(`Buscando: "${searchTerm}"`, 'info');
                }
            }
        }
    });
    
    // Mostrar historial al hacer focus
    searchInput.addEventListener('focus', function() {
        displaySearchHistory();
    });
    
    // Cargar historial
    displaySearchHistory();
});

// ========================================
// HISTORIAL DE BÚSQUEDA (SessionStorage)
// ========================================

function saveSearchToHistory(query) {
    if(!query || query.trim() === '') return;
    
    let history = sessionStorage.getItem('ballstore_search_history');
    history = history ? JSON.parse(history) : [];
    
    // Evitar duplicados
    history = history.filter(item => item.toLowerCase() !== query.toLowerCase());
    
    // Agregar al inicio
    history.unshift(query);
    
    // Límite de 10 búsquedas
    if(history.length > 10) {
        history = history.slice(0, 10);
    }
    
    sessionStorage.setItem('ballstore_search_history', JSON.stringify(history));
    displaySearchHistory();
}

function displaySearchHistory() {
    const history = sessionStorage.getItem('ballstore_search_history');
    const historyContainer = document.getElementById('searchHistory');
    const historyList = document.getElementById('historyList');
    
    if(!historyContainer || !historyList) return;
    
    if(!history) {
        historyContainer.style.display = 'none';
        return;
    }
    
    const searches = JSON.parse(history);
    if(searches.length === 0) {
        historyContainer.style.display = 'none';
        return;
    }
    
    historyContainer.style.display = 'block';
    historyList.innerHTML = '';
    
    searches.forEach(search => {
        const badge = document.createElement('span');
        badge.className = 'badge bg-light text-dark border';
        badge.style.cursor = 'pointer';
        badge.innerHTML = `
            <i class="bi bi-clock-history me-1"></i> ${search}
        `;
        badge.onclick = () => {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.value = search;
                performSearch(search.toLowerCase());
                searchInput.focus();
            }
        };
        historyList.appendChild(badge);
    });
}

function clearSearchHistory() {
    sessionStorage.removeItem('ballstore_search_history');
    const historyContainer = document.getElementById('searchHistory');
    if (historyContainer) {
        historyContainer.style.display = 'none';
    }
    if (typeof BallStore !== 'undefined') {
        BallStore.notifications('Historial de búsqueda limpiado', 'success');
    }
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        performSearch('');
        searchInput.focus();
    }
    const historyContainer = document.getElementById('searchHistory');
    if (historyContainer) {
        historyContainer.style.display = 'none';
    }
}


</script>

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">
        <i class="bi bi-box"></i> Total de productos: 
        <strong><?php echo count($dataToView["data"]); ?></strong>
    </p>
    <div class="d-flex gap-2 align-items-center">
        <!-- Botones de Vista -->
        <div class="btn-group" role="group">
            <button type="button" 
                    class="btn btn-outline-primary" 
                    id="viewGridBtn"
                    onclick="changeView('grid')"
                    title="Vista en cuadrícula">
                <i class="bi bi-grid-3x3"></i>
            </button>
            <button type="button" 
                    class="btn btn-outline-primary" 
                    id="viewListBtn"
                    onclick="changeView('list')"
                    title="Vista en lista">
                <i class="bi bi-list-ul"></i>
            </button>
        </div>
        
        <a href="?controller=balon&action=create" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nuevo Balón
        </a>
    </div>
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
                    
                    <!-- Botón de Favoritos -->
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="?controller=wishlist&action=add&balon_id=<?php echo $balon["id"]; ?>&redirect=balon" 
                       class="btn btn-outline-danger position-absolute top-0 end- m-2"
                       style="z-index: 10;"
                       title="Agregar a favoritos">
                        <i class="bi bi-heart"></i>
                    </a>
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

                        <!-- Agregar al Carrito -->
                        <?php if($balon["stock"] > 0): ?>
                        <form action="?controller=carrito&action=agregar" method="POST" class="mb-2" onsubmit="return validarStock(this, <?php echo $balon['stock']; ?>, '<?php echo htmlspecialchars($balon['nombre'], ENT_QUOTES); ?>')">
                            <input type="hidden" name="balon_id" value="<?php echo $balon["id"]; ?>">
                            <div class="input-group input-group-sm mb-2">
                                <input type="number" 
                                       name="cantidad" 
                                       class="form-control" 
                                       value="1" 
                                       min="1" 
                                       max="<?php echo $balon["stock"]; ?>"
                                       required>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-cart-plus"></i> Agregar
                                </button>
                            </div>
                            <small class="text-muted d-block text-center">
                                <i class="bi bi-info-circle"></i> Stock: <?php echo $balon["stock"]; ?> disponibles
                            </small>
                        </form>
                        <?php else: ?>
                        <div class="alert alert-danger mb-2 py-2 text-center" role="alert">
                            <small><i class="bi bi-x-circle"></i> Sin stock</small>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                            <a href="?controller=balon&action=edit&id=<?php echo $balon["id"]; ?>" 
                               class="btn btn-sm btn-warning flex-fill">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a href="?controller=balon&action=confirmDelete&id=<?php echo $balon["id"]; ?>" 
                               class="btn btn-sm btn-danger flex-fill">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>