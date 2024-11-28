<?php
// Función para validar roles
function usuarioTieneRol(array $rolesPermitidos, string $funcionUsuario): bool {
    return in_array($funcionUsuario, $rolesPermitidos, true);
}

// Función para verificar URL activa
function esUrlActiva(string $ubicacion_url, array $urlsPermitidas): string {
    return in_array($ubicacion_url, $urlsPermitidas, true) ? 'active' : '';
}

// Función para sanitizar rutas y URLs
function obtenerRutaSegura(string $ruta): string {
    return htmlspecialchars($ruta, ENT_QUOTES, 'UTF-8');
}

// Variables de ejemplo para pruebas
$ubicacion_url = $_SERVER['PHP_SELF']; // Ejemplo de URL actual
$funcion = 'SISTEMAS';                 // Rol actual del usuario
$ruta = '/app/';                       // Ruta base
?>

<!-- Menu principal de navegación -->
<div class="menu">
    <ul class="list">
        <!-- Encabezado del menú -->
        <li class="header">Menú de Navegación</li>

        <!-- Elemento del menú: Inicio -->
        <li class="<?php echo esUrlActiva($ubicacion_url, [$ruta . 'menu.php']); ?>">
            <a href="<?php echo obtenerRutaSegura($ruta . 'menu.php'); ?>">
                <i class="material-icons">home</i>
                <span>Inicio</span>
            </a>
        </li>

        <!-- Elemento del menú: Dashboard -->
        <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR'], $funcion)) { ?>
            <li class="<?php echo esUrlActiva($ubicacion_url, [$ruta . 'reporte/dashboard.php']); ?>">
                <a href="<?php echo obtenerRutaSegura($ruta . 'reporte/dashboard.php'); ?>">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>
        <?php } ?>

        <!-- Elemento del menú: CRM -->
        <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'REPRESENTANTE'], $funcion)) { ?>
            <li class="<?php echo esUrlActiva($ubicacion_url, [
                'reporte/referenciadores.php',
                'crm/medicos.php',
                'crm/registro_visitas.php',
                'crm/alta_medico.php'
            ]); ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">supervisor_account</i>
                    <span>CRM</span>
                </a>
                <ul class="ml-menu">
                    <!-- Submenú: Médicos Referenciadores -->
                    <li class="<?php echo esUrlActiva($ubicacion_url, [
                        'reporte/referenciadores.php',
                        'crm/medicos.php',
                        'crm/registro_visitas.php'
                    ]); ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">person</i>
                            <span>Médico Referenciador</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['reporte/referenciadores.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'reporte/referenciadores.php'); ?>">
                                    <i class="material-icons">assignment</i>
                                    <span>Reporte de Referenciadores</span>
                                </a>
                            </li>
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['crm/medicos.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'crm/medicos.php'); ?>">
                                    <i class="material-icons">person</i>
                                    <span>Medico Referenciador</span>
                                </a>
                            </li>
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['crm/registro_visitas.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'crm/registro_visitas.php'); ?>">
                                    <i class="material-icons">assignment</i>
                                    <span>Reporte Visitas Referenciador</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Submenú: Posible Referenciador -->
                    <li class="<?php echo esUrlActiva($ubicacion_url, [
                        'crm/alta_medico.php',
                        'crm/posible_referenciador.php',
                        'crm/registro_contacto.php',
                        'crm/contactos.php'
                    ]); ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">record_voice_over</i>
                            <span>Posible Referenciador</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['crm/alta_medico.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'crm/alta_medico.php'); ?>">
                                    <i class="material-icons">person_add</i>
                                    <span>Alta Posible Referenciador</span>
                                </a>
                            </li>
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['crm/posible_referenciador.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'crm/posible_referenciador.php'); ?>">
                                    <i class="material-icons">perm_identity</i>
                                    <span>Posible Referenciador</span>
                                </a>
                            </li>
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['crm/registro_contacto.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'crm/registro_contacto.php'); ?>">
                                    <i class="material-icons">assignment_add</i>
                                    <span>Registro Contacto</span>
                                </a>
                            </li>
                            <li class="<?php echo esUrlActiva($ubicacion_url, ['crm/contactos.php']); ?>">
                                <a href="<?php echo obtenerRutaSegura($ruta . 'crm/contactos.php'); ?>">
                                    <i class="material-icons">assignment</i>
                                    <span>Reporte Contacto</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <!-- Elemento del menú: Pacientes -->
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'paciente/alta.php',
            'paciente/pendientes.php',
            'paciente/seguimientos.php',
            'paciente/directorio.php',
            'agenda/agenda.php',
            'carta/cartas_generadas.php',
            'paciente/pacientes_consultas.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment_ind</i>
                <span>Pacientes</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['paciente/alta.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'paciente/alta.php'); ?>">
                        <i class="material-icons">person_add</i>
                        <span>Alta Paciente</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['paciente/pendientes.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'paciente/pendientes.php'); ?>">
                        <i class="material-icons">notifications</i>
                        <span>Pacientes Pendientes</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['paciente/seguimientos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'paciente/seguimientos.php'); ?>">
                        <i class="material-icons">notifications</i>
                        <span>Seguimientos</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['paciente/directorio.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'paciente/directorio.php'); ?>">
                        <i class="material-icons">book</i>
                        <span>Pacientes</span>
                    </a>
                </li>
            </ul>
        </li>
    <!-- Elemento del menú: Reportes -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'COORDINADOR ADMIN', 'REPRESENTANTE'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'reporte/protocolos.php',
            'reporte/tecnicos.php',
            'reporte/referenciadores.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment</i>
                <span>Reportes</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['reporte/protocolos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'reporte/protocolos.php'); ?>">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Protocolos</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['reporte/tecnicos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'reporte/tecnicos.php'); ?>">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Técnicos</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['reporte/referenciadores.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'reporte/referenciadores.php'); ?>">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Referenciadores</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>

    <!-- Elemento del menú: Reportes Financieros -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'COORDINADOR ADMIN'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'reporte/ingresos.php',
            'reporte/cobros.php',
            'caja/fondo.php',
            'caja/balance_mes.php',
            'caja/administracion.php',
            'caja/retiros_reporte.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment</i>
                <span>Reportes Financieros</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/administracion.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/administracion.php'); ?>">
                        <i class="material-icons">monetization_on</i>
                        <span>Administración</span>
                    </a>
                </li>
                <!-- Submenú: Balance por Mes -->
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/balance_mes.php']); ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">monetization_on</i>
                        <span>Balance por Mes</span>
                    </a>
                    <ul class="ml-menu">
                        <!-- Balance del usuario actual -->
                        <li>
                            <a href="<?php echo obtenerRutaSegura($ruta . 'caja/balance_mes.php?us=' . $emp_nombre); ?>">
                                <span><?php echo htmlspecialchars($emp_nombre, ENT_QUOTES, 'UTF-8'); ?></span>
                            </a>
                        </li>
                        <!-- Balance por cada médico registrado -->
                        <?php
                        $sql_medico = "
                            SELECT medico_id, medico
                            FROM medicos
                            WHERE empresa_id = ?
                        ";
                        $stmt = $conn->prepare($sql_medico);
                        $stmt->bind_param('i', $empresa_id);
                        $stmt->execute();
                        $result_medico = $stmt->get_result();
                        while ($row_medico = $result_medico->fetch_assoc()) { ?>
                            <li>
                                <a href="<?php echo obtenerRutaSegura($ruta . 'caja/balance_mes.php?us=' . $row_medico['medico']); ?>">
                                    <span><?php echo htmlspecialchars($row_medico['medico'], ENT_QUOTES, 'UTF-8'); ?></span>
                                </a>
                            </li>
                        <?php }
                        $stmt->close();
                        ?>
                    </ul>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/fondo.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/fondo.php'); ?>">
                        <i class="material-icons">monetization_on</i>
                        <span>Fondo de Cajas</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/retiros_reporte.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/retiros_reporte.php'); ?>">
                        <i class="material-icons">monetization_on</i>
                        <span>Reporte Retiros</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>
    <!-- Elemento del menú: Caja -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'RECEPCION'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'caja/corte.php',
            'caja/cobro.php',
            'caja/pagos.php',
            'caja/movimientos.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">monetization_on</i>
                <span>Caja</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/cobro.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/cobro.php'); ?>">
                        <i class="material-icons">add_shopping_cart</i>
                        <span>Cobro</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/pagos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/pagos.php'); ?>">
                        <i class="material-icons">payment</i>
                        <span>Pagos</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/corte.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/corte.php'); ?>">
                        <i class="material-icons">cached</i>
                        <span>Corte</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['caja/movimientos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'caja/movimientos.php'); ?>">
                        <i class="material-icons">monetization_on</i>
                        <span>Movimientos Diario</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>

    <!-- Elemento del menú: Protocolos -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'TECNICO'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'protocolo/alta.php',
            'protocolo/estatus.php',
            'protocolo/protocolo.php',
            'protocolo/alta_consultorio.php',
            'protocolo/consultorio.php',
            'protocolo/catalogo_clinimetria.php',
            'protocolo/clinimetria.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment_ind</i>
                <span>Protocolos</span>
            </a>
            <ul class="ml-menu">
                <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR'], $funcion)) { ?>
                    <li class="<?php echo esUrlActiva($ubicacion_url, ['protocolo/clinimetria.php']); ?>">
                        <a href="<?php echo obtenerRutaSegura($ruta . 'protocolo/clinimetria.php'); ?>">
                            <i class="material-icons">playlist_add</i>
                            <span>Alta Clinimetria</span>
                        </a>
                    </li>
                    <li class="<?php echo esUrlActiva($ubicacion_url, ['protocolo/catalogo_clinimetria.php']); ?>">
                        <a href="<?php echo obtenerRutaSegura($ruta . 'protocolo/catalogo_clinimetria.php'); ?>">
                            <i class="material-icons">content_paste</i>
                            <span>Clinimetrias</span>
                        </a>
                    </li>
                    <li class="<?php echo esUrlActiva($ubicacion_url, ['protocolo/estatus.php']); ?>">
                        <a href="<?php echo obtenerRutaSegura($ruta . 'protocolo/estatus.php'); ?>">
                            <i class="material-icons">content_paste</i>
                            <span>Estatus Protocolos</span>
                        </a>
                    </li>
                <?php } ?>
                <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'TECNICO'], $funcion)) { ?>
                    <li class="<?php echo esUrlActiva($ubicacion_url, ['protocolo/protocolo.php']); ?>">
                        <a href="<?php echo obtenerRutaSegura($ruta . 'protocolo/protocolo.php'); ?>">
                            <i class="material-icons">receipt</i>
                            <span>Aplicar Protocolo</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
    <!-- Elemento del menú: Usuarios -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'COORDINADOR ADMIN', 'TECNICO', 'REPRESENTANTE'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'usuarios/directorio.php',
            'control_gas/reportes.php',
            'control_gas/index.php',
            'usuarios/alta_medico.php',
            'usuarios/alta_usuario.php',
            'registros/ver_registrados.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">people</i>
                <span>Usuarios</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['usuarios/directorio.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'usuarios/directorio.php'); ?>">
                        <i class="material-icons">book</i>
                        <span>Medico</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['usuarios/alta_medico.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'usuarios/alta_medico.php'); ?>">
                        <i class="material-icons">person_add</i>
                        <span>Alta Medico o Usuario</span>
                    </a>
                </li>
                <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR', 'REPRESENTANTE'], $funcion)) { ?>
                    <li class="<?php echo esUrlActiva($ubicacion_url, ['usuarios/genera_invitacion.php']); ?>">
                        <a href="<?php echo obtenerRutaSegura($ruta . 'usuarios/genera_invitacion.php'); ?>">
                            <i class="material-icons">person_add</i>
                            <span>Invitación de Usuario</span>
                        </a>
                    </li>
                    <li class="<?php echo esUrlActiva($ubicacion_url, ['registros/ver_registrados.php']); ?>">
                        <a href="<?php echo obtenerRutaSegura($ruta . 'registros/ver_registrados.php'); ?>">
                            <i class="material-icons">person_add</i>
                            <span>Participantes Registrados</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['control_gas/index.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'control_gas/index.php'); ?>">
                        <i class="material-icons">local_gas_station</i>
                        <span>Carga de Kilometraje</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['control_gas/reportes.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'control_gas/reportes.php'); ?>">
                        <i class="material-icons">local_gas_station</i>
                        <span>Ver Reportes Km.</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>

    <!-- Elemento del menú: Seguimientos Sistema -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR', 'COORDINADOR'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'seguimientos/index.php',
            'seguimientos/seguimientos.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">settings</i>
                <span>Seguimientos Sistema</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['seguimientos/index.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'seguimientos/index.php'); ?>">
                        <i class="material-icons">settings</i>
                        <span>Solicitud a Sistemas</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['seguimientos/seguimientos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'seguimientos/seguimientos.php'); ?>">
                        <i class="material-icons">build</i>
                        <span>Seguimientos</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>

    <!-- Elemento del menú: Página Web -->
    <?php if (usuarioTieneRol(['SISTEMAS', 'ADMINISTRADOR'], $funcion)) { ?>
        <li class="<?php echo esUrlActiva($ubicacion_url, [
            'noticias/directorio.php',
            'noticias/catalogo_imagenes.php',
            'noticias/alta.php',
            'usuarios/alta_usuario.php',
            'noticias/carrusel.php',
            'noticias/personal.php'
        ]); ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">web</i>
                <span>Página Web</span>
            </a>
            <ul class="ml-menu">
                <li class="<?php echo esUrlActiva($ubicacion_url, ['noticias/gestion_articulos.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'noticias/gestion_articulos.php'); ?>">
                        <i class="material-icons">assignment</i>
                        <span>Noticias</span>
                    </a>
                </li>
                <li class="<?php echo esUrlActiva($ubicacion_url, ['noticias/catalogo_imagenes.php']); ?>">
                    <a href="<?php echo obtenerRutaSegura($ruta . 'noticias/catalogo_imagenes.php'); ?>">
                        <i class="material-icons">image</i>
                        <span>Catálogo de Imágenes</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>

    </ul>  
</div>
<!-- #Menu -->
