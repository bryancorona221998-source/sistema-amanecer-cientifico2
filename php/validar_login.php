<?php
// 1. Conectar a la base de datos
include('../config/conexion.php');

// 2. Recibir datos del formulario
// Usamos mysqli_real_escape_string para evitar errores con caracteres especiales
$usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
$clave   = mysqli_real_escape_string($conexion, $_POST['clave']);

// 3. Iniciar sesión
session_start();

// 4. Consultar si existe el usuario
$consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if ($filas > 0) {
    // -- ÉXITO --
    $datos = mysqli_fetch_assoc($resultado);
    
    // Guardamos variables de sesión
    $_SESSION['usuario'] = $usuario;
    // Verifica que el nombre de la columna sea 'nombre_completo' o 'nombre_complete' según tu DB
    $_SESSION['nombre']  = $datos['nombre_completo']; 

    // Vamos al Dashboard
    header("location: ../inicio.php?v=" . time()); 
    exit;

} else {
    // -- ERROR MEJORADO --
    // En lugar de alert, mandamos el error por URL al index.php
    header("location: ../index.php?error=1");
    exit;
}

// Limpieza
mysqli_free_result($resultado);
mysqli_close($conexion);
?>