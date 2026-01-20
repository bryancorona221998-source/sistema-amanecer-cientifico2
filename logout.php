<?php
// 1. Iniciar la sesión para poder manipularla
session_start();

// 2. Limpiar el historial del navegador para que no puedan dar "atrás"
// Estas líneas obligan al navegador a no guardar copia de la página anterior
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

// 3. Destruir todas las variables de sesión
$_SESSION = array();

// 4. Borrar la cookie de sesión del navegador (Asegura cierre total)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 5. Destruir la sesión en el servidor
session_destroy();

// 6. Redireccionar al usuario al Login (index.php)
header("Location: index.php");
exit;
?>