<?php
// Archivo de prueba para verificar conexión y estructura de la base de datos
include 'conexión.php';

echo "<h2>Prueba de Conexión a la Base de Datos</h2>";

if ($conexion) {
    echo "<p style='color: green;'>✅ Conexión exitosa a la base de datos</p>";
    
    // Verificar si la tabla contactos existe
    $sql_check_table = "SHOW TABLES LIKE 'contactos'";
    $result = mysqli_query($conexion, $sql_check_table);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color: green;'>✅ La tabla 'contactos' existe</p>";
        
        // Mostrar estructura de la tabla
        $sql_structure = "DESCRIBE contactos";
        $result_structure = mysqli_query($conexion, $sql_structure);
        
        if ($result_structure) {
            echo "<h3>Estructura de la tabla 'contactos':</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Default</th><th>Extra</th></tr>";
            
            while ($row = mysqli_fetch_assoc($result_structure)) {
                echo "<tr>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . $row['Default'] . "</td>";
                echo "<td>" . $row['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        // Contar registros existentes
        $sql_count = "SELECT COUNT(*) as total FROM contactos";
        $result_count = mysqli_query($conexion, $sql_count);
        if ($result_count) {
            $row = mysqli_fetch_assoc($result_count);
            echo "<p><strong>Total de registros en la tabla: " . $row['total'] . "</strong></p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ La tabla 'contactos' NO existe</p>";
        echo "<p>Necesitas crear la tabla con la siguiente estructura:</p>";
        echo "<pre>
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    motivo VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
        </pre>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
}

mysqli_close($conexion);
?>
