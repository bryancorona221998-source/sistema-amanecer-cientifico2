<?php
include('../config/conexion.php');

// Preparamos un array para la respuesta (por defecto asumimos error)
$response = array('estado' => 'error', 'mensaje' => 'Error desconocido');

if (isset($_POST['id_alumno']) && isset($_POST['monto'])) {
    
    $alumno_id = $_POST['id_alumno'];
    $concepto = $_POST['concepto']; 
    $mes_anio = $_POST['mes'];      // Viene como "Enero 2026"
    $monto = $_POST['monto'];

    // 1. SEPARAR MES Y AÑO
    $partes_fecha = explode(' ', $mes_anio);
    
    // Obtenemos el año siempre (porque la inscripción también tiene año)
    if (count($partes_fecha) == 2) {
        $anio_pagado = $partes_fecha[1]; // "2026"
        $mes_temporal = $partes_fecha[0]; // "Enero"
    } else {
        $anio_pagado = date("Y");
        $mes_temporal = $mes_anio;
    }

    // 2. LÓGICA INTELIGENTE: ¿GUARDAMOS EL MES O NO?
    if ($concepto == 'Mensualidad') {
        // Si es mensualidad, SÍ guardamos el mes (ej: Enero)
        $mes_pagado = $mes_temporal;
    } else {
        // Si es Inscripción o Papelería, NO guardamos el mes (lo dejamos vacío)
        $mes_pagado = ''; 
    }

    // --- VERIFICACIÓN DE DUPLICADOS ---
    $duplicado = false;
    $mensaje_duplicado = "";

    // A. Si es Mensualidad: Revisamos que no se repita el mes
    if ($concepto == 'Mensualidad') {
        $sql_check = "SELECT id FROM pagos 
                      WHERE alumno_id = '$alumno_id' 
                      AND concepto = 'Mensualidad' 
                      AND mes_pagado = '$mes_pagado' 
                      AND anio_pagado = '$anio_pagado'";
        
        $query_check = mysqli_query($conexion, $sql_check);
        if (mysqli_num_rows($query_check) > 0) {
            $duplicado = true;
            $mensaje_duplicado = "Este alumno ya pagó la mensualidad de $mes_pagado $anio_pagado.";
        }
    }
    
    // B. Si es Inscripción: Revisamos que no se haya inscrito ya en este año
    if ($concepto == 'Inscripción') {
        $sql_check = "SELECT id FROM pagos 
                      WHERE alumno_id = '$alumno_id' 
                      AND concepto = 'Inscripción' 
                      AND anio_pagado = '$anio_pagado'";
        
        $query_check = mysqli_query($conexion, $sql_check);
        if (mysqli_num_rows($query_check) > 0) {
            $duplicado = true;
            $mensaje_duplicado = "Este alumno ya pagó la inscripción del año $anio_pagado.";
        }
    }

    // Si encontramos duplicados, detenemos y respondemos
    if ($duplicado) {
        $response['estado'] = 'error';
        $response['mensaje'] = $mensaje_duplicado; // Mensaje personalizado
        echo json_encode($response);
        exit;
    }

    // 3. INSERTAR EL PAGO SI NO HAY DUPLICADOS
    $sql = "INSERT INTO pagos (alumno_id, concepto, mes_pagado, anio_pagado, monto) 
            VALUES ('$alumno_id', '$concepto', '$mes_pagado', '$anio_pagado', '$monto')";

    if (mysqli_query($conexion, $sql)) {
        // Recuperamos el ID recién creado para imprimir el recibo
        $id_recibo = mysqli_insert_id($conexion);

        $response['estado'] = 'exito';
        $response['mensaje'] = 'Pago registrado correctamente.';
        $response['id_recibo'] = $id_recibo; // Enviamos el ID al JS para imprimir
    } else {
        $response['estado'] = 'error';
        $response['mensaje'] = 'Error en base de datos: ' . mysqli_error($conexion);
    }

} else {
    $response['estado'] = 'error';
    $response['mensaje'] = 'Faltan datos obligatorios (ID o Monto).';
}

// FINAL: Devolvemos JSON
header('Content-Type: application/json');
echo json_encode($response);
?>