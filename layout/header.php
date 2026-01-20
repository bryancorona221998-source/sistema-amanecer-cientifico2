<?php
// Evitar que el navegador guarde copias viejas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Amanecer Científico</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <?php
        // Ajuste de rutas dinámicas para CSS y Logo
        $carpeta_actual = basename(dirname($_SERVER['PHP_SELF']));
        $ruta_base = ($carpeta_actual == 'php') ? '../' : '';
    ?>
    
    <link rel="stylesheet" href="<?php echo $ruta_base; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="<?php echo $ruta_base; ?>assets/img/logo.png">
    
    </head>
<body>