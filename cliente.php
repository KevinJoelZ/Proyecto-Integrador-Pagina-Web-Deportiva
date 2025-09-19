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
    <!-- Encabezado público con navegación -->
    <header class="main-header">
        <nav class="main-nav">
            <div class="logo">
                <i class="fas fa-dumbbell" style="font-size: 2.2rem; color: #ffb74d;"></i>
                <span style="font-size: 1.5rem; color: #fff; font-weight: 700; letter-spacing: 1px;">DeporteFit</span>
            </div>
            <ul class="main-menu">
                <li><a href="cliente.php" class="activo">Inicio</a></li>
                <li><a href="servicios.html">Servicios</a></li>
                <li><a href="entrenadores.html">Entrenadores</a></li>
                <li><a href="planes.html">Planes y Precios</a></li>
                <li><a href="contacto.html">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero con botón de Google -->
    <main class="container">
        <section class="hero">
            <div class="hero-content">
                <h1>Transforma tu vida con entrenamiento deportivo profesional</h1>
                <p class="hero-subtitle">La plataforma web en entrenamiento personalizado para múltiples deportes. Accede a cursos certificados, entrenadores expertos y programas diseñados para alcanzar tus objetivos deportivos desde cualquier lugar del mundo.</p>
                <div class="hero-buttons">
                    <a href="planes.html" class="btn btn-primary">Comenzar Ahora</a>
                    <a href="servicios.html" class="btn btn-secondary">Ver Deportes</a>
                    <button id="googleSignIn" class="btn btn-secondary" style="background:#fff; color:#333; border:1px solid #ddd; display:inline-flex; align-items:center; gap:.5rem;">
                        <i class="fab fa-google" style="color:#DB4437;"></i>
                        Iniciar sesión con Google
                    </button>
                </div>
                <div id="loading" class="message loading" style="display:none; margin-top:.8rem; color:#1976d2;">Cargando...</div>
                <div id="success" class="message success" style="display:none; margin-top:.8rem; color:#2e7d32;">✅ ¡Inicio de sesión exitoso! Redirigiendo...</div>
                <div id="error" class="message error" style="display:none; margin-top:.8rem; color:#c62828;"></div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1200&q=80" alt="Entrenamiento deportivo">
            </div>
        </section>
    </main>

    <!-- Script de Firebase para login con Google -->
    <script type="module">
        import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
        import { getAuth, GoogleAuthProvider, signInWithPopup, onAuthStateChanged } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';

        const firebaseConfig = {
            apiKey: "AIzaSyBZoUGrSk3V-yFW6QHxXLeXQfPMgnYUeQo",
            authDomain: "proyectoweb-fc2d2.firebaseapp.com",
            projectId: "proyectoweb-fc2d2",
            storageBucket: "proyectoweb-fc2d2.firebasestorage.app",
            messagingSenderId: "508269230145",
            appId: "1:508269230145:web:d183a7c70873785487eec0",
            measurementId: "G-3HX251Y5DH"
        };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        const googleSignInBtn = document.getElementById('googleSignIn');
        const loadingDiv = document.getElementById('loading');
        const successDiv = document.getElementById('success');
        const errorDiv = document.getElementById('error');

        function showMessage(type, message = '') {
            loadingDiv.style.display = 'none';
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            if (type === 'loading') loadingDiv.style.display = 'block';
            if (type === 'success') successDiv.style.display = 'block';
            if (type === 'error') {
                errorDiv.style.display = 'block';
                if (message) errorDiv.textContent = '❌ ' + message;
            }
        }

        async function saveUserToDatabase(user) {
            const userData = {
                uid: user.uid,
                name: user.displayName,
                email: user.email,
                photoURL: user.photoURL,
                emailVerified: user.emailVerified,
                rol: 'cliente'
            };
            const response = await fetch('./login/guardar_usuario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(userData)
            });
            return response.ok;
        }

        async function getUserRole(uid) {
            const response = await fetch('./login/obtener_rol.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ uid })
            });
            if (!response.ok) return 'cliente';
            const result = await response.json();
            return result.success ? result.rol : 'cliente';
        }

        async function signInWithGoogle() {
            try {
                showMessage('loading');
                googleSignInBtn.disabled = true;
                sessionStorage.clear();
                const result = await signInWithPopup(auth, provider);
                const user = result.user;
                await saveUserToDatabase(user);
                const userRole = await getUserRole(user.uid);
                const userData = {
                    uid: user.uid, name: user.displayName, email: user.email, photoURL: user.photoURL, rol: userRole
                };
                sessionStorage.setItem('user', JSON.stringify(userData));
                sessionStorage.setItem('justLoggedIn', 'true');
                showMessage('success');
                setTimeout(() => {
                    if (userRole === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        window.location.href = 'cliente.php';
                    }
                }, 1200);
            } catch (error) {
                let msg = error?.message || 'Error en la autenticación';
                if (error?.code === 'auth/popup-closed-by-user') msg = 'Autenticación cancelada por el usuario';
                if (error?.code === 'auth/popup-blocked') msg = 'El navegador bloqueó la ventana emergente';
                if (error?.code === 'auth/unauthorized-domain') msg = 'Dominio no autorizado para Firebase';
                showMessage('error', msg);
            } finally {
                googleSignInBtn.disabled = false;
            }
        }

        googleSignInBtn?.addEventListener('click', signInWithGoogle);

        onAuthStateChanged(auth, async (user) => {
            if (user && sessionStorage.getItem('justLoggedIn') === 'true') {
                sessionStorage.removeItem('justLoggedIn');
                try {
                    const userRole = await getUserRole(user.uid);
                    if (userRole === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        window.location.href = 'cliente.php';
                    }
                } catch (e) { /* noop */ }
            }
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