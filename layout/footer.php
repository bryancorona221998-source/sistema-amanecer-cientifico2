</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php
        // Obtenemos el nombre de la carpeta donde está el archivo actual
        $carpeta_actual = basename(dirname($_SERVER['PHP_SELF']));
        
        // Si la carpeta es 'php', retrocedemos un nivel, si no, estamos en la raíz
        $url_base_js = ($carpeta_actual == 'php') ? '../' : '';
    ?>

    <script src="<?php echo $url_base_js; ?>assets/js/main.js"></script>

</body>
</html>