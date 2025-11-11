<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - <?php echo constant("SITE_NAME"); ?></title>
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
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right {
            padding: 60px 40px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card row g-0">
            <div class="col-md-5 login-left">
                <div class="text-center mb-4">
                    <i class="bi bi-dribbble" style="font-size: 5rem;"></i>
                </div>
                <h2 class="text-center mb-3"><?php echo constant("SITE_NAME"); ?></h2>
                <p class="text-center"><?php echo constant("SITE_SLOGAN"); ?></p>
                <div class="mt-5">
                    <p class="small"><i class="bi bi-check-circle"></i> Gestión de inventario</p>
                    <p class="small"><i class="bi bi-check-circle"></i> Ventas en tiempo real</p>
                    <p class="small"><i class="bi bi-check-circle"></i> Reportes detallados</p>
                </div>
            </div>
            
            <div class="col-md-7 login-right">
                <h3 class="mb-4">Iniciar Sesión</h3>
                
                <?php if(isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i>
                    <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['register_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i>
                    Registro exitoso. Ya puedes iniciar sesión.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['register_success']); endif; ?>
                
                <form action="?controller=auth&action=processLogin" method="POST" id="loginForm">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" 
                               name="email" 
                               class="form-control form-control-lg" 
                               placeholder="correo@ejemplo.com"
                               required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-lock"></i> Contraseña
                        </label>
                        <input type="password" 
                               name="password" 
                               class="form-control form-control-lg" 
                               placeholder="••••••••"
                               required>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Recordarme por 30 días
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-login btn-primary w-100 btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
                </form>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <p class="mb-0">¿No tienes cuenta? 
                        <a href="?controller=auth&action=register" class="text-decoration-none fw-bold">
                            Regístrate aquí
                        </a>
                    </p>
                </div>
                
                <div class="mt-4 alert alert-info">
                    <strong>Demo:</strong><br>
                    Admin: admin@ballstore.com / admin123<br>
                    Vendedor: vendedor@ballstore.com / admin123
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Guardar email en localStorage
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = this.querySelector('[name="email"]').value;
            localStorage.setItem('last_email', email);
        });
        
        // Cargar último email usado
        window.addEventListener('load', function() {
            const lastEmail = localStorage.getItem('last_email');
            if(lastEmail) {
                document.querySelector('[name="email"]').value = lastEmail;
            }
        });
    </script>
</body>
</html>