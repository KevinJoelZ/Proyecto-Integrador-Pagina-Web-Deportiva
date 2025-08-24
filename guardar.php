<?php
// Incluir archivo de conexión
include 'conexión.php';

// Verificar que la conexión esté activa
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos");
}

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje)) {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingrese un email válido.'); window.history.back();</script>";
        exit;
    }

    // Consulta SQL optimizada
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, fecha_creacion) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Verificar que realmente se insertó
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu mensaje ha sido guardado correctamente en la base de datos. Te contactaremos pronto.');
                    window.location.href = 'servicios.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo insertar el registro en la base de datos.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al ejecutar la consulta: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        // Cerrar el statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
    
    // Cerrar la conexión
    mysqli_close($conexion);
    
} else {
    // Si no es POST, redirigir a la página de servicios
    header("Location: servicios.html");
    exit;
}
?>
