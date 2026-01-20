<?php
include('../config/conexion.php');

// Usamos trim() para limpiar espacios accidentales
$campo = isset($_POST['campo']) ? mysqli_real_escape_string($conexion, trim($_POST['campo'])) : '';
$html = '';

if (!empty($campo)) {
    // CAMBIO 1: Agregamos curso_id a la consulta
    $sql = "SELECT id, nombres, apellidos, grado_academico, curso_id 
            FROM alumnos 
            WHERE (nombres LIKE '%$campo%' OR apellidos LIKE '%$campo%' OR CONCAT(nombres, ' ', apellidos) LIKE '%$campo%') 
            AND estado = 1 
            ORDER BY nombres ASC LIMIT 5";
            
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $nombre_c = $fila['nombres'] . " " . $fila['apellidos'];
            $grado = !empty($fila['grado_academico']) ? $fila['grado_academico'] : 'Grado no registrado';
            $curso_id = $fila['curso_id']; // Guardamos el ID del curso
            
            // CAMBIO 2: Ahora enviamos {$fila['curso_id']} en el tercer parámetro de seleccionarAlumno
            $html .= "<a href='#' class='list-group-item list-group-item-action border-start-0 border-end-0 py-3' 
                        onclick=\"seleccionarAlumno({$fila['id']}, '$nombre_c', $curso_id); return false;\">
                        <div class='d-flex w-100 justify-content-between align-items-center'>
                            <div>
                                <h6 class='mb-0 fw-bold text-primary'>$nombre_c</h6>
                                <small class='text-muted'><i class='fas fa-graduation-cap me-1'></i> $grado</small>
                            </div>
                            <i class='fas fa-chevron-right text-light'></i>
                        </div>
                      </a>";
        }
    } else {
        $html .= "<div class='p-3 text-center text-muted'><i class='fas fa-search mb-2 d-block'></i> No se encontró a nadie con ese nombre.</div>";
    }
}
echo $html;
?>