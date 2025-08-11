<?php
include 'conexión.php';

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : '';
    $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';

    // Ajusta el nombre de la tabla y los campos según tu base de datos
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        if (mysqli_stmt_execute($stmt)) {
            echo "Datos guardados correctamente.";
        } else {
            echo "Error al guardar los datos: " . mysqli_error($conexion);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no permitido.";
}
?>
