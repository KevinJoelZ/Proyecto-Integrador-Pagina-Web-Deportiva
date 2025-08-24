<?php
$host = "sql107.infinityfree.com";
$usuario = "if0_39340780";
$clave = "Vd30M31z3a";
$base_datos = "if0_39340780_guardar_base_datos";

$conexion = mysqli_connect($host, $usuario, $clave, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa a la base de datos.";
}

mysqli_set_charset($conexion, "utf8");
?>