<?php
include('../config/conexion.php');

$id_alumno = $_GET['id_alumno'];
$anio_actual = 2026; 
$mes_actual_num = (int)date('n'); 
$dia_actual = (int)date('j');    

// 1. CONSULTAR INSCRIPCIÓN
$sql_insc = "SELECT id, fecha_pago FROM pagos WHERE alumno_id = '$id_alumno' AND concepto = 'Inscripción' AND anio_pagado = '$anio_actual' LIMIT 1";
$res_insc = mysqli_query($conexion, $sql_insc);
$pago_inscripcion = mysqli_fetch_assoc($res_insc);

// 2. CONSULTAR MENSUALIDADES
$sql = "SELECT mes_pagado, id, fecha_pago FROM pagos 
        WHERE alumno_id = '$id_alumno' 
        AND concepto = 'Mensualidad'
        AND anio_pagado = '$anio_actual'"; 
$resultado = mysqli_query($conexion, $sql);
$pagos_realizados = [];

while($fila = mysqli_fetch_assoc($resultado)){
    $mes_db = trim($fila['mes_pagado']); 
    $pagos_realizados[$mes_db] = [
        'id_pago' => $fila['id'], 
        'id_recibo' => str_pad($fila['id'], 4, "0", STR_PAD_LEFT),
        'fecha' => date("d/m/Y", strtotime($fila['fecha_pago']))
    ];
}

// 3. CONSULTAR ALUMNO
$sql_alum = "SELECT nombres, apellidos, grado_academico FROM alumnos WHERE id = '$id_alumno'";
$res_alum = mysqli_query($conexion, $sql_alum);
$alumno = mysqli_fetch_assoc($res_alum);

$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
?>

<div class="card border-0 shadow-sm animate__animated animate__fadeIn">
    <div class="card-header bg-white py-3 text-center border-bottom">
        <h3 class="fw-bold text-primary mb-0"><?php echo $alumno['nombres'] . " " . $alumno['apellidos']; ?></h3>
        <p class="text-muted mb-0">
            <i class="fas fa-graduation-cap"></i> <?php echo ($alumno['grado_academico'] ?: 'Sin Grado'); ?> | Ciclo <?php echo $anio_actual; ?>
        </p>
    </div>
    <div class="card-body p-4">
        <div class="contenedor-meses">
            
            <div class="mes-card <?php echo ($pago_inscripcion) ? 'pagado' : 'pendiente'; ?>">
                <i class="fas fa-file-signature mb-2"></i>
                <div>INSCRIPCIÓN</div>
                <span class="info-recibo">
                    <?php if($pago_inscripcion): ?>
                        Recibo: <?php echo str_pad($pago_inscripcion['id'], 4, "0", STR_PAD_LEFT); ?><br>
                        Pagado: <?php echo date("d/m/Y", strtotime($pago_inscripcion['fecha_pago'])); ?>
                    <?php else: ?>
                        PENDIENTE
                    <?php endif; ?>
                </span>
            </div>

            <?php 
            foreach($meses as $index => $nombre_mes): 
                $num_mes = $index + 1;
                $clase = ""; $texto = ""; $icono = "fa-calendar-alt";

                if (isset($pagos_realizados[$nombre_mes])) {
                    $clase = "pagado"; 
                    $texto = "Recibo: " . $pagos_realizados[$nombre_mes]['id_recibo'] . "<br>Pagado: " . $pagos_realizados[$nombre_mes]['fecha'];
                    $icono = "fa-check-circle";
                    // SE ELIMINÓ LA VARIABLE $onclick PARA EVITAR ACCIONES AL HACER CLIC
                } else if ($num_mes == $mes_actual_num) {
                    if ($dia_actual <= 10) {
                        $clase = "proximo"; $texto = "MES EN CURSO"; $icono = "fa-clock";
                    } else {
                        $clase = "pendiente"; $texto = "PAGO ATRASADO"; $icono = "fa-exclamation-circle";
                    }
                } else if ($num_mes < $mes_actual_num) {
                    $clase = "pendiente"; $texto = "DEUDA"; $icono = "fa-times-circle";
                } else {
                    $clase = "futuro"; $texto = "PRÓXIMO";
                }
            ?>
                <div class="mes-card <?php echo $clase; ?>">
                    <i class="fas <?php echo $icono; ?> mb-2"></i>
                    <div><?php echo $nombre_mes; ?></div>
                    <span class="info-recibo text-uppercase"><?php echo $texto; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>