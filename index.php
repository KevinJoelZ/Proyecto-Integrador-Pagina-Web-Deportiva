<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeporteFit - Acceso Deportivo</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMTYiIGN5PSIxNiIgcj0iOCIgZmlsbD0iIzRDQUY1MCIvPgo8Y2lyY2xlIGN4PSI4IiBjeT0iMTYiIHI9IjQiIGZpbGw9IiM0Q0FGNTAiLz4KPGNpcmNsZSBjeD0iMjQiIGN5PSIxNiIgcj0iNCIgZmlsbD0iIzRDQUY1MCIvPgo8L3N2Zz4K">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Firebase SDK -->
    <script type="module">
      import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js';
      import { getAuth, signInWithPopup, GoogleAuthProvider } from 'https://www.gstatic.com/firebasejs/10.13.0/firebase-auth.js';
      
      const firebaseConfig = {
        apiKey: "AIzaSyBZoUGrSk3V-yFW6QHxXLeXQfPMgnYUeQo",
        authDomain: "proyectoweb-fc2d2.firebaseapp.com",
        projectId: "proyectoweb-fc2d2",
        storageBucket: "proyectoweb-fc2d2.appspot.com",
        messagingSenderId: "508269230145",
        appId: "1:508269230145:web:d183a7c70873785487eec0"
      };

      const app = initializeApp(firebaseConfig);
      const auth = getAuth(app);
      const provider = new GoogleAuthProvider();
      
      // Exponer para script global
      window.auth = auth;
      window.provider = provider;
      window.signInWithPopup = signInWithPopup;
      window.GoogleAuthProvider = GoogleAuthProvider;
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0d2c45 0%, #1a4b6d 100%);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .logo {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            font-size: 2.5rem;
            color: #4CAF50;
        }
        
        .logo-text {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero {
            margin-bottom: 3rem;
            max-width: 800px;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.4rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .divider {
            width: 100%;
            max-width: 600px;
            height: 2px;
            background: linear-gradient(to right, transparent, #4CAF50, transparent);
            margin: 2.5rem 0;
        }
        
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 4rem;
        }
        
        .feature {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            width: 250px;
            transition: transform 0.3s ease;
        }
        
        .feature:hover {
            transform: translateY(-10px);
        }
        
        .feature i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #4CAF50;
        }
        
        .feature h3 {
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }
        
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(90deg, #4285F4, #EA4335, #FBBC05, #34A853, #4285F4);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
            color: white;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            border: none;
            outline: none;
            margin-top: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .google-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: 0.5s;
        }
        
        .google-btn:hover::before {
            left: 100%;
        }
        
        .google-btn:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-3px);
        }
        
        .google-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .google-icon {
            width: 22px;
            height: 22px;
            color: white; /* Blanco para contraste con gradiente */
        }
        
        .footer {
            margin-top: 4rem;
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.2rem;
            }
            
            .features {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
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
        
        <button class="google-btn">
            <i class="fab fa-google google-icon"></i>
            Iniciar sesión con Google
        </button>
        
        <div class="footer">
            <p>© 2025 DeporteFit. Todos los derechos reservados.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#ffffff"
                    },
                    "shape": {
                        "type": ["circle", "polygon"],
                        "polygon": {
                            "sides": 6
                        },
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 3,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#4CAF50",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 3,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });
        // Agregar event listener para el botón de Google
        const googleBtn = document.querySelector('.google-btn');
        googleBtn.addEventListener('click', async () => {
            try {
                const result = await signInWithPopup(window.auth, window.provider);
                const credential = window.GoogleAuthProvider.credentialFromResult(result);
                const idToken = credential.idToken;

                const response = await fetch('auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id_token: idToken })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Error en autenticación: ' + data.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al iniciar sesión con Google: ' + error.message);
            }
        });
        
        // Cerrar DOMContentLoaded
        });
    </script>
</body>
</html>