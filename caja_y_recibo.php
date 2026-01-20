<?php
session_start();
include('config/conexion.php');

// Seguridad
if (!isset($_SESSION['usuario'])) { header("location: index.php"); exit; }

// Configuración del Header
$pagina = 'caja';
$titulo_pagina = 'Caja y Recibos';

include('layout/header.php');
include('layout/sidebar.php');
?>

<div class="row">
    <div class="col-md-5" id="columna-formulario">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="m-0"><i class="fas fa-cash-register"></i> Registrar Pago</h5>
            </div>
            <div class="card-body">
                <form id="formPago">
                    <div class="mb-3 position-relative">
                        <label class="form-label fw-bold">Alumno</label>
                        <input type="hidden" id="alumno_id" name="alumno_id"> 
                        <input type="hidden" id="alumno_curso_id"> 
                        
                        <input type="text" id="inputNombre" class="form-control" placeholder="Escribe el nombre para buscar..." autocomplete="off" onkeyup="buscarAlumno()">
                        <div id="listaResultados" class="list-group position-absolute w-100 shadow" style="z-index: 1000; display: none;"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Concepto</label>
                        <select id="inputConcepto" class="form-select" onchange="calcularMontoAutomatico()">
                            <option value="Mensualidad">Mensualidad</option>
                            <option value="Inscripción">Inscripción</option>
                            <option value="Pago de Papelería">Pago de Papelería</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Mes a Pagar</label>
                            <select id="inputMes" class="form-select" onchange="actualizarRecibo()">
                                <option>Enero 2026</option>
                                <option>Febrero 2026</option>
                                <option>Marzo 2026</option>
                                <option>Abril 2026</option>
                                <option>Mayo 2026</option>
                                <option>Junio 2026</option>
                                <option>Julio 2026</option>
                                <option>Agosto 2026</option>
                                <option>Septiembre 2026</option>
                                <option>Octubre 2026</option>
                                <option>Noviembre 2026</option>
                                <option>Diciembre 2026</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Monto (Q)</label>
                            <input type="number" id="inputMonto" class="form-control" value="0.00" oninput="actualizarRecibo()">
                        </div>
                    </div>

                    <button type="button" class="btn btn-success w-100 py-3 fw-bold" onclick="guardarPago()">
                        <i class="fas fa-save"></i> GUARDAR Y GENERAR RECIBO
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <h6 class="text-center text-muted mb-2">Vista Previa de Impresión</h6>
        <div id="area-impresion">
            
            <?php for($i=1; $i<=2; $i++): 
                $tipo = ($i==1) ? "ORIGINAL" : "COPIA";
                $color = ($i==1) ? "primary" : "secondary";
            ?>
            <div class="recibo-box shadow-sm">
                <div class="row align-items-center mb-3">
                    <div class="col-2 text-center">
                        <img src="assets/img/logo.png" class="logo-recibo" alt="Logo">
                    </div>
                    <div class="col-7">
                        <h4 class="fw-bold m-0 text-<?php echo $color; ?>">AMANECER CIENTÍFICO</h4>
                        <p class="mb-0 text-muted" style="font-size: 11px; line-height: 1.3;">
                            Avenida Escuela, Barrio El Milagro,<br>
                            Chiquimulilla, Santa Rosa.<br>
                            <strong>Tel: 3945-6221</strong> </p>
                    </div>
                    <div class="col-3 text-end">
                        <span class="badge bg-<?php echo $color; ?> mb-1"><?php echo $tipo; ?></span>
                        <h5 class="text-danger fw-bold m-0">NO. <span class="dato-recibo">----</span></h5>
                        <small class="fw-bold fechaHoy">--/--/--</small>
                    </div>
                </div>
                
                <div class="border-top pt-2">
                    <p class="mb-1"><strong>Recibí de:</strong> <span class="dato-nombre text-uppercase fw-bold border-bottom d-inline-block" style="min-width: 70%;">...</span></p>
                    <p class="mb-2"><strong>La cantidad de:</strong> <span class="dato-monto-texto fw-bold">...</span></p>
                    
                    <table class="table table-bordered table-sm mt-2 mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Descripción</th>
                                <th width="120">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3">
                                    <span class="dato-concepto">Mensualidad</span> 
                                    <span class="dato-mes"></span>
                                </td>
                                <td class="text-end pe-3 fw-bold">Q. <span class="dato-monto">0.00</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="caja-firma">
                    <div class="linea-firma"></div>
                    <small class="fw-bold"><?php echo ($i==1) ? "Firma y Sello" : "Receptor"; ?></small>
                </div>
            </div>
            <?php if($i==1) echo '<div class="linea-corte"></div>'; ?>
            <?php endfor; ?>

        </div>
    </div>
</div>

<?php include('layout/footer.php'); ?>

