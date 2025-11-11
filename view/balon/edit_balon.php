<h1 class="page-title">
    <i class="bi bi-pencil-square"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(isset($_GET["response"]) && $_GET["response"] === true): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Guardado!</strong> El balón ha sido guardado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <form action="?controller=balon&action=save" method="POST" class="needs-validation" novalidate>
                    
                    <?php if(isset($dataToView["data"]["id"])): ?>
                        <input type="hidden" name="id" value="<?php echo $dataToView["data"]["id"]; ?>">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-dribbble"></i> Nombre del Balón *
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="nombre" 
                               name="nombre" 
                               value="<?php echo isset($dataToView["data"]["nombre"]) ? htmlspecialchars($dataToView["data"]["nombre"]) : ''; ?>"
                               placeholder="Ej: Balón de Fútbol Profesional"
                               required>
                        <div class="invalid-feedback">
                            Por favor ingresa el nombre del balón.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="marca" class="form-label">
                                <i class="bi bi-tag"></i> Marca *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="marca" 
                                   name="marca" 
                                   value="<?php echo isset($dataToView["data"]["marca"]) ? htmlspecialchars($dataToView["data"]["marca"]) : ''; ?>"
                                   placeholder="Ej: Nike, Adidas, Puma"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingresa la marca.
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="deporte" class="form-label">
                                <i class="bi bi-trophy"></i> Deporte *
                            </label>
                            <select class="form-select" id="deporte" name="deporte" required>
                                <option value="">Selecciona un deporte</option>
                                <option value="Fútbol" <?php echo (isset($dataToView["data"]["deporte"]) && $dataToView["data"]["deporte"] == "Fútbol") ? "selected" : ""; ?>>Fútbol</option>
                                <option value="Baloncesto" <?php echo (isset($dataToView["data"]["deporte"]) && $dataToView["data"]["deporte"] == "Baloncesto") ? "selected" : ""; ?>>Baloncesto</option>
                                <option value="Voleibol" <?php echo (isset($dataToView["data"]["deporte"]) && $dataToView["data"]["deporte"] == "Voleibol") ? "selected" : ""; ?>>Voleibol</option>
                                <option value="Béisbol" <?php echo (isset($dataToView["data"]["deporte"]) && $dataToView["data"]["deporte"] == "Béisbol") ? "selected" : ""; ?>>Béisbol</option>
                                <option value="Rugby" <?php echo (isset($dataToView["data"]["deporte"]) && $dataToView["data"]["deporte"] == "Rugby") ? "selected" : ""; ?>>Rugby</option>
                                <option value="Tenis" <?php echo (isset($dataToView["data"]["deporte"]) && $dataToView["data"]["deporte"] == "Tenis") ? "selected" : ""; ?>>Tenis</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor selecciona un deporte.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="precio" class="form-label">
                                <i class="bi bi-cash"></i> Precio (<?php echo constant("CURRENCY"); ?>) *
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   id="precio" 
                                   name="precio" 
                                   value="<?php echo isset($dataToView["data"]["precio"]) ? $dataToView["data"]["precio"] : ''; ?>"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingresa un precio válido.
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="stock" class="form-label">
                                <i class="bi bi-box-seam"></i> Stock (Unidades) *
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   id="stock" 
                                   name="stock" 
                                   value="<?php echo isset($dataToView["data"]["stock"]) ? $dataToView["data"]["stock"] : ''; ?>"
                                   min="0"
                                   placeholder="0"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingresa la cantidad en stock.
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="imagen" class="form-label">
                            <i class="bi bi-image"></i> URL de la Imagen
                        </label>
                        <input type="url" 
                               class="form-control" 
                               id="imagen" 
                               name="imagen" 
                               value="<?php echo isset($dataToView["data"]["imagen"]) ? htmlspecialchars($dataToView["data"]["imagen"]) : ''; ?>"
                               placeholder="https://ejemplo.com/imagen.jpg">
                        <small class="text-muted">Ingresa la URL de una imagen del balón (opcional)</small>
                    </div>

                    <?php if(isset($dataToView["data"]["imagen"]) && !empty($dataToView["data"]["imagen"])): ?>
                        <div class="mb-4">
                            <label class="form-label">Vista previa:</label>
                            <div class="text-center">
                                <img src="<?php echo $dataToView["data"]["imagen"]; ?>" 
                                     alt="Preview" 
                                     class="img-thumbnail" 
                                     style="max-height: 200px;">
                            </div>
                        </div>
                    <?php endif; ?>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-save"></i> Guardar Balón
                        </button>
                        <a href="?controller=balon&action=list" class="btn btn-secondary flex-fill">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-white">
                <i class="bi bi-info-circle"></i> Los campos marcados con * son obligatorios
            </small>
        </div>
    </div>
</div>

<script>
    // Bootstrap form validation
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

    // Image preview
    document.getElementById('imagen').addEventListener('change', function(e) {
        const url = e.target.value;
        if(url) {
            const preview = document.createElement('div');
            preview.className = 'mt-3 text-center';
            preview.innerHTML = `
                <label class="form-label">Vista previa:</label>
                <div><img src="${url}" alt="Preview" class="img-thumbnail" style="max-height: 200px;" onerror="this.parentElement.innerHTML='<p class=text-danger>URL de imagen inválida</p>'"></div>
            `;
            
            const existingPreview = document.querySelector('.img-thumbnail');
            if(existingPreview) {
                existingPreview.closest('.mb-4').remove();
            }
            
            e.target.closest('.mb-4').after(preview);
        }
    });
</script>