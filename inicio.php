<?php
session_start();
include('config/conexion.php');

// Seguridad: Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) { header("location: index.php"); exit; }

// --- CONSULTAS DASHBOARD ---
// 1. Alumnos Activos
$sql_alumnos = "SELECT COUNT(*) as total FROM alumnos WHERE estado = 1";
$res_alumnos = mysqli_query($conexion, $sql_alumnos);
$total_alumnos = mysqli_fetch_assoc($res_alumnos)['total'];

// 2. Cobrado Hoy (Suma de montos del día actual)
$sql_caja = "SELECT SUM(monto) as total_dia FROM pagos WHERE DATE(fecha_pago) = CURDATE()";
$res_caja = mysqli_query($conexion, $sql_caja);
$total_caja = mysqli_fetch_assoc($res_caja)['total_dia'] ?? 0;

// Variables para el header y sidebar
$pagina = 'inicio';
$titulo_pagina = 'Resumen General';

include('layout/header.php');
include('layout/sidebar.php');
?>

<div class="row g-4">
    <div class="col-md-6">
        <a href="alumnos.php" class="card card-pro card-azul shadow-lg h-100">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75 small mb-2">Alumnos Activos</h6>
                        <h2 class="display-3 fw-bold mb-0"><?php echo $total_alumnos; ?></h2>
                        <div class="mt-3">
                            <span class="small opacity-75"><i class="fas fa-eye me-1"></i> Ver listado completo</span>
                        </div>
                    </div>
                </div>
                <div class="icon-bg-overlay">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6">
        <a href="reporte_diario.php" class="card card-pro card-verde shadow-lg h-100">
            <div class="card-body p-4 position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75 small mb-2">Reporte del día</h6>
                        <h2 class="display-3 fw-bold mb-0">Q.<?php echo number_format($total_caja, 2); ?></h2>
                        <div class="mt-3">
                            <span class="small opacity-75"><i class="fas fa-receipt me-1"></i> Ver detalle de hoy</span>
                        </div>
                    </div>
                </div>
                <div class="icon-bg-overlay">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="welcome-box shadow-sm text-center">
            <div class="mb-4">
                <i class="fas fa-desktop fa-4x text-primary opacity-25"></i>
            </div>
            <h1 class="display-4 fw-bold text-dark mb-3">
                ¡Bienvenido, <?php echo $_SESSION['usuario']; ?>!
            </h1>
            <p class="lead text-muted mx-auto mb-4" style="max-width: 800px;">
                Estás en el centro de control de <strong>Amanecer Científico</strong>. 
                Desde aquí puedes monitorear rápidamente el estado de la academia y navegar a las funciones principales.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <span class="badge badge-premium text-primary">
                    <i class="fas fa-graduation-cap me-2"></i> Ciclo Escolar 2026
                </span>
                <span class="badge badge-premium text-success">
                    <i class="fas fa-calendar-alt me-2"></i> <?php echo date("d/m/Y"); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>