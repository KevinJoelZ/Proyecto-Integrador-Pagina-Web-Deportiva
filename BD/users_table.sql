-- Script para crear la tabla de usuarios para autenticación con Google
-- Ejecutar en XAMPP/MySQL: mysql -u root -p"" guardarbd < BD/users_table.sql

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `role` enum('client','admin') NOT NULL DEFAULT 'client',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar un admin de ejemplo (cambiar email por real)
-- INSERT INTO `users` (`name`, `email`, `role`) VALUES ('Admin Ejemplo', 'admin@deportefit.com', 'admin');