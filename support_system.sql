-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS support_system;
USE support_system;

-- Tabla de roles
CREATE TABLE roles (
    id TINYINT PRIMARY KEY,           -- 1, 2, 3...
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar roles iniciales
INSERT INTO roles (id, name) VALUES
(1, 'cliente'),
(2, 'agente'),
(3, 'administrador');

-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    status ENUM('activo','inactivo') DEFAULT 'activo',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de proyectos
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla intermedia: project_users (rol por proyecto)
CREATE TABLE project_users (
    user_id INT NOT NULL,
    project_id INT NOT NULL,
    role_id TINYINT NOT NULL,
    PRIMARY KEY (user_id, project_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
