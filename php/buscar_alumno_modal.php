<?php
// php/buscar_alumno_modal.php

// 1. Incluir la conexión
// Como estamos en la carpeta 'php', salimos una vez (..) para entrar a 'config'
include('../config/conexion.php');

// 2. Verificar que recibimos el ID
if (isset($_POST['id_para_buscar'])) {
    $id = $_POST['id_para_buscar'];

    // 3. La Consulta (Usando 'id' como vimos en tu diagrama)
    $sql = "SELECT * FROM alumnos WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);
    
    // Verificamos si la preparación falló (útil para debug)
    if ($stmt === false) {
        echo json_encode(["error" => "Error SQL: " . $conexion->error]);
        exit;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        // ¡ÉXITO! Devolvemos los datos limpios
        echo json_encode($fila);
    } else {
        // No se encontró
        echo json_encode(["error" => "Alumno no encontrado"]);
    }
} else {
    echo json_encode(["error" => "No llegó ningún ID"]);
}
?>