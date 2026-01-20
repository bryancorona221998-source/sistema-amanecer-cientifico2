<?php
session_start();
include('config/conexion.php');
if (!isset($_SESSION['usuario'])) { header("location: index.php"); exit; }

$pagina = 'tarjeta';
$titulo_pagina = 'Estado de Cuenta';

include('layout/header.php');
include('layout/sidebar.php');
?>

<div class="card shadow-sm border-0 mb-4 no-print" style="border-radius: 15px; border-top: 6px solid #003B73;">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <label class="form-label fw-bold text-dark mb-2" style="font-size: 1.05rem;">
                    <i class="fas fa-search me-2 text-muted"></i> Consultar solvencia de alumno
                </label>
                <div class="input-group"> 
                    <input type="text" id="inputNombre" 
                           class="form-control form-control-buscar shadow-sm" 
                           placeholder="Escribe el nombre aquí..." 
                           onkeyup="buscarAlumnoTarjeta()" autofocus>
                    
                    <button class="btn btn-limpiar-azul ms-2 shadow-sm" type="button" onclick="limpiarBuscador()">
                        <i class="fas fa-eraser me-2"></i> LIMPIAR
                    </button>
                </div>
                <div id="listaResultados" class="list-group position-absolute w-100 shadow-lg" style="z-index: 1000; display: none;"></div>
            </div>
            
            <div class="col-md-4 text-end" id="btnImprimirArea" style="display:none;">
                <button class="btn btn-dark btn-lg px-4 fw-bold shadow" style="border-radius: 12px;" onclick="window.print()">
                    <i class="fas fa-print me-2"></i> IMPRIMIR
                </button>
            </div>
        </div>
    </div>
</div>

<div id="contenedorTarjeta">
    <div class="text-center text-muted p-5 bg-white rounded-4 shadow-sm no-print" style="border-radius: 20px;">
        <i class="fas fa-id-card fa-4x mb-3 text-light opacity-50"></i>
        <h4 class="fw-bold">Consulta de Pagos 2026</h4>
        <p>Selecciona un alumno para verificar sus pagos mensuales.</p>
    </div>
</div>

<?php include('layout/footer.php'); ?>