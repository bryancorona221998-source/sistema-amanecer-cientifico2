<?php
// Detectamos si estamos en la carpeta 'php' para ajustar las rutas
$directorio_actual = basename(dirname($_SERVER['PHP_SELF']));
$ruta_base = ($directorio_actual == 'php') ? '../' : '';
?>

<div class="sidebar d-flex flex-column" style="height: 100vh;"> 
    <div class="sidebar-header text-center py-4">
        <div class="mb-3 d-flex justify-content-center">
            <div style="width: 110px; height: 110px; overflow: hidden; border-radius: 50%; border: 4px solid rgba(255,255,255,0.2); box-shadow: 0 4px 10px rgba(0,0,0,0.3); background-color: white;">
                <img src="<?php echo $ruta_base; ?>assets/img/logo.png" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <h4 class="fw-bold mb-0 text-white" style="letter-spacing: 1px;">AMANECER</h4>
        <h4 class="fw-bold text-white" style="letter-spacing: 1px;">CIENTÍFICO</h4>
        <small class="text-white-50" style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Sistema de Control</small>
    </div>
    
    <ul class="nav flex-column mt-2 flex-grow-1">
        <li class="nav-item">
            <a href="<?php echo $ruta_base; ?>inicio.php" class="nav-link <?php echo ($pagina == 'inicio') ? 'active' : ''; ?>">
                <i class="fas fa-chart-pie me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $ruta_base; ?>alumnos.php" class="nav-link <?php echo ($pagina == 'alumnos') ? 'active' : ''; ?>">
                <i class="fas fa-users me-2"></i> Alumnos
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $ruta_base; ?>inscripcion.php" class="nav-link <?php echo ($pagina == 'inscripcion') ? 'active' : ''; ?>">
                <i class="fas fa-user-plus me-2"></i> Inscripción
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $ruta_base; ?>caja_y_recibo.php" class="nav-link <?php echo ($pagina == 'caja') ? 'active' : ''; ?>">
                <i class="fas fa-file-invoice-dollar me-2"></i> Caja y Recibos
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $ruta_base; ?>tarjeta_de_pago.php" class="nav-link <?php echo ($pagina == 'tarjeta') ? 'active' : ''; ?>">
                <i class="fas fa-id-card me-2"></i> Tarjeta de Pagos
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $ruta_base; ?>reporte_diario.php" class="nav-link <?php echo ($pagina == 'reporte') ? 'active' : ''; ?>">
                <i class="fas fa-chart-line me-2"></i> Reporte del Día
            </a>
        </li>
    </ul>

    <div class="p-3 border-top border-secondary border-opacity-25 mt-auto">
            <a href="<?php echo $ruta_base; ?>logout.php" class="nav-link logout-link d-flex align-items-center justify-content-start">
                <i class="fas fa-power-off me-3 text-white"></i>
                <span class="text-white fw-bold" style="white-space: nowrap; font-size: 0.85rem;">CERRAR SISTEMA</span>
            </a>
        </div>
    </div>

    <style>
    /* Estilos para el Sidebar y Botón de Salida */
    .logout-link { 
        opacity: 0.9; 
        transition: all 0.3s ease !important; 
        padding: 12px 15px; 
        text-decoration: none !important; 
        border-radius: 10px;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .logout-link:hover { 
        background-color: #D92525 !important; 
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(217, 37, 37, 0.3);
    }

    .logout-link:hover i, 
    .logout-link:hover span {
        color: white !important;
    }

    /* Ajuste de scroll para laptops */
    .sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-y: auto;
    }
    .sidebar::-webkit-scrollbar { width: 5px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    </style>
<div class="main-content">
    <div class="top-bar shadow-sm px-4">
        <h4 class="m-0 fw-bold text-dark opacity-75">
            <?php echo isset($titulo_pagina) ? $titulo_pagina : 'Panel Principal'; ?>
        </h4>
        <div class="d-flex align-items-center">
            <div class="text-end me-3">
                <span class="fw-bold d-block text-primary" style="font-size: 0.9rem; line-height: 1;">
                    <?php echo $_SESSION['usuario'] ?? 'Admin'; ?>
                </span>
                <small class="text-muted" style="font-size: 0.75rem;">Sesión Activa</small> 
            </div>
            <div class="bg-light p-1 rounded-circle border shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user-circle text-primary" style="font-size: 1.8rem;"></i>
            </div>
        </div>
    </div>
    <div class="p-4">