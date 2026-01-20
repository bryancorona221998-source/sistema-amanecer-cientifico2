<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if (isset($_SESSION['usuario'])) { header("location: inicio.php"); exit; }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Amanecer Científico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="login-body">

    <div class="login-card">
        <div class="icon-circle">
            <i class="fas fa-user-shield fa-2x"></i>
        </div>

        <h4 class="fw-bold mb-1" style="color: #003B73;">Control de Acceso</h4>
        <p class="text-muted mb-4 small text-uppercase" style="letter-spacing: 1.5px; font-size: 10px;">Amanecer Científico</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 small border-0 mb-3" style="border-radius: 12px; font-size: 11px;">
                <i class="fas fa-times-circle me-1"></i> Credenciales inválidas
            </div>
        <?php endif; ?>

        <form action="php/validar_login.php" method="POST" autocomplete="off">
            <div class="mb-3 text-start">
                <label class="form-label fw-bold text-muted text-uppercase">Usuario</label>
                <input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario" required>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold text-muted text-uppercase">Contraseña</label>
                <div class="password-container">
                    <input type="password" name="clave" id="inputClave" class="form-control" placeholder="••••••••" required>
                    <button type="button" id="btnVer" class="toggle-password">
                        <i id="iconoOjo" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login text-uppercase">
                Entrar <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
        </form>

        <div class="mt-4">
            <small class="text-muted" style="font-size: 9px; letter-spacing: 2px;">Academia de Computación Amanecer Científico</small>
        </div>
    </div>

    <script>
        const btnVer = document.getElementById('btnVer');
        const inputClave = document.getElementById('inputClave');
        const iconoOjo = document.getElementById('iconoOjo');

        btnVer.addEventListener('click', function() {
            const isPassword = inputClave.type === "password";
            inputClave.type = isPassword ? "text" : "password";
            iconoOjo.classList.toggle('fa-eye');
            iconoOjo.classList.toggle('fa-eye-slash');
        });

        if (window.location.search.includes('error')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>