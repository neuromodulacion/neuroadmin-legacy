<?php /*
// Definir la ruta base para las inclusiones de archivos
$ruta = "../";

// Obtener la fecha actual en formato "YYYY-MM-DD"
$hoy = date("Y-m-d");

// Obtener la hora actual en formato "HH:MM:00"
$ahora = date("H:i:00"); 

// Obtener el año actual
$anio = date("Y");

// Definir el título de la página
$titulo = "Bienvenida al Sistema";

// Incluir la primera parte del header que contiene configuraciones iniciales
include($ruta.'header1.php');

// Incluir archivos CSS adicionales necesarios para el funcionamiento de la página
?>
    <!-- Estilos personalizados para la página de bienvenida -->
    <link href="<?php echo $ruta; ?>css/bienvenida.css" rel="stylesheet" />

<?php  
// Incluir la segunda parte del header que contiene la barra de navegación y el menú
include($ruta.'header2.php'); ?>

<!-- Inicio del contenido principal de la página -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Bienvenido al Sistema de Administración Integral de Terapias</h2>
        </div>
        <!-- Contenido principal de la página -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Resumen del Sistema</h2>
                    </div>
                    <div class="body">
                        <p>Este sistema te permite gestionar de manera integral las terapias, incluyendo el registro de sesiones, la gestión de pacientes, y el control de ingresos y egresos.</p>
                        <p>Desde esta plataforma, podrás acceder a los diferentes módulos a través del menú de navegación. Te recomendamos revisar las notificaciones pendientes para estar al tanto de las tareas que requieren tu atención.</p>
                        <p>Si necesitas ayuda, puedes acceder a la sección de soporte desde la barra lateral derecha.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
// Incluir la primera parte del footer que contiene scripts y configuraciones iniciales del pie de página
include($ruta.'footer1.php'); 
?>

<!-- Scripts adicionales necesarios para la funcionalidad de la página -->

<?php 
// Incluir la segunda parte del footer que finaliza la estructura del pie de página
include($ruta.'footer2.php'); 
*/?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Diagrama de Flujo del Menú</title>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <script>
        mermaid.initialize({startOnLoad:true});
    </script>
    <style>
        body { text-align: center; }
        .description {
            text-align: center;
            font-size: 20px;
            color: rgb(133, 86, 76);
            margin: 5rem;
        }
        .mermaid svg text { font-size: 16px !important; }
    </style>
</head>
<body>
    <div class="description">
        Este es un diagrama de flujo que muestra cómo el menú de la aplicación presenta opciones basadas en el rol de usuario.
    </div>
    <div class="mermaid">
        flowchart TD
            A[Inicio] --> B[Verifica Rol del Usuario]
            B --> C{Rol es SISTEMAS, ADMINISTRADOR o COORDINADOR}
            C -->|Sí| D[Mostrar Dashboard]
            C -->|No| E{Rol es SISTEMAS, ADMINISTRADOR o REPRESENTANTE}
            E -->|Sí| F[Mostrar CRM]
            E -->|No| G{Rol es SISTEMAS, ADMINISTRADOR o COORDINADOR}
            G -->|Sí| H[Mostrar Pacientes]
            G -->|No| I{Rol permite Reportes}
            I -->|Sí| J[Mostrar Reportes]
            J --> K{Acceso a Caja y Protocolos según el Rol}
            K --> L[Mostrar Caja y Protocolos]
            L --> M[Opciones adicionales para Página Web]
            M --> N[Fin]
    </div>
</body>
</html>
