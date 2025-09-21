<?php
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Cargar conexión soportando ambos nombres de archivo
if (file_exists(__DIR__ . '/../conexión.php')) {
    ob_start(); require_once __DIR__ . '/../conexión.php'; ob_end_clean();
} else {
    ob_start(); require_once __DIR__ . '/../conexion.php'; ob_end_clean();
}

$input = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $_GET['action'] ?? $input['action'] ?? 'list';

function table_exists($conexion, $table) {
    // Sanitizar nombre de tabla (ya viene filtrado, reforzamos)
    $t = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    if ($t === '') return false;
    // MariaDB no soporta placeholders en SHOW TABLES LIKE, usar concatenación segura
    $like = $conexion->real_escape_string($t);
    $res = $conexion->query("SHOW TABLES LIKE '" . $like . "'");
    return $res && $res->num_rows > 0;
}

try {
    if ($action === 'list_tables') {
        // Listar tablas usando SHOW TABLES (compatible con hostings restringidos)
        $tables = [];
        $res = $conexion->query("SHOW TABLES");
        if ($res) {
            while ($row = $res->fetch_array(MYSQLI_NUM)) { $tables[] = $row[0]; }
        } else {
            // Fallback en algunos hostings
            $res2 = $conexion->query("SHOW FULL TABLES");
            if ($res2) {
                while ($row = $res2->fetch_array(MYSQLI_NUM)) { $tables[] = $row[0]; }
            } else {
                throw new Exception('No se pudo listar tablas');
            }
        }
        echo json_encode(['success' => true, 'tables' => $tables]);
    } elseif ($action === 'fetch_table') {
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', ($input['table'] ?? $_GET['table'] ?? ''));
        if ($table === '') throw new Exception('Tabla requerida');
        if (!table_exists($conexion, $table)) throw new Exception('La tabla no existe');
        $limit = intval($input['limit'] ?? $_GET['limit'] ?? 25);
        $limit = max(1, min(200, $limit));
        $q = "SELECT * FROM `{$table}` ORDER BY 1 DESC LIMIT {$limit}"; // orden por primera columna
        $res = $conexion->query($q);
        $rows = [];
        while ($row = $res->fetch_assoc()) { $rows[] = $row; }
        echo json_encode(['success' => true, 'items' => $rows]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Acción no soportada']);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

