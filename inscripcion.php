<?php
session_start();
include('config/conexion.php');

// Verificación de seguridad
if (!isset($_SESSION['usuario'])) { header("location: index.php"); exit; }

// Variables para el header dinámico
$pagina = 'inscripcion';
$titulo_pagina = 'Nueva Inscripción';

include('layout/header.php');
include('layout/sidebar.php');
?>

<div class="form-card shadow-lg">
    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
        <div class="bg-primary text-white rounded-circle p-3 me-3">
            <i class="fas fa-user-plus fa-lg"></i>
        </div>
        <div>
            <h4 class="m-0 fw-bold text-dark">Registro de Nuevo Alumno</h4>
            <p class="text-muted small m-0">Complete todos los campos para formalizar la inscripción.</p>
        </div>
    </div>

    <form action="php/guardar_alumno.php" method="POST" autocomplete="off">
        <div class="row g-4">
            
            <div class="col-12">
                <div class="section-divider">
                    <i class="fas fa-id-card me-2"></i> Identificación del Alumno
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label-custom text-primary">Código Personal</label>
                <input type="text" name="codigo_personal" class="form-control form-control-custom" placeholder="Ej. A-123-XYZ">
                <small class="text-muted" style="font-size: 10px;">Opcional: Dejar en blanco si no posee.</small>
            </div>

            <div class="col-md-4">
                <label class="form-label-custom">Nombres</label>
                <input type="text" name="nombres" class="form-control form-control-custom" placeholder="Nombres completos" required>
            </div>

            <div class="col-md-4">
                <label class="form-label-custom">Apellidos</label>
                <input type="text" name="apellidos" class="form-control form-control-custom" placeholder="Apellidos completos" required>
            </div>

            <div class="col-md-8">
                <label class="form-label-custom">Dirección de Domicilio</label>
                <input type="text" name="direccion" class="form-control form-control-custom" placeholder="Aldea, Calle, Número de Casa...">
            </div>

            <div class="col-md-4">
                <label class="form-label-custom">Teléfono del Alumno</label>
                <input type="text" name="telefono" class="form-control form-control-custom" placeholder="0000-0000">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Grado Académico Actual</label>
                <select name="grado" class="form-select form-control-custom">
                    <option value="">Seleccione...</option>
                    <option value="1ro Básico">1ro Básico</option>
                    <option value="2do Básico">2do Básico</option>
                    <option value="3ro Básico">3ro Básico</option>
                    <option value="4to Bachillerato">4to Bachillerato</option>
                    <option value="5to Bachillerato">5to Bachillerato</option>
                    <option value="6to Bachillerato">6to Bachillerato</option>
                    <option value="Universitario">Universitario</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Establecimiento / Escuela</label>
                <input type="text" name="establecimiento" class="form-control form-control-custom" placeholder="Nombre del centro de estudios">
            </div>

            <div class="col-12 mt-4">
                <div class="section-divider">
                    <i class="fas fa-user-shield me-2"></i> Datos del Encargado
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label-custom">Nombre del Encargado</label>
                <input type="text" name="encargado_nombre" class="form-control form-control-custom" placeholder="Padre, Madre o Tutor">
            </div>

            <div class="col-md-6">
                <label class="form-label-custom">Teléfono del Encargado</label>
                <input type="text" name="encargado_telefono" class="form-control form-control-custom" placeholder="0000-0000">
            </div>

            <div class="col-12 mt-4">
                <div class="section-divider">
                    <i class="fas fa-graduation-cap me-2"></i> Información del Curso en Academia
                </div>
            </div>
            
            <div class="col-md-12">
                <label class="form-label-custom">Curso a Inscribir</label>
                <select name="curso_id" class="form-select form-control-custom">
                    <option value="1">Computación Ciclo Básico</option>
                    <option value="2">Mecanografía</option>
                    <option value="3">Diplomado Técnico</option>
                </select>
            </div>

            <div class="col-12 mt-5 text-end">
                <hr class="opacity-10">
                <button type="reset" class="btn btn-light px-4 me-2 fw-bold text-muted" style="border-radius: 12px;">
                    <i class="fas fa-eraser me-2"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow" style="border-radius: 15px; font-weight: bold;">
                    <i class="fas fa-save me-2"></i> Guardar Inscripción
                </button>
            </div>

        </div>
    </form>
</div>

<?php include('layout/footer.php'); ?>