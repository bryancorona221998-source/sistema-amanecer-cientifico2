<?php
session_start();
include('config/conexion.php');
if (!isset($_SESSION['usuario'])) { header("location: index.php"); exit; }

// Consulta de alumnos: Orden ASC para que el primer inscrito aparezca arriba
$sql_lista = "SELECT * FROM alumnos ORDER BY id ASC";
$resultado_lista = mysqli_query($conexion, $sql_lista);

$pagina = 'alumnos';
$titulo_pagina = 'Gestión de Alumnos';

include('layout/header.php');
include('layout/sidebar.php');
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold"><i class="fas fa-users-cog"></i> Alumnos</h5>
        <div class="d-flex gap-2">
            <a href="php/lista_asistencia.php" target="_blank" class="btn btn-outline-dark btn-sm">
                <i class="fas fa-print"></i> Imprimir Asistencia
            </a>
            <a href="inscripcion.php" class="btn btn-primary btn-sm px-3 fw-bold">
                <i class="fas fa-plus"></i> Nueva Inscripción
            </a>
        </div>
    </div>

    <div class="p-3 bg-light border-bottom">
        <div class="input-group">
            <span class="input-group-text bg-white text-muted border-end-0"><i class="fas fa-search"></i></span>
            <input type="text" id="buscadorAlumnos" class="form-control border-start-0 ps-0" placeholder="Buscar por nombre o código..." onkeyup="filtrarTabla()" autofocus>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-custom table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width: 70px;">No.</th> 
                    <th>Código</th> 
                    <th>Alumno</th>
                    <th>Encargado</th>
                    <th>Curso</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $correlativo = 1; 
                if (mysqli_num_rows($resultado_lista) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado_lista)) { 
                        // Lógica de visualización rápida en tabla
                        $nombre_curso = ($fila['curso_id'] == 1) ? "Computación" : (($fila['curso_id'] == 2) ? "Mecanografía" : "Diplomado");
                        $clase_fila = ($fila['estado'] == 0) ? 'table-secondary text-muted' : '';
                        $badge_clase = ($fila['estado'] == 1) ? 'badge-activo-solid' : 'badge bg-secondary';
                        $badge_texto = ($fila['estado'] == 1) ? 'Activo' : 'Baja';
                        $btn_bg_estado = ($fila['estado'] == 1) ? 'bg-secondary' : 'bg-success';
                        $btn_icono_estado = ($fila['estado'] == 1) ? 'fa-power-off' : 'fa-toggle-on';
                    ?>
                    <tr class="<?php echo $clase_fila; ?>">
                        <td class="ps-4 fw-bold text-primary"><?php echo $correlativo++; ?></td>
                        <td class="fw-bold text-secondary"><?php echo $fila['codigo_personal'] ?: '<small class="text-muted">---</small>'; ?></td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center pe-3">
                                <div>
                                    <strong class="text-dark"><?php echo $fila['nombres'] . " " . $fila['apellidos']; ?></strong><br>
                                    <small class="text-muted"><i class="fas fa-mobile-alt me-1"></i><?php echo $fila['telefono_alumno']; ?></small>
                                </div>
                                <span class="<?php echo $badge_clase; ?> shadow-sm"><?php echo $badge_texto; ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold text-dark"><?php echo $fila['encargado_nombre']; ?></div>
                            <small class="text-muted"><i class="fas fa-phone-alt me-1"></i><?php echo $fila['encargado_telefono']; ?></small>
                        </td>
                        <td><span class="badge-curso-azul"><?php echo $nombre_curso; ?></span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn-circle-opt bg-ficha" onclick="verDetalles(<?php echo $fila['id']; ?>)" title="Ver Ficha"><i class="fas fa-id-card"></i></button>
                                
                                <a href="php/cambiar_estado.php?id=<?php echo $fila['id']; ?>&estado=<?php echo $fila['estado']; ?>" class="btn-circle-opt <?php echo $btn_bg_estado; ?>" title="Cambiar Estado"><i class="fas <?php echo $btn_icono_estado; ?>"></i></a>
                                
                                <a href="php/editar_alumno.php?id=<?php echo $fila['id']; ?>" class="btn-circle-opt bg-warning" title="Editar"><i class="fas fa-pen"></i></a>
                                
                                <button type="button" onclick="confirmarBorrado(<?php echo $fila['id']; ?>)" class="btn-circle-opt bg-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalVerDetalles" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold"><i class="fas fa-user-graduate me-2"></i> Ficha del Alumno</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                <strong>ID de Registro:</strong> 
                <span id="ver_id" class="badge bg-dark rounded-pill"></span>
            </li>
            <li class="list-group-item"><strong><i class="fas fa-id-card me-1"></i> Código Personal:</strong> <span id="ver_codigo" class="text-primary fw-bold"></span></li>
            
            <li class="list-group-item"><strong>Nombre:</strong> <span id="ver_nombre" class="text-secondary"></span></li>
            <li class="list-group-item"><strong>Teléfono Alumno:</strong> <span id="ver_telefono" class="text-secondary"></span></li>
            <li class="list-group-item"><strong>Dirección:</strong> <span id="ver_direccion" class="text-secondary"></span></li>
            <li class="list-group-item"><strong>Grado:</strong> <span id="ver_grado" class="text-secondary"></span></li>
            <li class="list-group-item"><strong>Establecimiento:</strong> <span id="ver_establecimiento" class="text-secondary"></span></li>
            
            <li class="list-group-item bg-light text-primary"><strong><i class="fas fa-book me-1"></i> Curso Inscrito:</strong> <span id="ver_curso" class="fw-bold"></span></li>
            
            <li class="list-group-item bg-light"><strong>Encargado:</strong> <span id="ver_encargado" class="text-dark fw-bold"></span></li>
            <li class="list-group-item"><strong>Teléfono Encargado:</strong> <span id="ver_tel_encargado" class="text-secondary"></span></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php include('layout/footer.php'); ?>