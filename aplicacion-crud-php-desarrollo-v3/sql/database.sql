-- ============================================
-- ELIMINAR BASE DE DATOS SI EXISTE
-- ============================================

DROP DATABASE IF EXISTS ps5crud;

-- ============================================
-- CREAR BASE DE DATOS
-- ============================================

CREATE DATABASE ps5crud;

USE ps5crud;

-- ============================================
-- TABLA 1: usuarios
-- ============================================

CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLA 2: videojuegos
-- (TABLA PRINCIPAL CRUD)
-- ============================================

CREATE TABLE videojuegos (
    videojuego_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) UNIQUE NOT NULL,
    genero VARCHAR(50) NOT NULL,
    precio DECIMAL(6,2) NOT NULL,
    plataforma VARCHAR(50) NOT NULL,
    lanzamiento YEAR NOT NULL,
    stock INT NOT NULL
);

-- ============================================
-- INSERTAR USUARIOS DE EJEMPLO
-- (contraseñas hasheadas con password_hash PHP)
-- ============================================

INSERT INTO usuarios (nombre_usuario, contrasena, correo)
VALUES
('admin', '$2y$10$R8HnzVloIQkoP7SLH/OVVe0TjL4bErd7Q56dQsCOQUwKEh0oh4xd2', 'admin@email.com'),
('usuario1', '$2y$10$lbhw/B.L9PRRigLNRKBiwet5u.ZUDipKOR0uu93POm7M5c/lGI05u', 'usuario1@email.com'),
('diego', '$2y$10$yTboNp1HuYGdwkUPdtL0E.TaormNAgXAU451OCktEBSxDMN04ALNe', 'diego@example.com'),
('tester', '$2y$10$IFebWxYuyCLqo6MICTrc2OLesAeMUVg10nyYaOIEKBuXnKrYHLFTm', 'tester@example.com'),
('player', '$2y$10$vA5iLKahEs1taFhWS3eMk.DX3OXbfCzZ.lgCBEuUqUQTWfx8EqAG2', 'player@example.com');

-- ============================================
-- INSERTAR 10 VIDEOJUEGOS
-- ============================================

INSERT INTO videojuegos (titulo, genero, precio, plataforma, lanzamiento, stock)
VALUES
('God of War Ragnarok', 'Accion', 69.99, 'PS5', 2022, 15),
('Spider-Man 2', 'Aventura', 79.99, 'PS5', 2023, 10),
('Horizon Forbidden West', 'RPG', 59.99, 'PS5', 2022, 8),
('Gran Turismo 7', 'Simulacion', 49.99, 'PS5', 2022, 20),
('The Last of Us Part I', 'Drama', 69.99, 'PS5', 2022, 12),
('Elden Ring', 'RPG', 59.99, 'PS5', 2022, 18),
('Final Fantasy XVI', 'RPG', 79.99, 'PS5', 2023, 9),
('Resident Evil 4 Remake', 'Terror', 59.99, 'PS5', 2023, 11),
('Assassins Creed Mirage', 'Accion', 49.99, 'PS5', 2023, 14),
('FIFA 24', 'Deportes', 69.99, 'PS5', 2023, 25);
