<?php
session_start();
include '../config/conexion.php';

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado_actual = $_GET['estado'];

    // Si estaba en 1 pasa a 0, si estaba en 0 pasa a 1
    $nuevo_estado = ($estado_actual == 1) ? 0 : 1;

    // DEFINIMOS EL TIPO DE MENSAJE SEGÚN EL NUEVO ESTADO
    // Si el nuevo estado es 1, el mensaje será "activado", si es 0 será "desactivado"
    $tipo_mensaje = ($nuevo_estado == 1) ? 'activado' : 'desactivado';

    $sql = "UPDATE alumnos SET estado = '$nuevo_estado' WHERE id = '$id'";
    
    if (mysqli_query($conexion, $sql)) {
        // Envíamos el mensaje específico en la URL
        header("Location: ../alumnos.php?seccion=alumnos&mensaje=" . $tipo_mensaje);
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
} else {
    header("location: ../alumnos.php");
}
?>