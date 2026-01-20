<?php
session_start();
include '../config/conexion.php';

// Seguridad
if (!isset($_SESSION['usuario'])) { header("location: ../index.php"); exit; }

// Obtener datos del alumno para llenar el formulario
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $sql = "SELECT * FROM alumnos WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    
    if (mysqli_num_rows($resultado) == 1) {
        $fila = mysqli_fetch_array($resultado);
        $codigo_personal = $fila['codigo_personal'];
        $nombres         = $fila['nombres'];
        $apellidos       = $fila['apellidos'];
        $direccion       = $fila['direccion'];
        $telefono        = $fila['telefono_alumno'];
        $grado           = $fila['grado_academico'];
        $establecimiento = $fila['establecimiento_procedencia'];
        $encargado       = $fila['encargado_nombre'];
        $tel_encargado   = $fila['encargado_telefono'];
        $curso_actual    = $fila['curso_id'];
    } else { header("Location: ../alumnos.php"); exit; }
}

// Procesar la actualización
if (isset($_POST['actualizar'])) {
    $id = $_GET['id'];
    $codigo_nuevo    = mysqli_real_escape_string($conexion, $_POST['codigo_personal']);
    $nombres_nuevos  = mysqli_real_escape_string($conexion, $_POST['nombres']);
    $apellidos_nuevos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $direccion_nueva = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $telefono_nuevo  = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $grado_nuevo     = mysqli_real_escape_string($conexion, $_POST['grado']);
    $establecimiento_nuevo = mysqli_real_escape_string($conexion, $_POST['establecimiento']);
    $encargado_nuevo = mysqli_real_escape_string($conexion, $_POST['encargado_nombre']);
    $tel_enc_nuevo   = mysqli_real_escape_string($conexion, $_POST['encargado_telefono']);
    $curso_nuevo     = mysqli_real_escape_string($conexion, $_POST['curso_id']);

    $query = "UPDATE alumnos SET 
              codigo_personal = '$codigo_nuevo', nombres = '$nombres_nuevos', 
              apellidos = '$apellidos_nuevos', direccion = '$direccion_nueva', 
              telefono_alumno = '$telefono_nuevo', grado_academico = '$grado_nuevo',
              establecimiento_procedencia = '$establecimiento_nuevo', encargado_nombre = '$encargado_nuevo', 
              encargado_telefono = '$tel_enc_nuevo', curso_id = '$curso_nuevo' 
              WHERE id = '$id'";
    
    if(mysqli_query($conexion, $query)) {
        header("Location: ../alumnos.php?mensaje=actualizado"); 
        exit;
    }
}

// Configuración de vista para el layout
$pagina = 'alumnos';
$titulo_pagina = 'Editar Expediente';

include '../layout/header.php';
include '../layout/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card-compact shadow-lg">
            <div class="edit-header-blue d-flex justify-content-between align-items-center p-4">
                <h4 class="fw-bold mb-0 text-white"><i class="fas fa-user-edit me-2"></i> EDITAR EXPEDIENTE</h4>
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold">ID: <?php echo $id; ?></span>
            </div>

            <div class="p-4">
                <form action="editar_alumno.php?id=<?php echo $id; ?>" method="POST">
                    <div class="row g-4">
                        
                        <div class="col-12">
                            <span class="section-divider-blue"><i class="fas fa-id-card me-2"></i> Identificación y Escuela</span>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom small">Código Personal</label>
                            <input type="text" name="codigo_personal" class="form-control-custom w-100" value="<?php echo $codigo_personal; ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom small">Establecimiento Procedencia</label>
                            <input type="text" name="establecimiento" class="form-control-custom w-100" value="<?php echo $establecimiento; ?>">
                        </div>

                        <div class="col-12">
                            <span class="section-divider-blue"><i class="fas fa-user me-2"></i> Datos del Estudiante</span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom small">Nombres</label>
                            <input type="text" name="nombres" class="form-control-custom w-100" value="<?php echo $nombres; ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom small">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control-custom w-100" value="<?php echo $apellidos; ?>" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label-custom small">Dirección Domiciliaria</label>
                            <input type="text" name="direccion" class="form-control-custom w-100" value="<?php echo $direccion; ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom small">Teléfono Alumno</label>
                            <input type="text" name="telefono" class="form-control-custom w-100" value="<?php echo $telefono; ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom small">Grado Académico</label>
                            <select name="grado" class="form-select form-control-custom w-100">
                                <option value="1ro Básico" <?php if($grado == '1ro Básico') echo 'selected'; ?>>1ro Básico</option>
                                <option value="2do Básico" <?php if($grado == '2do Básico') echo 'selected'; ?>>2do Básico</option>
                                <option value="3ro Básico" <?php if($grado == '3ro Básico') echo 'selected'; ?>>3ro Básico</option>
                                <option value="4to Bachillerato" <?php if($grado == '4to Bachillerato') echo 'selected'; ?>>4to Bachillerato</option>
                                <option value="5to Bachillerato" <?php if($grado == '5to Bachillerato') echo 'selected'; ?>>5to Bachillerato</option>
                                <option value="Universitario" <?php if($grado == 'Universitario') echo 'selected'; ?>>Universitario</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <span class="section-divider-blue"><i class="fas fa-user-shield me-2"></i> Información del Encargado</span>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label-custom small">Nombre del Encargado</label>
                            <input type="text" name="encargado_nombre" class="form-control-custom w-100" value="<?php echo $encargado; ?>">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label-custom small">Teléfono Encargado</label>
                            <input type="text" name="encargado_telefono" class="form-control-custom w-100" value="<?php echo $tel_encargado; ?>">
                        </div>

                        <div class="col-12">
                            <span class="section-divider-blue"><i class="fas fa-graduation-cap me-2"></i> Asignación de Curso</span>
                        </div>

                        <div class="col-md-12">
                            <select name="curso_id" class="form-select form-control-custom w-100">
                                <option value="1" <?php if($curso_actual == 1) echo 'selected'; ?>>Computación Ciclo Básico</option>
                                <option value="2" <?php if($curso_actual == 2) echo 'selected'; ?>>Mecanografía</option>
                                <option value="3" <?php if($curso_actual == 3) echo 'selected'; ?>>Diplomado Técnico</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-4 gap-3">
                            <a href="../alumnos.php" class="btn-cancelar-moderno text-decoration-none">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" name="actualizar" class="btn-actualizar-blue shadow-sm">
                                <i class="fas fa-save me-2"></i> GUARDAR CAMBIOS
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>