<?php
// Archivo para procesar formularios según la página de origen
include 'conexión.php';

// Verificar que la conexión esté activa
if (!$conexion) {
    die("Error: No se pudo conectar a la base de datos");
}

// Verifica que los datos lleguen por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la página de origen
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    
    // Determinar qué tipo de formulario es y procesarlo
    if (strpos($referer, 'contacto.html') !== false) {
        procesarFormularioContacto($conexion);
    } elseif (strpos($referer, 'entrenadores.html') !== false) {
        procesarFormularioEntrenadores($conexion);
    } elseif (strpos($referer, 'planes.html') !== false) {
        procesarFormularioPlanes($conexion);
    } elseif (strpos($referer, 'servicios.html') !== false) {
        procesarFormularioServicios($conexion);
    } else {
        // Si no se puede determinar, usar el formulario general
        procesarFormularioGeneral($conexion);
    }
    
    mysqli_close($conexion);
} else {
    // Si no es POST, redirigir a la página principal
    header("Location: index.html");
    exit;
}

function procesarFormularioContacto($conexion) {
    // Validar y limpiar los datos de entrada
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    $privacidad = isset($_POST['privacidad']) ? 1 : 0;

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($motivo) || empty($mensaje) || !$privacidad) {
        echo "<script>alert('Por favor, complete todos los campos obligatorios y acepte la política de privacidad.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingrese un email válido.'); window.history.back();</script>";
        exit;
    }

    // Consulta SQL para insertar en la tabla contactos
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssssi", $nombre, $email, $telefono, $motivo, $mensaje, $privacidad);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu mensaje de contacto ha sido enviado correctamente. Te contactaremos pronto.');
                    window.location.href = 'contacto.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar el mensaje. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar el mensaje: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}

function procesarFormularioEntrenadores($conexion) {
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

    // Consulta SQL para insertar en la tabla solicitudes_entrenadores
    $sql = "INSERT INTO solicitudes_entrenadores (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu solicitud para contactar entrenadores ha sido enviada. Te contactaremos pronto.');
                    window.location.href = 'entrenadores.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar la solicitud. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar la solicitud: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}

function procesarFormularioPlanes($conexion) {
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

    // Consulta SQL para insertar en la tabla solicitudes_planes
    $sql = "INSERT INTO solicitudes_planes (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu solicitud de información sobre planes ha sido enviada. Te contactaremos pronto.');
                    window.location.href = 'planes.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar la solicitud. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar la solicitud: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}

function procesarFormularioServicios($conexion) {
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

    // Consulta SQL para insertar en la tabla solicitudes_servicios
    $sql = "INSERT INTO solicitudes_servicios (nombre, email, telefono, motivo, mensaje, fecha_solicitud) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu solicitud de información sobre servicios ha sido enviada. Te contactaremos pronto.');
                    window.location.href = 'servicios.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar la solicitud. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar la solicitud: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}

function procesarFormularioGeneral($conexion) {
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

    // Consulta SQL para insertar en la tabla contactos (tabla general)
    $sql = "INSERT INTO contactos (nombre, email, telefono, motivo, mensaje, privacidad, fecha_creacion) VALUES (?, ?, ?, ?, ?, 0, NOW())";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $telefono, $motivo, $mensaje);
        
        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<script>
                    alert('¡Éxito! Tu mensaje ha sido enviado correctamente. Te contactaremos pronto.');
                    window.location.href = 'index.html';
                </script>";
            } else {
                echo "<script>alert('Error: No se pudo enviar el mensaje. Por favor, inténtalo de nuevo.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al enviar el mensaje: " . mysqli_stmt_error($stmt) . "'); window.history.back();</script>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error en el sistema: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
}
?>
