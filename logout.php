<?php
session_start();

// Limpiar variables de sesión
$_SESSION = [];

// Borrar cookie de sesión si existe
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Destruir sesión en el servidor
session_destroy();

// Página mínima para limpiar storage/Firebase y redirigir
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="Cache-Control" content="no-store" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cerrando sesión…</title>
  <script>
  (function(){
    try { sessionStorage.clear(); } catch(_){}
    try { localStorage.clear(); } catch(_){}
    // Intentar cerrar sesión de Firebase si está disponible
    try {
      if (window.firebase && firebase.apps && firebase.apps.length && firebase.auth) {
        firebase.auth().signOut().finally(function(){
          window.location.replace('index.php');
        });
        return;
      }
    } catch(_){}
    // Redirección de respaldo inmediata
    window.location.replace('index.php');
  })();
  </script>
</head>
<body>
  Cerrando sesión…
</body>
</html>