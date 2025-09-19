<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeporteFit - Acceso Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iOCIgZmlsbD0iIzRDQUY1MCIvPgo8Y2lyY2xlIGN4PSI4IiBjeT0iMTYiIHI9IjQiIGZpbGw9IiM0Q0FGNTAiLz4KPGNpcmNsZSBjeD0iMjQiIGN5PSIxNiIgcj0iNCIgZmlsbD0iIzRDQUY1MCIvPgo8L3N2Zz4K">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Firebase SDK -->
    <link rel="stylesheet" href="./css/styleindex.css">
</head>

<body>
    <div id="particles-js"></div>

    <div class="container">
        <div class="logo">
            <i class="fas fa-running logo-icon"></i>
            <span class="logo-text">DeporteFit</span>
        </div>

        <div class="hero">
            <h1>Conecta con el mundo deportivo</h1>
            <p>Accede a estadísticas personalizadas, conecta con otros atletas y lleva tu rendimiento al siguiente nivel.</p>
        </div>

        <div class="divider"></div>

        <div class="features">
            <div class="feature">
                <i class="fas fa-chart-line"></i>
                <h3>Estadísticas Avanzadas</h3>
                <p>Seguimiento detallado de tu progreso deportivo</p>
            </div>

            <div class="feature">
                <i class="fas fa-users"></i>
                <h3>Comunidad Global</h3>
                <p>Conecta con deportistas de todo el mundo</p>
            </div>

            <div class="feature">
                <i class="fas fa-trophy"></i>
                <h3>Logros y Retos</h3>
                <p>Supera tus límites y desbloquea achievements</p>
            </div>
        </div>

        <button id="googleSignIn" class="google-btn">
            <i class="fab fa-google google-icon"></i>
            Iniciar sesión con Google
        </button>

        <div id="loading" class="message loading" style="display: none;">Cargando...</div>
        <div id="success" class="message success" style="display: none;">✅ ¡Inicio de sesión exitoso! Redirigiendo...</div>
        <div id="error" class="message error" style="display: none;"></div>

        <div class="footer">
            <p>© 2025 DeporteFit. Todos los derechos reservados.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="./Scriptsindex/Particulas.js"></script>
    <script type="module">
        import {
            initializeApp
        } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
        import {
            getAuth,
            GoogleAuthProvider,
            signInWithPopup,
            onAuthStateChanged
        } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';

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

        // Elementos del DOM
        const googleSignInBtn = document.getElementById('googleSignIn');
        const loadingDiv = document.getElementById('loading');
        const successDiv = document.getElementById('success');
        const errorDiv = document.getElementById('error');

        // Función para mostrar mensajes
        function showMessage(type, message = '') {
            // Ocultar todos los mensajes
            loadingDiv.style.display = 'none';
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';

            // Mostrar el mensaje específico
            switch (type) {
                case 'loading':
                    loadingDiv.style.display = 'block';
                    break;
                case 'success':
                    successDiv.style.display = 'block';
                    break;
                case 'error':
                    errorDiv.style.display = 'block';
                    if (message) {
                        errorDiv.textContent = '❌ ' + message;
                    }
                    break;
            }
        }

        // Función para guardar usuario en la base de datos
        async function saveUserToDatabase(user) {
            const userData = {
                uid: user.uid,
                name: user.displayName,
                email: user.email,
                photoURL: user.photoURL,
                emailVerified: user.emailVerified,
                rol: "cliente"
            };

            try {
                const response = await fetch('./login/guardar_usuario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });

                if (!response.ok) {
                    //* throw new Error(HTTP error! status: ${response.status});
                }

                const result = await response.json();
                console.log('Respuesta de guardar usuario:', result);

                return result.success;
            } catch (error) {
                console.error('Error al guardar usuario:', error);
                throw error;
            }
        }

        // Función para obtener el rol del usuario
        async function getUserRole(uid) {
            console.log('Obteniendo rol para UID:', uid);

            try {
                const response = await fetch('./login/obtener_rol.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        uid: uid
                    })
                });

                if (!response.ok) {
                    //* throw new Error(HTTP error! status: ${response.status});
                }

                const result = await response.json();
                console.log('Respuesta de rol:', result);

                return result.success ? result.rol : 'cliente';
            } catch (error) {
                console.error('Error al obtener rol:', error);
                return 'cliente';
            }
        }

        // Función principal de autenticación
        async function signInWithGoogle() {
            try {
                showMessage('loading');
                googleSignInBtn.disabled = true;

                // Limpiar datos anteriores
                sessionStorage.clear();

                console.log('Iniciando autenticación...');

                // Autenticar con Firebase
                const result = await signInWithPopup(auth, provider);
                const user = result.user;

                console.log('Usuario autenticado:', user.displayName, user.email);

                // Guardar en la base de datos
                await saveUserToDatabase(user);

                // Obtener el rol del usuario
                const userRole = await getUserRole(user.uid);
                console.log('Rol obtenido:', userRole);

                // Guardar datos en sessionStorage
                const userData = {
                    uid: user.uid,
                    name: user.displayName,
                    email: user.email,
                    photoURL: user.photoURL,
                    rol: userRole
                };

                sessionStorage.setItem('user', JSON.stringify(userData));
                sessionStorage.setItem('justLoggedIn', 'true');

                showMessage('success');

                // Redirigir después de 2 segundos
                setTimeout(() => {
                    if (userRole === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        window.location.href = 'cliente.php';
                    }
                }, 2000);

            } catch (error) {
                console.error('Error en la autenticación:', error);

                let errorMessage = 'Error desconocido';

                if (error.code) {
                    switch (error.code) {
                        case 'auth/popup-closed-by-user':
                            errorMessage = 'Autenticación cancelada por el usuario';
                            break;
                        case 'auth/popup-blocked':
                            errorMessage = 'El navegador bloqueó la ventana emergente';
                            break;
                        case 'auth/unauthorized-domain':
                            errorMessage = 'Dominio no autorizado para Firebase';
                            break;
                        default:
                            errorMessage = error.message || 'Error en la autenticación';
                    }
                } else {
                    errorMessage = error.message || 'Error de conexión';
                }

                showMessage('error', errorMessage);
            } finally {
                googleSignInBtn.disabled = false;
            }
        }

        // Event listener para el botón
        googleSignInBtn.addEventListener('click', signInWithGoogle);

        // Función para obtener parámetros de URL
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Verificar autenticación al cargar la página
        onAuthStateChanged(auth, async (user) => {
            // Si viene de logout, no verificar autenticación
            if (getUrlParameter('action') === 'logout') {
                console.log('Logout detectado, limpiando...');
                sessionStorage.clear();
                const newUrl = window.location.pathname;
                window.history.replaceState(null, '', newUrl);
                return;
            }

            if (user && sessionStorage.getItem('justLoggedIn') === 'true') {
                console.log('Usuario recién autenticado, redirigiendo...');
                sessionStorage.removeItem('justLoggedIn');

                try {
                    const userRole = await getUserRole(user.uid);
                    if (userRole === 'admin') {
                        window.location.href = 'admin.php';
                    } else {
                        window.location.href = 'cliente.php';
                    }
                } catch (error) {
                    console.error('Error al obtener rol durante redirección:', error);
                }
            }
        });

        // Log inicial para debugging
        console.log('Firebase inicializado correctamente');
    </script>


</body>

</html>