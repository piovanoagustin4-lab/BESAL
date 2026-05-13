-- =====================================================
-- SALTO FOOD HUB - Esquema de base de datos
-- MySQL 5.7+ / 8.0+ - utf8mb4
-- =====================================================

DROP DATABASE IF EXISTS salto_food_hub;
CREATE DATABASE salto_food_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE salto_food_hub;

-- ============== USUARIOS ==============
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto_perfil VARCHAR(255) DEFAULT NULL,
    rol ENUM('usuario','emprendedor','admin') NOT NULL DEFAULT 'usuario',
    bio TEXT,
    baneado TINYINT(1) NOT NULL DEFAULT 0,
    email_verificado TINYINT(1) NOT NULL DEFAULT 0,
    token_recuperacion VARCHAR(100) DEFAULT NULL,
    token_expira DATETIME DEFAULT NULL,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============== CATEGORIAS ==============
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL UNIQUE,
    slug VARCHAR(80) NOT NULL UNIQUE,
    icono VARCHAR(60) DEFAULT 'bi-shop',
    color VARCHAR(20) DEFAULT '#ff8c42',
    orden INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- ============== EMPRENDIMIENTOS ==============
CREATE TABLE emprendimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    categoria_id INT DEFAULT NULL,
    nombre VARCHAR(120) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    descripcion TEXT,
    logo VARCHAR(255) DEFAULT NULL,
    portada VARCHAR(255) DEFAULT NULL,
    direccion VARCHAR(200),
    telefono VARCHAR(40),
    whatsapp VARCHAR(40),
    instagram VARCHAR(100),
    facebook VARCHAR(100),
    horarios VARCHAR(255),
    latitud DECIMAL(10,7) DEFAULT NULL,
    longitud DECIMAL(10,7) DEFAULT NULL,
    aprobado TINYINT(1) NOT NULL DEFAULT 0,
    destacado TINYINT(1) NOT NULL DEFAULT 0,
    visitas INT NOT NULL DEFAULT 0,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    INDEX idx_categoria (categoria_id),
    INDEX idx_aprobado (aprobado)
) ENGINE=InnoDB;

-- ============== IMAGENES (galería emprendimiento) ==============
CREATE TABLE imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emprendimiento_id INT NOT NULL,
    archivo VARCHAR(255) NOT NULL,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emprendimiento_id) REFERENCES emprendimientos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============== PUBLICACIONES (productos / posts) ==============
CREATE TABLE publicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emprendimiento_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) DEFAULT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emprendimiento_id) REFERENCES emprendimientos(id) ON DELETE CASCADE,
    INDEX idx_emp (emprendimiento_id)
) ENGINE=InnoDB;

-- ============== RESEÑAS ==============
CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emprendimiento_id INT NOT NULL,
    usuario_id INT NOT NULL,
    estrellas TINYINT NOT NULL CHECK (estrellas BETWEEN 1 AND 5),
    comentario TEXT,
    aprobada TINYINT(1) NOT NULL DEFAULT 1,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (emprendimiento_id) REFERENCES emprendimientos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_resena (emprendimiento_id, usuario_id)
) ENGINE=InnoDB;

-- ============== LIKES ==============
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    publicacion_id INT DEFAULT NULL,
    emprendimiento_id INT DEFAULT NULL,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (emprendimiento_id) REFERENCES emprendimientos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============== COMENTARIOS ==============
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    publicacion_id INT NOT NULL,
    usuario_id INT NOT NULL,
    contenido TEXT NOT NULL,
    aprobado TINYINT(1) NOT NULL DEFAULT 1,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============== FAVORITOS ==============
CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    emprendimiento_id INT NOT NULL,
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (emprendimiento_id) REFERENCES emprendimientos(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_fav (usuario_id, emprendimiento_id)
) ENGINE=InnoDB;

-- ============== REPORTES ==============
CREATE TABLE reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo ENUM('emprendimiento','publicacion','resena','comentario','usuario') NOT NULL,
    referencia_id INT NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('pendiente','revisado','descartado') NOT NULL DEFAULT 'pendiente',
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============== CONFIGURACIONES ==============
CREATE TABLE configuraciones (
    clave VARCHAR(80) PRIMARY KEY,
    valor TEXT
) ENGINE=InnoDB;

-- =====================================================
-- DATOS DEMO
-- =====================================================

-- Configuración inicial
INSERT INTO configuraciones (clave, valor) VALUES
('tema_activo', 'dark_orange'),
('site_name', 'SALTO FOOD HUB'),
('mantenimiento', '0');

-- Categorías
INSERT INTO categorias (nombre, slug, icono, color, orden) VALUES
('Hamburguesas','hamburguesas','bi-egg-fried','#ff8c42',1),
('Pizzerías','pizzerias','bi-circle','#e63946',2),
('Sushi','sushi','bi-droplet','#264653',3),
('Chivitos','chivitos','bi-bookmark-star','#d62828',4),
('Parrilladas','parrilladas','bi-fire','#9d0208',5),
('Pastas','pastas','bi-egg','#f4a261',6),
('Repostería','reposteria','bi-cake2','#ffb4a2',7),
('Cafeterías','cafeterias','bi-cup-hot','#6f4e37',8),
('Bebidas','bebidas','bi-cup-straw','#0096c7',9),
('Heladerías','heladerias','bi-snow','#90e0ef',10),
('Vegano','vegano','bi-flower1','#52b788',11),
('Comida rápida','comida-rapida','bi-bag','#fb8500',12);

-- Usuarios demo (password: "password123" para todos)
-- Hash generado con password_hash('password123', PASSWORD_BCRYPT)
INSERT INTO usuarios (nombre, username, email, password, rol, email_verificado) VALUES
('Administrador','admin','admin@saltofoodhub.uy','','admin',1),
('Juan Pérez','juanp','juan@example.com','','emprendedor',1),
('María García','mariag','maria@example.com','','emprendedor',1),
('Lucía Fernández','lucia','lucia@example.com','','usuario',1);

-- Emprendimientos demo
INSERT INTO emprendimientos (usuario_id, categoria_id, nombre, slug, descripcion, direccion, telefono, whatsapp, instagram, horarios, latitud, longitud, aprobado, destacado) VALUES
(2,1,'Burger Salto','burger-salto','Las mejores hamburguesas artesanales de Salto. Pan brioche y carne 100% local.','Uruguay 1234, Salto','47322000','59899111111','@burgersalto','Lun-Dom 18:00-00:00',-31.3848,-57.9676,1,1),
(3,8,'Café del Centro','cafe-del-centro','Café de especialidad, brunch y repostería casera en pleno centro.','Artigas 567, Salto','47322111','59899222222','@cafedelcentro','Lun-Sab 08:00-20:00',-31.3870,-57.9710,1,1),
(2,4,'Chivitería La Esquina','chiviteria-la-esquina','Chivitos al pan y al plato, receta tradicional uruguaya.','Brasil 890, Salto','47322333','59899333333','@laesquina','Mar-Dom 19:00-01:00',-31.3812,-57.9645,1,0);

-- Publicaciones demo
INSERT INTO publicaciones (emprendimiento_id, titulo, descripcion, precio) VALUES
(1,'Doble Cheddar','Doble medallón, cheddar fundido, panceta y salsa de la casa.',390.00),
(1,'Veggie Burger','Medallón de garbanzos, palta y pickles.',350.00),
(2,'Brunch del Día','Tostada de palta, huevo poché, café y jugo natural.',420.00),
(3,'Chivito Canadiense','Lomo, panceta, queso, huevo, lechuga, tomate y papas.',520.00);
