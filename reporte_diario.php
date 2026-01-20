<?php
session_start();
include('config/conexion.php');

if (!isset($_SESSION['usuario'])) { header("location: index.php"); exit; }

$pagina = 'reporte';
$titulo_pagina = 'Corte de Caja Diario';

include('layout/header.php');
include('layout/sidebar.php');

$fecha_consulta = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

$sql = "SELECT p.*, a.nombres, a.apellidos, a.grado_academico 
        FROM pagos p 
        INNER JOIN alumnos a ON p.alumno_id = a.id 
        WHERE DATE(p.fecha_pago) = '$fecha_consulta' 
        ORDER BY p.id ASC";

$query = mysqli_query($conexion, $sql);
$total_dia = 0;
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center btn-no-print">
        <h5 class="m-0 text-primary fw-bold"><i class="fas fa-chart-line me-2"></i> Reporte de Ingresos</h5>
        <form class="d-flex gap-2" method="GET">
            <input type="date" name="fecha" class="form-control form-control-custom" value="<?php echo $fecha_consulta; ?>">
            <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm">Ver</button>
            <button type="button" class="btn btn-dark btn-sm px-3 shadow-sm" onclick="window.print()">Imprimir</button>
        </form>
    </div>

    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark mb-0">AMANECER CIENTÍFICO</h2>
            <h6 class="text-muted mt-1">Reporte de Caja: <?php echo date("d/m/Y", strtotime($fecha_consulta)); ?></h6>
        </div>

        <div class="table-responsive">
            <table class="table table-combinada align-middle">
                <thead>
                    <tr>
                        <th style="width: 12%;">No. Recibo</th>
                        <th style="width: 33%;">Alumno</th>
                        <th style="width: 15%;">Grado</th>
                        <th style="width: 25%;">Concepto</th>
                        <th style="width: 15%;" class="text-end">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($query) > 0): ?>
                        <?php while($fila = mysqli_fetch_array($query)): ?>
                            <?php $total_dia += $fila['monto']; ?>
                            <tr>
                                <td class="text-muted small">#<?php echo str_pad($fila['id'], 5, "0", STR_PAD_LEFT); ?></td>
                                <td class="text-suave"><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                <td><small class="badge bg-light text-secondary border fw-normal"><?php echo $fila['grado_academico']; ?></small></td>
                                <td>
                                    <?php echo $fila['concepto']; ?>
                                    <?php if($fila['concepto'] == 'Mensualidad' && !empty($fila['mes_pagado'])): ?>
                                        <span class="texto-mes">(<?php echo $fila['mes_pagado']; ?>)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-bold text-dark monto-celda">Q. <?php echo number_format($fila['monto'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center p-5 text-muted">No hay cobros registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="fila-cierre">
                        <td colspan="4" class="text-end fw-bold py-3 text-secondary">TOTAL RECAUDADO:</td>
                        <td class="text-end monto-celda texto-total-exito py-3">
                            Q. <?php echo number_format($total_dia, 2); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-5 text-center d-none d-print-block">
            <div class="row" style="margin-top: 40px;">
                <div class="col-6 offset-3">
                    <p class="mb-0">_________________________________</p>
                    <p class="small fw-bold">Firma de Recepción</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>