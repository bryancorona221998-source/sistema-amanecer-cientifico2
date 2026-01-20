<?php
session_start();
include('../config/conexion.php');

if (!isset($_SESSION['usuario'])) {
    header("location: ../index.php");
    exit;
}

// OJO: Seguimos ordenando por APELLIDO para que la lista tenga orden alfabético lógico,
// aunque visualmente mostraremos primero el nombre.
// En lista_asistencia.php, esto agrupa por escuela y luego ordena por nombre
$sql = "SELECT * FROM alumnos WHERE estado = 1 ORDER BY establecimiento_procedencia ASC, nombres ASC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/img/logo.png">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .encabezado-tabla { background-color: #f0f0f0 !important; font-weight: bold; }
        .salto-pagina { page-break-before: always; }
        .titulo-establecimiento { 
            background: #0d6efd; 
            color: white; 
            padding: 10px; 
            margin-top: 20px; 
            margin-bottom: 10px; 
            border-radius: 5px;
        }
        @media print {
            .no-print { display: none; }
            .titulo-establecimiento { background: #ccc !important; color: black !important; }
        }
    </style>
</head>
<body class="p-4">

    <div class="text-end mb-4 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-lg"><i class="fas fa-print"></i> IMPRIMIR AHORA</button>
    </div>

    <div class="text-center mb-4">
        <h2>AMANECER CIENTÍFICO</h2>
        <h4>Control de Asistencia</h4>
        <small>Generado el: <?php echo date('d/m/Y'); ?></small>
    </div>

    <?php
    $establecimiento_actual = "";
    $contador = 1;
    $primera_vez = true;

    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            
            $estab_alumno = $fila['establecimiento_procedencia'];
            if(empty($estab_alumno)) $estab_alumno = "PARTICULARES / OTROS";

            if ($estab_alumno != $establecimiento_actual) {
                
                if (!$primera_vez) {
                    echo "</tbody></table><div class='salto-pagina'></div>"; 
                }
                
                $establecimiento_actual = $estab_alumno;
                $primera_vez = false;
                $contador = 1; 
                ?>

                <div class="titulo-establecimiento">
                    <h4 class="m-0 text-uppercase"><?php echo $establecimiento_actual; ?></h4>
                </div>

                <table class="table table-bordered table-sm border-dark">
                    <thead class="encabezado-tabla text-center">
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 35%;">Nombre del Alumno</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                            <th>_____</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
            }
            ?>
                <tr>
                    <td class="text-center"><?php echo $contador++; ?></td>
                    <td>
                        <strong><?php echo $fila['nombres'] . " " . $fila['apellidos']; ?></strong>
                    </td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            <?php
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No hay alumnos activos para mostrar.</div>";
    }
    ?>

</body>
</html>