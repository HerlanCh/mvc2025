<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - <?php echo constant("SITE_NAME"); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px;
            max-width: 600px;
            width: 100%;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="text-center mb-4">
                <i class="bi bi-dribbble text-primary" style="font-size: 4rem;"></i>
                <h2 class="mt-3">Crear Cuenta</h2>
                <p class="text-muted">Únete a <?php echo constant("SITE_NAME"); ?></p>
            </div>
            
            <?php if(isset($_SESSION['register_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle"></i>
                <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
            
            <form action="?controller=auth&action=processRegister" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-person"></i> Nombre Completo *
                    </label>
                    <input type="text" 
                           name="nombre" 
                           class="form-control" 
                           placeholder="Juan Pérez"
                           required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-envelope"></i> Email *
                    </label>
                    <input type="email" 
                           name="email" 
                           class="form-control" 
                           placeholder="correo@ejemplo.com"
                           required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-lock"></i> Contraseña *
                    </label>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           id="password"
                           placeholder="Mínimo 6 caracteres"
                           minlength="6"
                           required>
                    <div class="form-text">Mínimo 6 caracteres</div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-lock-fill"></i> Confirmar Contraseña *
                    </label>
                    <input type="password" 
                           name="password_confirm" 
                           class="form-control" 
                           id="password_confirm"
                           placeholder="Repite tu contraseña"
                           required>
                </div>
                
                <button type="submit" class="btn btn-register btn-primary w-100 btn-lg">
                    <i class="bi bi-person-plus"></i> Registrarse
                </button>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center">
                <p class="mb-0">¿Ya tienes cuenta? 
                    <a href="?controller=auth&action=login" class="text-decoration-none fw-bold">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validar contraseñas
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirm').value;
            
            if(password !== confirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
        });
        
        // Bootstrap validation
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
</body>
</html>