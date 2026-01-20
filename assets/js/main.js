/* === LÓGICA DE NAVEGACIÓN Y ALERTAS === */
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Marcar link activo en el Sidebar (Basado en la URL real)
    const currentPath = window.location.pathname.split("/").pop(); 
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // 2. Sistema de Alertas SweetAlert2 (Procesar mensajes de la URL)
    const urlParams = new URLSearchParams(window.location.search);
    const mensaje = urlParams.get('mensaje');

    if (mensaje) {
        let config = { timer: 3000, showConfirmButton: false };

        switch(mensaje) {
            case 'registrado':
                config.title = '¡Excelente!';
                config.text = 'El alumno ha sido inscrito correctamente.';
                config.icon = 'success';
                break;
            case 'actualizado':
                config.title = '¡Actualizado!';
                config.text = 'Los cambios se guardaron correctamente.';
                config.icon = 'success';
                break;
            case 'eliminado':
                config.title = '¡Eliminado!';
                config.text = 'El registro ha sido borrado.';
                config.icon = 'success';
                break;
            case 'activado':
                config.title = '¡Habilitado!';
                config.text = 'Alumno activado correctamente.';
                config.icon = 'success';
                break;
            case 'desactivado':
                config.title = '¡Deshabilitado!';
                config.text = 'Alumno desactivado correctamente.';
                config.icon = 'info';
                break;
            case 'error':
                config.title = 'Error';
                config.text = 'Hubo un problema al procesar la solicitud.';
                config.icon = 'error';
                break;
        }

        if (config.title) {
            Swal.fire(config);
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
});

/* === SEGURIDAD Y CONTROL DE HISTORIAL === */
function inicializarSeguridad() {
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };

    if (window.performance && window.performance.navigation.type === 2) {
        location.reload(true);
    }
}
document.addEventListener("DOMContentLoaded", inicializarSeguridad);

/* === GESTIÓN DE ALUMNOS (alumnos.php) === */

function filtrarTabla() {
    const input = document.getElementById("buscadorAlumnos");
    const filtro = input.value.toUpperCase();
    const filas = document.querySelector("table tbody").getElementsByTagName("tr");

    for (let i = 0; i < filas.length; i++) {
        const texto = filas[i].innerText.toUpperCase();
        filas[i].style.display = texto.indexOf(filtro) > -1 ? "" : "none";
    }
}

function confirmarBorrado(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará al alumno y sus pagos permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "php/borrar_alumno.php?id=" + id;
        }
    });
}

function verDetalles(idAlumno) {
    let datos = new FormData();
    datos.append('id_para_buscar', idAlumno);
    
    fetch('php/buscar_alumno_modal.php', { method: 'POST', body: datos })
    .then(r => r.json())
    .then(alumno => {
         document.getElementById('ver_id').textContent = '#' + alumno.id;
         document.getElementById('ver_codigo').textContent = alumno.codigo_personal || 'No asignado';
         document.getElementById('ver_nombre').textContent = alumno.nombres + ' ' + alumno.apellidos;
         document.getElementById('ver_telefono').textContent = alumno.telefono_alumno;
         document.getElementById('ver_direccion').textContent = alumno.direccion;
         document.getElementById('ver_grado').textContent = alumno.grado_academico || 'No registrado';
         document.getElementById('ver_establecimiento').textContent = alumno.establecimiento_procedencia || 'No registrado';
         document.getElementById('ver_encargado').textContent = alumno.encargado_nombre;
         document.getElementById('ver_tel_encargado').textContent = alumno.encargado_telefono || 'No registrado';
         
         let cursoNombre = (alumno.curso_id == 1) ? "Computación" : (alumno.curso_id == 2 ? "Mecanografía" : "Diplomado");
         document.getElementById('ver_curso').textContent = cursoNombre;
         
         const modal = new bootstrap.Modal(document.getElementById('modalVerDetalles'));
         modal.show();
    });
}

/* === MÓDULO DE CAJA Y RECIBOS === */

document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('formPago')) {
        const hoy = new Date().toLocaleDateString('es-GT');
        document.querySelectorAll('.fechaHoy').forEach(el => el.textContent = hoy);
        const inputNombre = document.getElementById('inputNombre');
        if (inputNombre) setTimeout(() => inputNombre.focus(), 300);
    }
});

function calcularMontoAutomatico() {
    const concepto = document.getElementById('inputConcepto').value;
    const cursoId = document.getElementById('alumno_curso_id').value;
    let montoSugerido = 0;

    if (concepto === "Inscripción") {
        montoSugerido = 50;
    } else if (concepto === "Mensualidad") {
        montoSugerido = (cursoId == "3") ? 80 : 50;
    } else if (concepto === "Pago de Papelería") {
        montoSugerido = 250;
    }

    document.getElementById('inputMonto').value = montoSugerido.toFixed(2);
    actualizarRecibo();
}

function actualizarRecibo() {
    const nombre = document.getElementById('inputNombre').value || "_________________";
    const concepto = document.getElementById('inputConcepto').value;
    const mes = document.getElementById('inputMes').value;
    const monto = parseFloat(document.getElementById('inputMonto').value || 0).toFixed(2);

    document.querySelectorAll('.dato-nombre').forEach(el => el.textContent = nombre);
    document.querySelectorAll('.dato-concepto').forEach(el => el.textContent = concepto);
    document.querySelectorAll('.dato-mes').forEach(el => {
        el.textContent = (concepto === 'Mensualidad') ? "- " + mes : '';
    });
    document.querySelectorAll('.dato-monto').forEach(el => el.textContent = monto);
    document.querySelectorAll('.dato-monto-texto').forEach(el => el.textContent = "Q. " + monto);
}

function buscarAlumno() {
    let texto = document.getElementById('inputNombre').value;
    let lista = document.getElementById('listaResultados');
    if (texto.length > 0) {
        let datos = new FormData();
        datos.append("campo", texto);
        fetch('php/buscar_alumno_caja.php', { method: 'POST', body: datos })
        .then(res => res.text())
        .then(html => {
            lista.innerHTML = html;
            lista.style.display = 'block';
        });
    } else {
        lista.style.display = 'none';
    }
    actualizarRecibo();
}

/* FUNCIÓN MULTIUSO: Caja y Tarjeta */
function seleccionarAlumno(id, nombre, cursoId) {
    // CASO 1: Estamos en Caja y Recibos
    if (document.getElementById('alumno_id')) {
        document.getElementById('inputNombre').value = nombre;
        document.getElementById('alumno_id').value = id; 
        document.getElementById('alumno_curso_id').value = cursoId; 
        document.getElementById('listaResultados').style.display = 'none';
        
        calcularMontoAutomatico(); 
        actualizarRecibo(); // Actualiza el nombre en el recibo inmediatamente
        document.getElementById('inputConcepto').focus();
    } 
    // CASO 2: Estamos en Tarjeta de Pagos
    else if (document.getElementById('contenedorTarjeta')) {
        document.getElementById('inputNombre').value = nombre;
        document.getElementById('listaResultados').style.display = 'none';
        
        if(document.getElementById('btnImprimirArea')) {
            document.getElementById('btnImprimirArea').style.display = 'block';
        }

        let contenedor = document.getElementById('contenedorTarjeta');
        contenedor.innerHTML = `
            <div class="text-center p-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Consultando historial con el servidor...</p>
            </div>`;

        fetch('php/generar_tarjeta_visual.php?id_alumno=' + id)
            .then(r => r.text())
            .then(html => {
                contenedor.innerHTML = html;
            })
            .catch(error => {
                contenedor.innerHTML = '<div class="alert alert-danger">Error al cargar la tarjeta.</div>';
            });
    }
}

function guardarPago() {
    const id = document.getElementById('alumno_id').value;
    const nombre = document.getElementById('inputNombre').value;
    const monto = document.getElementById('inputMonto').value;

    if(!id) return Swal.fire("Atención", "Selecciona un alumno de la lista.", "warning");

    Swal.fire({
        title: '¿Confirmar Cobro?',
        html: `Monto: <b>Q.${monto}</b><br>Alumno: <b>${nombre}</b>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Sí, Cobrar'
    }).then((result) => {
        if (result.isConfirmed) enviarPago(id);
    });
}

function enviarPago(id) {
    let datos = new FormData();
    datos.append("id_alumno", id);
    datos.append("concepto", document.getElementById('inputConcepto').value);
    datos.append("mes", document.getElementById('inputMes').value);
    datos.append("monto", document.getElementById('inputMonto').value);

    fetch('php/guardar_pago.php', { method: 'POST', body: datos })
    .then(res => res.json())
    .then(data => {
        if(data.estado === "exito") {
            let num = data.id_recibo.toString().padStart(4, '0');
            document.querySelectorAll('.dato-recibo').forEach(el => el.textContent = num);
            Swal.fire({
                title: "¡Pago Registrado!",
                text: "Recibo No. " + num,
                icon: "success",
                showCancelButton: true,
                confirmButtonText: 'Imprimir',
                cancelButtonText: 'Cerrar'
            }).then((res) => {
                if (res.isConfirmed) imprimirReciboFinal(); else location.reload();
            });
        } else {
            Swal.fire("Atención", data.mensaje, "warning");
        }
    });
}

function imprimirReciboFinal() {
    const num = document.querySelector('.dato-recibo').textContent;
    const contenido = document.getElementById('area-impresion').innerHTML;
    
    const carpetaActual = window.location.pathname.split("/").slice(-2, -1)[0];
    const rutaCSS = (carpetaActual === 'php') ? '../assets/css/style.css' : 'assets/css/style.css';

    const win = window.open('', '', 'height=600,width=800');
    win.document.write(`
        <html>
            <head>
                <title>Recibo_${num}</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <link href="${rutaCSS}" rel="stylesheet">
            </head>
            <body>${contenido}</body>
        </html>
    `);
    win.document.close();
    win.onload = function() { win.print(); win.close(); location.reload(); };
}

/* === MÓDULO TARJETA DE PAGOS === */

function buscarAlumnoTarjeta() {
    let texto = document.getElementById('inputNombre').value;
    let lista = document.getElementById('listaResultados');

    if (texto.length > 0) {
        let datos = new FormData();
        datos.append("campo", texto);
        fetch('php/buscar_alumno_caja.php', { method: 'POST', body: datos })
        .then(r => r.text())
        .then(html => {
            lista.innerHTML = html;
            lista.style.display = 'block';
        });
    } else {
        lista.style.display = 'none';
    }
}

function limpiarBuscador() {
    document.getElementById('inputNombre').value = "";
    document.getElementById('listaResultados').style.display = 'none';
    document.getElementById('btnImprimirArea').style.display = 'none';
    document.getElementById('contenedorTarjeta').innerHTML = `
        <div class="text-center text-muted p-5 bg-white rounded shadow-sm" style="border-radius: 20px;">
            <i class="fas fa-id-card fa-4x mb-3 text-light opacity-50"></i>
            <h4 class="fw-bold">Consulta de Pagos 2026</h4>
            <p>Busca un alumno arriba para ver sus meses pagados y pendientes.</p>
        </div>`;
    document.getElementById('inputNombre').focus();
}

function reimprimirRecibo(id) {
    window.open('caja_y_recibo.php?reimprimir=' + id, 'PRINT', 'height=600,width=800');
}

/* FECHA AUTOMÁTICA UNIVERSAL */
document.addEventListener("DOMContentLoaded", function() {
    const elementosFecha = document.querySelectorAll('.fechaHoy');
    if (elementosFecha.length > 0) {
        const opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
        const hoy = new Date().toLocaleDateString('es-GT', opciones);
        elementosFecha.forEach(el => {
            el.innerText = hoy;
        });
    }
});