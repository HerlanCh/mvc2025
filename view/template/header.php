<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $controller->page_title; ?> - Tienda de Balones</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            margin-top: 20px;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .ball-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .ball-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .ball-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .ball-card:hover .ball-image {
            transform: scale(1.1);
        }
        
        .price-tag {
            background: linear-gradient(45deg, var(--secondary-color), #c0392b);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            position: absolute;
            top: 15px;
            right: 15px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--accent-color), #2980b9);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, var(--secondary-color), #c0392b);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            border-radius: 0 0 30px 30px;
            margin-bottom: 30px;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: var(--primary-color);">
        <div class="container">
            <a class="navbar-brand pulse" href="?controller=ball&action=list">
                <i class="fas fa-basketball-ball me-2"></i>BallStore
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="?controller=ball&action=list">
                    <i class="fas fa-home me-1"></i>Inicio
                </a>
                <a class="nav-link" href="?controller=ball&action=edit">
                    <i class="fas fa-plus me-1"></i>Agregar Balón
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4 floating">¡Los Mejores Balones del Mercado!</h1>
            <p class="lead mb-4">Descubre nuestra amplia selección de balones para todos los deportes</p>
            <a href="?controller=ball&action=list" class="btn btn-light btn-lg">
                <i class="fas fa-shopping-cart me-2"></i>Ver Catálogo
            </a>
        </div>
    </div>

    <div class="container main-container">
        <div class="row">
            <div class="col-12">