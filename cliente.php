<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeporteFit - Plataforma de Entrenamiento Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iOCIgZmlsbD0iIzRDQUY1MCIvPgo8Y2lyY2xlIGN4PSI4IiBjeT0iMTYiIHI9IjQiIGZpbGw9IiM0Q0FGNTAiLz4KPGNpcmNsZSBjeD0iMjQiIGN5PSIxNiIgcj0iNCIgZmlsbD0iIzRDQUY1MCIvPgo8L3N2Zz4K">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(180deg, #f7fbff 0%, #e3f0ff 100%);">
    <?php
    session_start();
    include_once 'conexión.php';
    
    // Verificar sesión
    if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'client') {
        header('Location: index.php');
        exit;
    }
    
    $user_nombre = $_SESSION['user_nombre'] ?? 'Cliente';
    $user_email = $_SESSION['user_email'] ?? '';
    
    include_once './template/headercliente.php';
    include_once './template/maincliente.php';
    
    // Sección de datos del usuario
    echo '<div class="user-welcome" style="background: rgba(255,255,255,0.1); padding: 1rem; margin: 1rem; border-radius: 8px; text-align: center; color: #333;">';
    echo '<h2>Bienvenido, ' . htmlspecialchars($user_nombre) . '!</h2>';
    echo '<p>Email: ' . htmlspecialchars($user_email) . '</p>';
    echo '<p>Accede a tus servicios personalizados y datos de entrenamiento.</p>';
    echo '</div>';
    ?>
    
    <script>
    // Acordeón para FAQ y Blog/Noticias (solo una respuesta/card abierta a la vez)
    window.addEventListener('load', function() {
        // FAQ acordeón: abrir/cerrar individualmente
        var questions = document.querySelectorAll('.faq-question');
        questions.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var answer = this.nextElementSibling;
                if (answer.style.display === 'block' || answer.style.display === 'flex') {
                    answer.style.display = 'none';
                    this.classList.remove('active');
                } else {
                    answer.style.display = 'block';
                    this.classList.add('active');
                }
            });
        });

        // Blog/Noticias: solo una card abierta a la vez con animación
        var readMoreLinks = document.querySelectorAll('.read-more');
        readMoreLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var blogCard = this.closest('.blog-card');
                var thisMore = blogCard.querySelector('.blog-more');
                if (thisMore.style.display === 'block') {
                    thisMore.style.display = 'none';
                    thisMore.classList.remove('animating');
                    this.textContent = 'Leer más';
                } else {
                    thisMore.style.display = 'block';
                    thisMore.classList.add('animating');
                    this.textContent = 'Leer menos';
                    setTimeout(function(){
                        thisMore.classList.remove('animating');
                    }, 1200);
                }
            });
        });
    });
    </script>

    <footer class="main-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>DeporteFit</h3>
            <p>La plataforma líder en entrenamiento deportivo personalizado con certificaciones profesionales.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/kevin.zapata.167561" target="_blank" rel="noopener"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com/kevinzapata1999/?hl=es" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                <a href="https://x.com/KevinZapat42232" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com/@kevinzapatamoreno608" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h4>Servicios</h4>
            <ul>
                <li><a href="#">Entrenamiento Personal</a></li>
                <li><a href="#">Cursos Certificados</a></li>
                <li><a href="#">Planes de Nutrición</a></li>
                <li><a href="#">Asesoría Deportiva</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Deportes</h4>
            <ul>
                <li><a href="#">Running</a></li>
                <li><a href="#">Fitness</a></li>
                <li><a href="#">Natación</a></li>
                <li><a href="#">Ciclismo</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Contacto</h4>
            <p><i class="fas fa-envelope"></i> info@deportefit.com</p>
            <p><i class="fas fa-phone"></i> (593) 98 765 4321</p>
            <p><i class="fas fa-map-marker-alt"></i> Calle Deportiva 123, Ciudad Quito</p>
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