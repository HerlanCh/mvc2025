<h1 class="page-title">
    <i class="bi bi-gear-fill"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(isset($_GET["response"])): ?>
    <?php if($_GET["response"] === "success"): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Guardado!</strong> Tus preferencias han sido actualizadas correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "reset"): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <i class="bi bi-arrow-clockwise"></i> 
        Preferencias restablecidas a valores por defecto.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif($_GET["response"] === "error"): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill"></i> 
        Hubo un error al guardar las preferencias. Inténtalo nuevamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-sliders"></i> Configuración del Sistema
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="?controller=preferences&action=save" method="POST">
                    
                    <!-- Tema -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-palette"></i> Tema de la Interfaz
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card <?php echo ($dataToView['data']['tema'] === 'light') ? 'border-primary' : ''; ?>">
                                    <div class="card-body text-center">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="tema" 
                                               id="tema_light" 
                                               value="light"
                                               <?php echo ($dataToView['data']['tema'] === 'light') ? 'checked' : ''; ?>>
                                        <label class="w-100" for="tema_light">
                                            <i class="bi bi-sun" style="font-size: 2rem; color: #f59e0b;"></i>
                                            <h6 class="mt-2 mb-0">Claro</h6>
                                            <small class="text-muted">Fondo blanco</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card <?php echo ($dataToView['data']['tema'] === 'dark') ? 'border-primary' : ''; ?>">
                                    <div class="card-body text-center">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="tema" 
                                               id="tema_dark" 
                                               value="dark"
                                               <?php echo ($dataToView['data']['tema'] === 'dark') ? 'checked' : ''; ?>>
                                        <label class="w-100" for="tema_dark">
                                            <i class="bi bi-moon-stars" style="font-size: 2rem; color: #6366f1;"></i>
                                            <h6 class="mt-2 mb-0">Oscuro</h6>
                                            <small class="text-muted">Fondo negro</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> El tema se aplicará en tu próxima sesión
                        </small>
                    </div>

                    <hr>

                    <!-- Vista de Catálogo -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-grid-3x3"></i> Vista del Catálogo
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card <?php echo ($dataToView['data']['vista_catalogo'] === 'grid') ? 'border-primary' : ''; ?>">
                                    <div class="card-body text-center">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="vista_catalogo" 
                                               id="vista_grid" 
                                               value="grid"
                                               <?php echo ($dataToView['data']['vista_catalogo'] === 'grid') ? 'checked' : ''; ?>>
                                        <label class="w-100" for="vista_grid">
                                            <i class="bi bi-grid-3x3-gap" style="font-size: 2rem; color: #8b5cf6;"></i>
                                            <h6 class="mt-2 mb-0">Cuadrícula</h6>
                                            <small class="text-muted">Vista en tarjetas</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card <?php echo ($dataToView['data']['vista_catalogo'] === 'list') ? 'border-primary' : ''; ?>">
                                    <div class="card-body text-center">
                                        <input type="radio" 
                                               class="btn-check" 
                                               name="vista_catalogo" 
                                               id="vista_list" 
                                               value="list"
                                               <?php echo ($dataToView['data']['vista_catalogo'] === 'list') ? 'checked' : ''; ?>>
                                        <label class="w-100" for="vista_list">
                                            <i class="bi bi-list-ul" style="font-size: 2rem; color: #06b6d4;"></i>
                                            <h6 class="mt-2 mb-0">Lista</h6>
                                            <small class="text-muted">Vista detallada</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Idioma -->
                    <div class="mb-4">
                        <label for="idioma" class="form-label fw-bold">
                            <i class="bi bi-translate"></i> Idioma
                        </label>
                        <select class="form-select" id="idioma" name="idioma">
                            <option value="es" <?php echo ($dataToView['data']['idioma'] === 'es') ? 'selected' : ''; ?>>
                                🇪🇸 Español
                            </option>
                            <option value="en" <?php echo ($dataToView['data']['idioma'] === 'en') ? 'selected' : ''; ?>>
                                🇺🇸 English
                            </option>
                            <option value="pt" <?php echo ($dataToView['data']['idioma'] === 'pt') ? 'selected' : ''; ?>>
                                🇧🇷 Português
                            </option>
                        </select>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> Próximamente disponible
                        </small>
                    </div>

                    <hr>

                    <!-- Items por página -->
                    <div class="mb-4">
                        <label for="items_por_pagina" class="form-label fw-bold">
                            <i class="bi bi-collection"></i> Productos por página
                        </label>
                        <select class="form-select" id="items_por_pagina" name="items_por_pagina">
                            <option value="6" <?php echo ($dataToView['data']['items_por_pagina'] == 6) ? 'selected' : ''; ?>>6 productos</option>
                            <option value="12" <?php echo ($dataToView['data']['items_por_pagina'] == 12) ? 'selected' : ''; ?>>12 productos</option>
                            <option value="24" <?php echo ($dataToView['data']['items_por_pagina'] == 24) ? 'selected' : ''; ?>>24 productos</option>
                            <option value="48" <?php echo ($dataToView['data']['items_por_pagina'] == 48) ? 'selected' : ''; ?>>48 productos</option>
                        </select>
                    </div>

                    <hr>

                    <!-- Notificaciones -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-bell"></i> Notificaciones
                        </label>
                        
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="notificaciones" 
                                   name="notificaciones"
                                   <?php echo ($dataToView['data']['notificaciones'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="notificaciones">
                                Mostrar notificaciones en pantalla
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="sonido" 
                                   name="sonido"
                                   <?php echo ($dataToView['data']['sonido'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="sonido">
                                Reproducir sonidos
                            </label>
                        </div>

                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> 
                            Las notificaciones te alertarán sobre acciones importantes
                        </small>
                    </div>

                    <hr>

                    <!-- Información del Usuario -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="bi bi-person-circle"></i> Información de tu cuenta
                        </h6>
                        <p class="mb-1"><strong>Usuario:</strong> <?php echo $_SESSION['user_name']; ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
                        <p class="mb-0"><strong>Rol:</strong> 
                            <span class="badge bg-<?php echo $_SESSION['user_role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo ucfirst($_SESSION['user_role']); ?>
                            </span>
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Guardar Preferencias
                        </button>
                        <a href="?controller=preferences&action=reset" 
                           class="btn btn-outline-secondary"
                           onclick="return confirm('¿Restablecer a valores por defecto?')">
                            <i class="bi bi-arrow-clockwise"></i> Restablecer Predeterminados
                        </a>
                        <a href="?controller=dashboard&action=index" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Volver al Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información de LocalStorage -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-database"></i> Almacenamiento Local
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Tus preferencias también se guardan en:</strong>
                </p>
                <ul>
                    <li>Base de datos (persistente)</li>
                    <li>LocalStorage del navegador (backup)</li>
                </ul>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-success" onclick="BallStore.backup.export()">
                        <i class="bi bi-download"></i> Exportar Datos
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="clearLocalData()">
                        <i class="bi bi-trash"></i> Limpiar Cache Local
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Guardar en LocalStorage al enviar
document.querySelector('form').addEventListener('submit', function(e) {
    const formData = new FormData(this);
    const preferences = {
        tema: formData.get('tema'),
        idioma: formData.get('idioma'),
        vista_catalogo: formData.get('vista_catalogo'),
        items_por_pagina: formData.get('items_por_pagina'),
        notificaciones: formData.get('notificaciones') ? 1 : 0,
        sonido: formData.get('sonido') ? 1 : 0
    };
    
    BallStore.storage.local.set('preferences', preferences);
    BallStore.notifications('Preferencias guardadas', 'success');
});

// Limpiar datos locales
function clearLocalData() {
    if(confirm('¿Eliminar todos los datos locales del navegador?\n\nEsto incluye:\n- Preferencias backup\n- Favoritos backup\n- Carrito backup\n- Historial de búsqueda\n\nLos datos en el servidor no se verán afectados.')) {
        BallStore.storage.local.clear();
        BallStore.storage.session.clear();
        BallStore.notifications('Datos locales eliminados', 'success');
        setTimeout(() => location.reload(), 1500);
    }
}

// Aplicar tema en tiempo real (preview)
document.querySelectorAll('input[name="tema"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if(this.value === 'dark') {
            document.body.style.filter = 'invert(1) hue-rotate(180deg)';
            BallStore.notifications('Vista previa del tema oscuro', 'info');
        } else {
            document.body.style.filter = 'none';
        }
    });
});
</script>