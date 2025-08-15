<?php
include 'conexión.php';

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

    // Ajusta el nombre de la tabla y los campos según tu base de datos
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, fecha_creacion) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('¡Gracias! Tu mensaje ha sido enviado correctamente. Te contactaremos pronto.');
                window.location.href = 'servicios.html';
            </script>";
        } else {
            echo "<script>alert('Error al guardar los datos: " . mysqli_error($conexion) . "'); window.history.back();</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en la preparación de la consulta: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
} else {
    // Si no es POST, redirigir a la página de servicios
    header("Location: servicios.html");
    exit;
}
?>
