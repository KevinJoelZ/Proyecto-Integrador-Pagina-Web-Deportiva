<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$base_datos = "guardar_base_datos";

$conexion = mysqli_connect($host, $usuario, $clave, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa a la base de datos.";
}

mysqli_set_charset($conexion, "utf8");
?>