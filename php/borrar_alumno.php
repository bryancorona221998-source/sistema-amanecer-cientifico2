<?php
session_start();
include '../config/conexion.php';

// Verificamos si nos enviaron un ID
if (isset($_GET['id'])) {
    $id_alumno = $_GET['id'];

    // --- PASO 1: BORRAR PAGOS (Los hijos) ---
    // Primero eliminamos el historial de pagos de este alumno para que no haya error
    $sql_borrar_pagos = "DELETE FROM pagos WHERE alumno_id = '$id_alumno'";
    $ejecutar_pagos = mysqli_query($conexion, $sql_borrar_pagos);

    if(!$ejecutar_pagos){
        die("Error al borrar pagos: " . mysqli_error($conexion));
    }

    // --- PASO 2: BORRAR ALUMNO (El padre) ---
    // Ahora que no tiene pagos asociados, ya podemos borrarlo
    $sql_borrar_alumno = "DELETE FROM alumnos WHERE id = '$id_alumno'";
    
    if (mysqli_query($conexion, $sql_borrar_alumno)) {
        // Si sale bien, redirigimos al inicio con mensaje de éxito
       header("Location: ../alumnos.php?mensaje=eliminado&seccion=alumnos");
    } else {
        echo "Error al eliminar alumno: " . mysqli_error($conexion);
    }

} else {
    // Si intentan entrar sin ID, los sacamos
    header("location: ../alumnos.php");
}
?>