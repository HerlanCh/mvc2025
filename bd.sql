-- Crear base de datos
CREATE DATABASE IF NOT EXISTS tienda_balones CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE tienda_balones;

-- Tabla de usuarios (NUEVO)
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'vendedor') DEFAULT 'vendedor',
    activo TINYINT(1) DEFAULT 1,
    ultimo_acceso DATETIME NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de preferencias de usuario (NUEVO)
CREATE TABLE IF NOT EXISTS preferencias_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tema ENUM('light', 'dark') DEFAULT 'light',
    idioma VARCHAR(5) DEFAULT 'es',
    vista_catalogo ENUM('grid', 'list') DEFAULT 'grid',
    items_por_pagina INT DEFAULT 12,
    notificaciones TINYINT(1) DEFAULT 1,
    sonido TINYINT(1) DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de wishlist/favoritos (NUEVO)
CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    balon_id INT NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (balon_id) REFERENCES balon(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (usuario_id, balon_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de balones
CREATE TABLE IF NOT EXISTS balon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    deporte VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(500) NULL,
    destacado TINYINT(1) DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de clientes
CREATE TABLE IF NOT EXISTS cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    apellido VARCHAR(150) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    telefono VARCHAR(20) NULL,
    direccion TEXT NULL,
    ciudad VARCHAR(100) NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de ventas
CREATE TABLE IF NOT EXISTS venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    estado VARCHAR(50) DEFAULT 'Completada',
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de detalle de ventas
CREATE TABLE IF NOT EXISTS detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    balon_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES venta(id) ON DELETE CASCADE,
    FOREIGN KEY (balon_id) REFERENCES balon(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuarios de ejemplo (password: admin123 para ambos)
INSERT INTO usuario (nombre, email, password, rol) VALUES
('Administrador', 'admin@ballstore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Vendedor Demo', 'vendedor@ballstore.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendedor');

-- Insertar datos de ejemplo en balones
INSERT INTO balon (nombre, marca, deporte, precio, stock, imagen, destacado) VALUES
('Balón de Fútbol Profesional Match Ball', 'Nike', 'Fútbol', 89.99, 15, 'https://images.unsplash.com/photo-1614632537197-38a17061c2bd?w=500', 1),
('Balón de Baloncesto Evolution', 'Spalding', 'Baloncesto', 65.99, 20, 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=500', 1),
('Balón de Voleibol Pro Touch', 'Mikasa', 'Voleibol', 45.99, 12, 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=500', 0),
('Balón de Fútbol Champions League', 'Adidas', 'Fútbol', 129.99, 8, 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=500', 1),
('Balón de Rugby Gilbert', 'Gilbert', 'Rugby', 75.50, 10, 'https://images.unsplash.com/photo-1609951651556-5334e2706168?w=500', 0),
('Balón de Baloncesto Indoor/Outdoor', 'Wilson', 'Baloncesto', 55.00, 25, 'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=500', 0),
('Balón de Fútbol Training', 'Puma', 'Fútbol', 35.99, 30, 'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?w=500', 0),
('Balón de Voleibol Beach', 'Wilson', 'Voleibol', 39.99, 18, 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?w=500', 0);

-- Insertar datos de ejemplo en clientes
INSERT INTO cliente (nombre, apellido, email, telefono, direccion, ciudad) VALUES
('Juan', 'Pérez', 'juan.perez@email.com', '71234567', 'Av. Principal #123', 'La Paz'),
('María', 'González', 'maria.gonzalez@email.com', '72345678', 'Calle Secundaria #456', 'La Paz'),
('Carlos', 'Rodríguez', 'carlos.rodriguez@email.com', '73456789', 'Zona Sur #789', 'La Paz'),
('Ana', 'Martínez', 'ana.martinez@email.com', '74567890', 'Av. 6 de Agosto #321', 'La Paz'),
('Luis', 'López', 'luis.lopez@email.com', '75678901', 'Calle Comercio #654', 'El Alto');

-- Insertar datos de ejemplo en ventas
INSERT INTO venta (cliente_id, total, estado, fecha_venta) VALUES
(1, 155.98, 'Completada', '2024-11-01 10:30:00'),
(2, 89.99, 'Completada', '2024-11-02 14:15:00'),
(3, 131.98, 'Completada', '2024-11-02 16:45:00'),
(1, 45.99, 'Completada', '2024-11-03 09:20:00');

-- Insertar detalles de ventas
INSERT INTO detalle_venta (venta_id, balon_id, cantidad, precio_unitario, subtotal) VALUES
(1, 1, 1, 89.99, 89.99),
(1, 2, 1, 65.99, 65.99),
(2, 1, 1, 89.99, 89.99),
(3, 2, 2, 65.99, 131.98),
(4, 3, 1, 45.99, 45.99);

-- Vistas útiles para reportes
CREATE OR REPLACE VIEW vista_ventas_completas AS
SELECT 
    v.id as venta_id,
    v.fecha_venta,
    v.total,
    v.estado,
    CONCAT(c.nombre, ' ', c.apellido) as cliente_nombre,
    c.email as cliente_email,
    c.telefono as cliente_telefono
FROM venta v
INNER JOIN cliente c ON v.cliente_id = c.id
ORDER BY v.fecha_venta DESC;

CREATE OR REPLACE VIEW vista_productos_vendidos AS
SELECT 
    b.nombre as producto,
    b.marca,
    b.deporte,
    SUM(dv.cantidad) as total_vendido,
    SUM(dv.subtotal) as total_ingresos
FROM detalle_venta dv
INNER JOIN balon b ON dv.balon_id = b.id
GROUP BY b.id
ORDER BY total_vendido DESC;