<?php
include('../config/conexion.php');

// Recibimos los datos del formulario (incluyendo el nuevo código personal)
$codigo_personal = $_POST['codigo_personal']; 
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$grado = $_POST['grado'];
$establecimiento = $_POST['establecimiento'];
$encargado = $_POST['encargado_nombre'];
$tel_encargado = $_POST['encargado_telefono'];
$curso = $_POST['curso_id'];

// Insertamos incluyendo la nueva columna 'codigo_personal'
$sql = "INSERT INTO alumnos (codigo_personal, nombres, apellidos, direccion, telefono_alumno, grado_academico, establecimiento_procedencia, encargado_nombre, encargado_telefono, curso_id, estado) 
        VALUES ('$codigo_personal', '$nombres', '$apellidos', '$direccion', '$telefono', '$grado', '$establecimiento', '$encargado', '$tel_encargado', '$curso', 1)";

if(mysqli_query($conexion, $sql)){
    // Si todo sale bien, regresamos a la lista de alumnos
    header("Location: ../alumnos.php?mensaje=registrado");
} else {
    // Si hay error, lo mostramos (útil por si olvidaste ejecutar el ALTER TABLE en la DB)
    echo "Error: " . mysqli_error($conexion);
}
?>