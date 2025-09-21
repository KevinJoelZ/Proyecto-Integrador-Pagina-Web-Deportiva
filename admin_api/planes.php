<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

session_start();

// Incluir conexión a la base de datos (usar el mismo archivo que el resto del proyecto)
$conexionIncluded = false;
try {
    if (file_exists(__DIR__ . '/../conexión.php')) { // con tilde
        require_once __DIR__ . '/../conexión.php';
        $conexionIncluded = true;
    } elseif (file_exists(__DIR__ . '/../conexion.php')) {
        require_once __DIR__ . '/../conexion.php';
        $conexionIncluded = true;
    }
} catch (Throwable $e) {
    // ignorar, se manejará abajo
}

if (!$conexionIncluded || !isset($conexion)) {
    echo json_encode(['success' => false, 'message' => 'Conexión no disponible']);
    exit;
}

// Leer cuerpo JSON
$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
$action = $payload['action'] ?? ($_GET['action'] ?? '');

if ($action === 'save_choice') {
    $plan = trim((string)($payload['plan'] ?? ''));
    $price = trim((string)($payload['price'] ?? ''));
    $user_email = isset($_SESSION['user_email']) ? (string)$_SESSION['user_email'] : null;
    if (!$user_email) {
        $user_email = isset($payload['email']) ? trim((string)$payload['email']) : null;
    }

    if ($plan === '') {
        echo json_encode(['success' => false, 'message' => 'Plan requerido']);
        exit;
    }
    if (!$user_email) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado. Inicia sesión para continuar.']);
        exit;
    }

    // Crear tabla si no existe (no destructivo)
    $createSql = "CREATE TABLE IF NOT EXISTS planes_seleccionados (
        id INT AUTO_INCREMENT PRIMARY KEY,
        plan VARCHAR(100) NOT NULL,
        price VARCHAR(50) NULL,
        user_email VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    @$conexion->query($createSql);

    // Insertar selección (forzar created_at en hora local -05:00)
    $stmt = $conexion->prepare("INSERT INTO planes_seleccionados (plan, price, user_email, created_at) VALUES (?, ?, ?, CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', '-05:00'))");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error de preparación: ' . $conexion->error]);
        exit;
    }
    $stmt->bind_param('sss', $plan, $price, $user_email);
    $ok = $stmt->execute();
    $err = $stmt->error;
    $stmt->close();

    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo guardar: ' . $err]);
    }
    exit;
}

// Acción no válida
echo json_encode(['success' => false, 'message' => 'Acción no válida']);
