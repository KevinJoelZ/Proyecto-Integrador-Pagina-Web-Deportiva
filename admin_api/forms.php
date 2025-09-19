<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../conexion.php';

$input = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $_GET['action'] ?? $input['action'] ?? 'list';

function table_exists($conexion, $table) {
    $stmt = $conexion->prepare("SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ? LIMIT 1");
    $stmt->bind_param('s', $table);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res && $res->num_rows > 0;
}

try {
    if ($action === 'list_tables') {
        // List simple of tables that likely store form info
        $likely = ['solicitudes', 'solicitudes_info', 'contactos', 'contacto', 'formularios', 'planes_solicitados'];
        $found = [];
        foreach ($likely as $t) {
            if (table_exists($conexion, $t)) { $found[] = $t; }
        }
        echo json_encode(['success' => true, 'tables' => $found]);
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
