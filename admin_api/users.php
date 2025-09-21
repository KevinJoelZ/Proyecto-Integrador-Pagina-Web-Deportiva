<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Cargar conexión soportando ambos nombres de archivo
ob_start();
if (file_exists(__DIR__ . '/../conexión.php')) {
    require_once __DIR__ . '/../conexión.php';
} else {
    require_once __DIR__ . '/../conexion.php';
}
// Descartar cualquier salida accidental del archivo de conexión
ob_end_clean();

try {
    // Asegurar tabla usuarios
    $conexion->query("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        uid VARCHAR(255) UNIQUE,
        nombre VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        foto_perfil TEXT,
        email_verificado TINYINT(1) DEFAULT 0,
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ultima_conexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        estado ENUM('activo','inactivo') DEFAULT 'activo',
        rol ENUM('admin','cliente') DEFAULT 'cliente'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $q = "SELECT id, uid, nombre, email, rol, ultima_conexion FROM usuarios ORDER BY ultima_conexion DESC, id DESC LIMIT 200";
    $res = $conexion->query($q);
    if ($res === false) {
        throw new Exception('Error al consultar usuarios: ' . $conexion->error);
    }
    $items = [];
    while ($row = $res->fetch_assoc()) { $items[] = $row; }
    echo json_encode(['success' => true, 'items' => $items]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

