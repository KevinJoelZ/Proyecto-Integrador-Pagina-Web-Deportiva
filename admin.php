<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - DeporteFit</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iOCIgZmlsbD0iIzRDQUY1MCIvPgo8Y2lyY2xlIGN4PSI4IiBjeT0iMTYiIHI9IjQiIGZpbGw9IiM0Q0FGNTAiLz4KPGNpcmNsZSBjeD0iMjQiIGN5PSIxNiIgcj0iNCIgZmlsbD0iIzRDQUY1MCIvPgo8L3N2Zz4K">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(180deg, #f7fbff 0%, #e3f0ff 100%);">
    <?php
    session_start();
    include_once 'conexión.php';
    
    // Verificar sesión admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
    
    $user_nombre = $_SESSION['user_nombre'] ?? 'Admin';
    $user_email = $_SESSION['user_email'] ?? '';
    
    include_once './template/headercliente.php';
    include_once './template/maincliente.php';
    
    // Sección admin
    echo '<div class="admin-dashboard" style="background: rgba(255,255,255,0.1); padding: 1rem; margin: 1rem; border-radius: 8px; text-align: center; color: #333;">';
    echo '<h2>Panel de Administración, ' . htmlspecialchars($user_nombre) . '!</h2>';
    echo '<p>Email: ' . htmlspecialchars($user_email) . '</p>';
    echo '<p>Accede a herramientas de gestión de usuarios, contenido y solicitudes.</p>';
    echo '<div style="margin-top: 1rem;">';
    echo '<a href="Crudadmin/noticias.php" style="display: inline-block; margin: 0.5rem; padding: 0.5rem 1rem; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Gestionar Noticias</a>';
    echo '<a href="logout.php" style="display: inline-block; margin: 0.5rem; padding: 0.5rem 1rem; background: #ff4757; color: white; text-decoration: none; border-radius: 4px;">Cerrar Sesión</a>';
    echo '</div>';
    echo '</div>';
    ?>
    
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>DeporteFit Admin</h3>
                <p>Panel de administración profesional.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/kevin.zapata.167561" target="_blank" rel="noopener"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/kevinzapata1999/?hl=es" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <a href="https://x.com/KevinZapat42232" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.youtube.com/@kevinzapatamoreno608" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Gestión</h4>
                <ul>
                    <li><a href="#">Usuarios</a></li>
                    <li><a href="#">Contenido</a></li>
                    <li><a href="#">Solicitudes</a></li>
                    <li><a href="#">Reportes</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 DeporteFit. Todos los derechos reservados.
        </div>
    </footer>
    <script>
        // Actualiza el año automáticamente en el footer
        document.addEventListener('DOMContentLoaded', function() {
            const footerBottom = document.querySelector('.footer-bottom');
            if (footerBottom) {
                footerBottom.innerHTML = footerBottom.innerHTML.replace('2025', new Date().getFullYear());
            }
        });
    </script>
</body>
</html>