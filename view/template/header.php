<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $controller->page_title; ?> - <?php echo constant("SITE_NAME"); ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #10b981;
            --accent-color: #f59e0b;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --danger-color: #ef4444;
            
            /* Colores del tema */
            --bg-color: #ffffff;
            --text-color: #1e293b;
            --card-bg: #ffffff;
            --navbar-bg: rgba(255, 255, 255, 0.95);
            --input-bg: #ffffff;
            --input-border: #e2e8f0;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        /* TEMA OSCURO */
        body.dark-theme {
            --bg-color: #1e293b;
            --text-color: #f1f5f9;
            --card-bg: #334155;
            --navbar-bg: rgba(30, 41, 59, 0.95);
            --input-bg: #475569;
            --input-border: #64748b;
            --shadow-color: rgba(0, 0, 0, 0.5);
        }

        body.dark-theme {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            color: var(--text-color);
        }

        body.dark-theme .navbar {
            background: var(--navbar-bg) !important;
        }

        body.dark-theme .navbar-brand,
        body.dark-theme .nav-link,
        body.dark-theme .dropdown-item {
            color: var(--text-color) !important;
        }

        body.dark-theme .main-container {
            background: var(--card-bg);
            color: var(--text-color);
        }

        body.dark-theme .card {
            background: var(--card-bg);
            color: var(--text-color);
        }

        body.dark-theme .form-control,
        body.dark-theme .form-select {
            background: var(--input-bg);
            color: var(--text-color);
            border-color: var(--input-border);
        }

        body.dark-theme .table {
            color: var(--text-color);
        }

        body.dark-theme .table tbody tr:hover {
            background-color: #475569;
        }

        body.dark-theme .page-title,
        body.dark-theme h1, 
        body.dark-theme h2, 
        body.dark-theme h3,
        body.dark-theme h4,
        body.dark-theme h5,
        body.dark-theme h6 {
            color: var(--text-color);
        }

        body.dark-theme .text-muted {
            color: #94a3b8 !important;
        }

        body.dark-theme .dropdown-menu {
            background: var(--card-bg);
            border-color: var(--input-border);
        }

        body.dark-theme .modal-content {
            background: var(--card-bg);
            color: var(--text-color);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-bottom: 50px;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            font-size: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #1d4ed8);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--secondary-color), #059669);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-color), #d97706);
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        /* Container Styles */
        .main-container {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 0.6s ease;
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

        .page-title {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            bottom: -10px;
            left: 0;
            border-radius: 2px;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 20px;
        }

        /* Form Styles */
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        /* Alert Styles */
        .alert {
            border-radius: 10px;
            border: none;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Table Styles */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color), #1d4ed8);
            color: white;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9;
            transform: scale(1.01);
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Price Tag */
        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        /* Stock Badge */
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
                margin-top: 1rem;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Script para aplicar tema ANTES de que se cargue la página -->
    <script src="assets/js/storage-manager.js"></script>
    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/favorites-manager.js"></script>
    <script src="assets/js/cart-manager.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        (function() {
            // Obtener tema guardado
            const savedTheme = localStorage.getItem('ballstore_theme') || 'light';
            
            // Aplicar tema inmediatamente
            if(savedTheme === 'dark') {
                document.body.classList.add('dark-theme');
            }
        })();
    </script>

    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="?controller=balon&action=list">
                <i class="bi bi-dribbble"></i>
                <?php echo constant("SITE_NAME"); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=dashboard&action=index">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=balon&action=list">
                            <i class="bi bi-grid"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=cliente&action=list">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="?controller=carrito&action=index">
                            <i class="bi bi-cart3"></i> Carrito
                            <?php 
                            if(session_status() == PHP_SESSION_NONE) session_start();
                            $cart_count = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
                            if($cart_count > 0): 
                            ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                                <?php echo $cart_count; ?>
                            </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> 
                            <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario'; ?>
                            <?php if(isset($_SESSION['user_role'])): ?>
                            <span class="badge bg-<?php echo $_SESSION['user_role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo ucfirst($_SESSION['user_role']); ?>
                            </span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#" onclick="toggleTheme(); return false;">
                                    <i class="bi bi-moon-stars" id="themeIcon"></i> 
                                    <span id="themeText">Tema Oscuro</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="?controller=preferences&action=index">
                                    <i class="bi bi-gear"></i> Preferencias
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="?controller=wishlist&action=index">
                                    <i class="bi bi-heart"></i> Favoritos
                                    <?php
                                    if(isset($_SESSION['user_id'])){
                                        require_once 'model/wishlist.php';
                                        $wishlistObj = new Wishlist();
                                        $wishlist_count = $wishlistObj->countUserWishlist($_SESSION['user_id']);
                                        if($wishlist_count > 0){
                                            echo '<span class="badge bg-danger ms-2">' . $wishlist_count . '</span>';
                                        }
                                    }
                                    ?>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="?controller=auth&action=logout">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="main-container">

<script src="assets/js/storage-manager.js"></script>
    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/theme-manager.js"></script>
    <script src="assets/js/favorites-manager.js"></script>
    <script src="assets/js/cart-manager.js"></script>
    <script src="assets/js/app.js"></script>