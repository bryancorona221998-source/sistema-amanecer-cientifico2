<?php
// 1. Establecer la zona horaria correcta para Guatemala
date_default_timezone_set('America/Guatemala');

// Datos de conexión
$host = "localhost";
$usuario = "root";
$clave = "Academia.2026"; 
$bd = "amanecer_cientifico";

// Crear conexión
$conexion = mysqli_connect($host, $usuario, $clave, $bd);

// Verificar conexión
if (!$conexion) {
    die("Error fatal: No se pudo conectar. " . mysqli_connect_error());
}

// Configurar caracteres (para que las tildes y ñ se vean bien)
mysqli_set_charset($conexion, "utf8");

?>
