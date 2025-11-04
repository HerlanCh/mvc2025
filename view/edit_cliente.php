<h1 class="page-title">
    <i class="bi bi-person-fill"></i> <?php echo $controller->page_title; ?>
</h1>

<?php if(isset($_GET["response"]) && $_GET["response"] === true): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> 
        <strong>¡Guardado!</strong> El cliente ha sido guardado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <form action="?controller=cliente&action=save" method="POST" class="needs-validation" novalidate>
                    
                    <?php if(isset($dataToView["data"]["id"])): ?>
                        <input type="hidden" name="id" value="<?php echo $dataToView["data"]["id"]; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="nombre" class="form-label">
                                <i class="bi bi-person"></i> Nombre *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?php echo isset($dataToView["data"]["nombre"]) ? htmlspecialchars($dataToView["data"]["nombre"]) : ''; ?>"
                                   placeholder="Juan"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingresa el nombre.
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="apellido" class="form-label">
                                <i class="bi bi-person"></i> Apellido *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="apellido" 
                                   name="apellido" 
                                   value="<?php echo isset($dataToView["data"]["apellido"]) ? htmlspecialchars($dataToView["data"]["apellido"]) : ''; ?>"
                                   placeholder="Pérez"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingresa el apellido.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email *
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo isset($dataToView["data"]["email"]) ? htmlspecialchars($dataToView["data"]["email"]) : ''; ?>"
                                   placeholder="correo@ejemplo.com"
                                   required>
                            <div class="invalid-feedback">
                                Por favor ingresa un email válido.
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="telefono" class="form-label">
                                <i class="bi bi-telephone"></i> Teléfono
                            </label>
                            <input type="tel" 
                                   class="form-control" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="<?php echo isset($dataToView["data"]["telefono"]) ? htmlspecialchars($dataToView["data"]["telefono"]) : ''; ?>"
                                   placeholder="71234567">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="direccion" class="form-label">
                            <i class="bi bi-house"></i> Dirección
                        </label>
                        <textarea class="form-control" 
                                  id="direccion" 
                                  name="direccion" 
                                  rows="2"
                                  placeholder="Av. Principal #123"><?php echo isset($dataToView["data"]["direccion"]) ? htmlspecialchars($dataToView["data"]["direccion"]) : ''; ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="ciudad" class="form-label">
                            <i class="bi bi-geo-alt"></i> Ciudad
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="ciudad" 
                               name="ciudad" 
                               value="<?php echo isset($dataToView["data"]["ciudad"]) ? htmlspecialchars($dataToView["data"]["ciudad"]) : ''; ?>"
                               placeholder="La Paz">
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-save"></i> Guardar Cliente
                        </button>
                        <a href="?controller=cliente&action=list" class="btn btn-secondary flex-fill">
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
</script>