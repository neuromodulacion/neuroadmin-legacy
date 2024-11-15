<!-- Menu principal de navegación -->
<div class="menu">
    <ul class="list">
        <!-- Encabezado del menú -->
        <li class="header">Menú de Navegación</li>
        
        <!-- Elemento del menú: Inicio -->
        <!-- Este elemento es visible para todos los usuarios y muestra la página de inicio -->
        <li <?php if ($ubicacion_url == $ruta.'menu.php') { echo 'class="active"'; } ?>>
            <a href="<?php echo $ruta; ?>menu.php">
                <i class="material-icons">home</i>
                <span>Inicio</span>
            </a>
        </li>
        
        <!-- Elemento del menú: Dashboard (Visible para usuarios con función SISTEMAS, ADMINISTRADOR, o COORDINADOR) -->
        <!-- Este elemento del menú solo es visible para usuarios con ciertos roles y permite acceder al dashboard de reportes -->
        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'COORDINADOR') { ?>
        <li <?php if ($ubicacion_url == 'reporte/dashboard.php') { echo 'class="active"'; } ?>>
            <a href="<?php echo $ruta; ?>reporte/dashboard.php">
                <i class="material-icons">dashboard</i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php } ?>
        
        <!-- Elemento del menú: CRM (Visible para usuarios con función SISTEMAS, ADMINISTRADOR, o REPRESENTANTE) -->
        <!-- Este elemento del menú es accesible para los roles SISTEMAS, ADMINISTRADOR, o REPRESENTANTE y permite acceder a funcionalidades del CRM -->
        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'REPRESENTANTE') { ?>
        <li <?php if ($ubicacion_url == 'crm/medicos.php' || $ubicacion_url == 'reporte/referenciadores.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">supervisor_account</i>
                <span>CRM</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Reporte de Referenciadores -->
                <!-- Este submenú muestra un reporte de referenciadores -->
                <li <?php if ($ubicacion_url == 'reporte/referenciadores.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>reporte/referenciadores.php">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Referenciadores</span>
                    </a>
                </li>
                <!-- Submenú: Médicos -->
                <!-- Este submenú muestra la lista de médicos registrados en el CRM -->
                <li <?php if ($ubicacion_url == 'crm/medicos.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>crm/medicos.php">
                        <i class="material-icons">perm_identity</i>
                        <span>Medicos</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>                     
        <!-- Elemento del menú: Pacientes -->
		<!-- Este elemento del menú permite acceder a diferentes secciones relacionadas con los pacientes -->
		<li <?php if ($ubicacion_url == 'paciente/alta.php' || $ubicacion_url == 'paciente/pendientes.php' || $ubicacion_url == 'paciente/solicitud.php'  || $ubicacion_url == 'paciente/seguimientos.php' || $ubicacion_url == 'paciente/directorio.php' || $ubicacion_url == 'paciente/historico.php' || $ubicacion_url == 'agenda/agenda.php' || $ubicacion_url == 'carta/cartas_generadas.php' || $funcion == 'COORDINADOR' || $ubicacion_url == 'carta/genera_invitacion.php' || $ubicacion_url == 'paciente/pacientes_consultas.php') { echo 'class="active"'; } ?>>
		    <a href="javascript:void(0);" class="menu-toggle">
		        <i class="material-icons">assignment_ind</i>
		        <span>Pacientes</span>
		    </a>
		    <ul class="ml-menu">
		        <!-- Submenú: Alta de Paciente -->
		        <!-- Permite dar de alta a un nuevo paciente en el sistema -->
		        <li <?php if ($ubicacion_url == 'paciente/alta.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>paciente/alta.php">
		                <i class="material-icons">person_add</i>
		                <span>Alta Paciente</span>
		            </a>
		        </li>
		        <!-- Submenú: Pacientes Pendientes -->
		        <!-- Muestra la lista de pacientes pendientes de ser atendidos o procesados -->
		        <li <?php if ($ubicacion_url == 'paciente/pendientes.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>paciente/pendientes.php">
		                <i class="material-icons">notifications</i>
		                <span>Pacientes Pendientes</span>
		            </a>
		        </li>
		        <!-- Submenú: Seguimientos -->
		        <!-- Permite realizar seguimiento a los pacientes registrados -->
		        <li <?php if ($ubicacion_url == 'paciente/seguimientos.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>paciente/seguimientos.php">
		                <i class="material-icons">notifications</i>
		                <span>Seguimientos</span>
		            </a>
		        </li>
		        <!-- Submenú: Directorio de Pacientes -->
		        <!-- Muestra el directorio de todos los pacientes registrados -->
		        <li <?php if ($ubicacion_url == 'paciente/directorio.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>paciente/directorio.php">
		                <i class="material-icons">book</i>
		                <span>Pacientes</span>
		            </a>
		        </li>
		        
		        <!-- Submenú: Pacientes Consultorio (Visible para ciertos roles) -->
		        <!-- Este submenú está disponible para ciertos roles y permite acceder a la lista de pacientes consultorio -->
		        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'COORDINADOR' || $funcion == 'COORDINADOR ADMIN' || $funcion == 'TECNICO' || $funcion == 'RECEPCION') { ?>
		        <li <?php if ($ubicacion_url == 'paciente/pacientes_consultas.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>paciente/pacientes_consultas.php">
		                <i class="material-icons">book</i>
		                <span>Pacientes Consultorio</span>
		            </a>
		        </li>
		        <?php } ?>
		        
		        <!-- Submenú: Agenda Neuromodulación -->
		        <!-- Permite acceder a la agenda de citas de neuromodulación -->
		        <li <?php if ($ubicacion_url == 'agenda/agenda.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>agenda/agenda.php">
		                <i class="material-icons">event</i>
		                <span>Agenda Neuromodulación</span>
		            </a>
		        </li>
		        
		        <!-- Submenú: Invitación Carta Perro (Visible para roles SISTEMAS y ADMINISTRADOR) -->
		        <!-- Permite generar una invitación para una carta relacionada con perros -->
		        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR') { ?>
		        <li <?php if ($ubicacion_url == 'carta/genera_invitacion.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>carta/genera_invitacion.php">
		                <i class="material-icons">pets</i>
		                <span>Invitación Carta Perro</span>
		            </a>
		        </li>
		        <!-- Submenú: Cartas Generadas Perro -->
		        <!-- Muestra las cartas generadas relacionadas con perros -->
		        <li <?php if ($ubicacion_url == 'carta/cartas_generadas.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>carta/cartas_generadas.php">
		                <i class="material-icons">pets</i>
		                <span>Cartas Generadas Perro</span>
		            </a>
		        </li>
		        <?php } ?>
		        
		        <!-- Submenú: Pacientes Bind (Visible solo para rol SISTEMAS) -->
		        <!-- Este submenú permite acceder a los pacientes de Bind -->
		        <?php if ($funcion == 'SISTEMAS') { ?>
		        <li <?php if ($ubicacion_url == 'api/pacientes_bind.php') { echo 'class="active"'; } ?>>
		            <a href="<?php echo $ruta; ?>api/pacientes_bind.php">
		                <i class="material-icons">pets</i>
		                <span>Pacientes Bind</span>
		            </a>
		        </li>
		        <?php } ?>
		    </ul>
		</li>
        <!-- Elemento del menú: Reportes -->
        <!-- Este elemento está disponible para los roles SISTEMAS, ADMINISTRADOR, COORDINADOR, COORDINADOR ADMIN y REPRESENTANTE -->
        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR'|| $funcion == 'COORDINADOR' || $funcion == 'COORDINADOR ADMIN' || $funcion == 'REPRESENTANTE') { ?>  
        <li <?php if ($ubicacion_url == 'reporte/protocolos.php' || $ubicacion_url == 'reporte/tecnicos.php' || $ubicacion_url == 'reporte/referenciadores.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment</i>
                <span>Reportes</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Reporte de Protocolos -->
                <!-- Permite acceder al reporte de protocolos registrados en el sistema -->
                <li <?php if ($ubicacion_url == 'reporte/protocolos.php') { echo 'class="active"'; } ?> >
                    <a href="<?php echo $ruta; ?>reporte/protocolos.php">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Protocolos</span>
                    </a>
                </li> 
                <!-- Submenú: Reporte de Técnicos -->
                <!-- Muestra un reporte relacionado con los técnicos registrados -->
                <li <?php if ($ubicacion_url == 'reporte/tecnicos.php') { echo 'class="active"'; } ?> >
                    <a href="<?php echo $ruta; ?>reporte/tecnicos.php">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Técnicos</span>
                    </a>
                </li>  
                <!-- Submenú: Reporte de Referenciadores -->
                <!-- Permite visualizar el reporte de referenciadores -->
                <li <?php if ($ubicacion_url == 'reporte/referenciadores.php') { echo 'class="active"'; } ?> >
                    <a href="<?php echo $ruta; ?>reporte/referenciadores.php">
                        <i class="material-icons">assessment</i>
                        <span>Reporte de Referenciadores</span>
                    </a>
                </li>  
              </ul> 
          </li>
        <?php } ?>  
         <!-- Elemento del menú: Reportes Financieros -->
        <!-- Disponible para roles SISTEMAS, ADMINISTRADOR, COORDINADOR y COORDINADOR ADMIN -->
        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'COORDINADOR' || $funcion == 'COORDINADOR ADMIN') { ?>   
        <li <?php if ($ubicacion_url == 'reporte/ingresos.php' || $ubicacion_url == 'reporte/cobros.php' || $ubicacion_url == 'caja/fondo.php' || $ubicacion_url == 'caja/balance_mes.php' || $ubicacion_url == 'caja/administracion.php' || $ubicacion_url == 'caja/retiros_reporte.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment</i>
                <span>Reportes Financieros</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Administración -->
                <!-- Permite acceder a la sección de administración de caja -->
                <li <?php if ($ubicacion_url == 'caja/administracion.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/administracion.php">
                        <i class="material-icons">monetization_on</i>
                        <span>Administración</span>
                    </a>
                </li>
                <!-- Submenú (Comentado): Movimientos Diario -->
                <!-- Este submenú permite acceder a los movimientos diarios de caja, actualmente está comentado -->
                <!-- <li <?php if ($ubicacion_url == 'caja/movimientos.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/movimientos.php">
                        <i class="material-icons">monetization_on</i>
                        <span>Movimientos Diario</span>
                    </a>
                </li> -->
                <!-- Submenú: Balance por Mes -->
                <!-- Permite visualizar el balance mensual, con enlaces para cada médico registrado -->
                <li <?php if ($ubicacion_url == 'caja/balance_mes.php' || $ubicacion_url == 'caja/balance_mes.php?us='.$emp_nombre) { echo 'class="active"'; } ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">monetization_on</i>
                        <span>Balance por Mes</span>
                    </a>
                    <ul class="ml-menu">
                        <!-- Submenú: Balance del usuario actual -->
                        <li>
                            <a href="<?php echo $ruta; ?>caja/balance_mes.php?us=<?php echo $emp_nombre; ?>">
                                <span><?php echo $emp_nombre; ?></span>
                            </a>
                        </li>
                        <!-- Submenú: Balance por cada médico registrado en la empresa -->
                        <?php
                            $sql_medico = "
                                SELECT
                                    medicos.medico_id, 
                                    medicos.medico
                                FROM
                                    medicos
                                WHERE
                                    medicos.empresa_id = $empresa_id
                            ";
                            $result_medico = ejecutar($sql_medico); 
                            while ($row_medico = mysqli_fetch_array($result_medico)) { 
                                extract($row_medico);
                        ?>
                        <li>
                            <a href="<?php echo $ruta; ?>caja/balance_mes.php?us=<?php echo $medico; ?>">
                                <span><?php echo $medico; ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- Submenú: Fondo de Cajas -->
                <!-- Permite acceder al fondo de cajas del sistema -->
                <li <?php if ($ubicacion_url == 'caja/fondo.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/fondo.php">
                        <i class="material-icons">monetization_on</i>
                        <span>Fondo de Cajas</span>
                    </a>
                </li>
                <!-- Submenú: Reporte Retiros -->
                <!-- Muestra el reporte de retiros de caja registrados en el sistema -->
                <li <?php if ($ubicacion_url == 'caja/retiros_reporte.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/retiros_reporte.php">
                        <i class="material-icons">monetization_on</i>
                        <span>Reporte Retiros</span>
                    </a>
                </li>                               
            </ul> 
        </li>
        <?php } ?>	                 
        <!-- Elemento del menú: Caja -->
        <!-- Disponible para roles SISTEMAS, ADMINISTRADOR, COORDINADOR y RECEPCION -->
        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'COORDINADOR' || $funcion == 'RECEPCION') { ?>    
        <li <?php if ($ubicacion_url == 'caja/corte.php' || $ubicacion_url == 'caja/cobro.php' || $ubicacion_url == 'caja/pagos.php' || $ubicacion_url == 'caja/movimientos.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">monetization_on</i>
                <span>Caja</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Cobro -->
                <!-- Permite registrar cobros realizados en el sistema -->
                <li <?php if ($ubicacion_url == 'caja/cobro.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/cobro.php">
                        <i class="material-icons">add_shopping_cart</i>
                        <span>Cobro</span>
                    </a>
                </li>
                <!-- Submenú: Pagos -->
                <!-- Permite registrar pagos realizados por el usuario -->
                <li <?php if ($ubicacion_url == 'caja/pagos.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/pagos.php">
                        <i class="material-icons">payment</i>
                        <span>Pagos</span>
                    </a>
                </li>                          
                <!-- Submenú: Corte -->
                <!-- Permite realizar el corte de caja del día -->
                <li <?php if ($ubicacion_url == 'caja/corte.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/corte.php">
                        <i class="material-icons">cached</i>
                        <span>Corte</span>
                    </a>
                </li>  
                <!-- Submenú: Movimientos Diario -->
                <!-- Muestra todos los movimientos registrados en la caja diariamente -->
                <li <?php if ($ubicacion_url == 'caja/movimientos.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>caja/movimientos.php">
                        <i class="material-icons">monetization_on</i>
                        <span>Movimientos Diario</span>
                    </a>
                </li>                                            
            </ul> 
        </li> 
		<?php } ?>
	
		<!-- Elemento del menú: Protocolos -->
		<!-- Este elemento está disponible para los roles SISTEMAS, ADMINISTRADOR, COORDINADOR y TECNICO -->
	    <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR'|| $funcion == 'COORDINADOR' || $funcion == 'TECNICO' ) { ?> 
	    <li <?php if ($ubicacion_url == 'protocolo/alta.php' || $ubicacion_url == 'protocolo/estatus.php' || $ubicacion_url == 'protocolo/protocolo.php' || $ubicacion_url == 'protocolo/alta_consultorio.php' || $ubicacion_url == 'protocolo/consultorio.php' || $ubicacion_url == 'protocolo/catalogo_clinimetria.php' || $ubicacion_url == 'protocolo/clinimetria.php') { echo 'class="active"'; } ?>>
			<a href="javascript:void(0);" class="menu-toggle">
				<i class="material-icons">assignment_ind</i>
			     <span>Protocolos</span>
			</a>
	          <ul class="ml-menu">
	              <!-- Submenú: Alta Clinimetria -->
	              <!-- Permite registrar una nueva clinimetría, disponible para roles SISTEMAS, ADMINISTRADOR y COORDINADOR -->
	              <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR'|| $funcion == 'COORDINADOR') { ?> 
	              <li <?php if ($ubicacion_url == 'protocolo/clinimetria.php') { echo 'class="active"'; } ?>>
	                  <a href="<?php echo $ruta; ?>protocolo/clinimetria.php">
	                      <i class="material-icons">playlist_add</i>
	                      <span>Alta Clinimetria</span>
	                  </a>
	              </li>
	              <!-- Submenú: Catálogo de Clinimetrias -->
	              <!-- Muestra todas las clinimetrias registradas en el sistema -->
	              <li <?php if ($ubicacion_url == 'protocolo/catalogo_clinimetria.php') { echo 'class="active"'; } ?>>
	                  <a href="<?php echo $ruta; ?>protocolo/catalogo_clinimetria.php">
	                      <i class="material-icons">content_paste</i>
	                      <span>Clinimetrias</span>
	                  </a>
	              </li>                          
	              <!-- Submenú: Estatus Protocolos -->
	              <!-- Permite visualizar el estatus de los protocolos registrados -->
	              <li <?php if ($ubicacion_url == 'protocolo/estatus.php') { echo 'class="active"'; } ?>>
	                  <a href="<?php echo $ruta; ?>protocolo/estatus.php">
	                      <i class="material-icons">content_paste</i>
	                      <span>Estatus Protocolos</span>
	                  </a>
	              </li>
	              <?php } ?>
	              <!-- Submenú: Aplicar Protocolo -->
	              <!-- Permite aplicar un protocolo, disponible para roles SISTEMAS, ADMINISTRADOR, COORDINADOR y TECNICO -->
	              <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR'|| $funcion == 'COORDINADOR' || $funcion == 'TECNICO' ) { ?>  
	              <li <?php if ($ubicacion_url == 'protocolo/protocolo.php') { echo 'class="active"'; } ?>>
	                  <a href="<?php echo $ruta; ?>protocolo/protocolo.php">
	                      <i class="material-icons">receipt</i>
	                      <span>Aplicar Protocolo</span>
	                  </a>
	              </li>
	              <?php } ?>
	          </ul> 
	      </li> 
	      <?php } ?>
        <!-- Elemento del menú: Usuarios -->
        <!-- Disponible para los roles SISTEMAS, ADMINISTRADOR, COORDINADOR, COORDINADOR ADMIN, TECNICO y REPRESENTANTE -->
        <?php if ($funcion == 'SISTEMAS'  || $funcion == 'ADMINISTRADOR'|| $funcion == 'COORDINADOR' || $funcion == 'COORDINADOR ADMIN'  || $funcion == 'TECNICO' || $funcion == 'REPRESENTANTE' ) { ?> 
           
        <li <?php if ($ubicacion_url == 'usuarios/directorio.php' || $ubicacion_url == 'control_gas/reportes.php' || $ubicacion_url == 'control_gas/index.php' || $ubicacion_url == 'usuarios/alta_medico.php' || $ubicacion_url == 'usuarios/alta_usuario.php' || $ubicacion_url == 'registros/ver_registrados.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">people</i>
                <span>Usuarios</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Directorio de Médicos -->
                <!-- Muestra la lista de médicos registrados en el sistema -->
                <li <?php if ($ubicacion_url == 'usuarios/directorio.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>usuarios/directorio.php">
                        <i class="material-icons">book</i>
                        <span>Medico</span>
                    </a>
                </li> 
                <!-- Submenú: Alta de Médico o Usuario -->
                <!-- Permite registrar un nuevo médico o usuario en el sistema -->
                <li <?php if ($ubicacion_url == 'usuarios/alta_medico.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>usuarios/alta_medico.php">
                        <i class="material-icons">person_add</i>
                        <span>Alta Medico o Usuario</span>
                    </a>
                </li>  
                
                <!-- Submenú: Invitación de Usuario (Visible para ciertos roles) -->
                <!-- Permite generar una invitación para que un nuevo usuario se registre -->
                <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR'|| $funcion == 'COORDINADOR'  || $funcion == 'REPRESENTANTE' ) { ?>                 
                <li <?php if ($ubicacion_url == 'usuarios/genera_invitacion.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>usuarios/genera_invitacion.php">
                        <i class="material-icons">person_add</i>
                        <span>Invitación de Usuario</span>
                    </a>
                </li> 
                
                <!-- Submenú: Participantes Registrados -->
                <!-- Muestra una lista de los participantes registrados en el sistema -->
                <li <?php if ($ubicacion_url == 'registros/ver_registrados.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>registros/ver_registrados.php">
                        <i class="material-icons">person_add</i>
                        <span>Participantes Registrados</span>
                    </a>
                </li>                
                <?php } ?>
                
                <!-- Submenú: Carga de Kilometraje -->
                <!-- Permite a los usuarios registrar el kilometraje de sus vehículos en el sistema -->
                <li <?php if ($ubicacion_url == 'control_gas/index.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>control_gas/index.php">
                        <i class="material-icons">local_gas_station</i>
                        <span>Carga de Kilometraje</span>
                    </a>
                </li> 
                
                <!-- Submenú: Reportes de Kilometraje -->
                <!-- Permite visualizar los reportes de kilometraje registrados en el sistema -->
                <li <?php if ($ubicacion_url == 'control_gas/reportes.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>control_gas/reportes.php">
                        <i class="material-icons">local_gas_station</i>
                        <span>Ver Reportes Km.</span>
                    </a>
                </li>                                    
            </ul> 
        </li>                      
        <?php } ?>

        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR' || $funcion == 'COORDINADOR') { ?>
        <!-- Elemento del menú: Seguimientos Sistema -->
        <!-- Este elemento permite el acceso a las solicitudes y seguimientos en el sistema -->
        <li <?php if ($ubicacion_url == 'seguimientos/index.php' || $ubicacion_url == 'seguimientos/seguimientos.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">settings</i>
                <span>Seguimientos Sistema</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Solicitud a Sistemas -->
                <!-- Permite realizar solicitudes al equipo de sistemas -->
                <li <?php if ($ubicacion_url == 'seguimientos/index.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>seguimientos/index.php">
                        <i class="material-icons">settings</i>
                        <span>Solicitud a Sistemas</span>
                    </a>
                </li>
                <!-- Submenú: Seguimientos -->
                <!-- Permite realizar el seguimiento a las solicitudes enviadas al equipo de sistemas -->
                <li <?php if ($ubicacion_url == 'seguimientos/seguimientos.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>seguimientos/seguimientos.php">
                        <i class="material-icons">build</i>
                        <span>Seguimientos</span>
                    </a>
                </li>
            </ul>
        </li>
		<?php } ?>
        <!-- Elemento del menú: Página Web -->
        <!-- Disponible para roles SISTEMAS y ADMINISTRADOR -->
        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR') { ?>
        <li <?php if ($ubicacion_url == 'noticias/directorio.php' || $ubicacion_url == 'noticias/catalogo_imagenes.php' || $ubicacion_url == 'noticias/alta.php' || $ubicacion_url == 'usuarios/alta_usuario.php' || $ubicacion_url == 'noticias/carrusel.php' || $ubicacion_url == 'noticias/personal.php') { echo 'class="active"'; } ?>>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">web</i>
                <span>Página Web</span>
            </a>
            <ul class="ml-menu">
                <!-- Submenú: Gestión de Artículos de Noticias -->
                <!-- Permite gestionar los artículos publicados en la página web -->
                <li <?php if ($ubicacion_url == 'noticias/gestion_articulos.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>noticias/gestion_articulos.php">
                        <i class="material-icons">assignment</i>
                        <span>Noticias</span>
                    </a>
                </li>
                <!-- Submenú: Catálogo de Imágenes -->
                <!-- Permite gestionar el catálogo de imágenes utilizado en la página web -->
                <li <?php if ($ubicacion_url == 'noticias/catalogo_imagenes.php') { echo 'class="active"'; } ?>>
                    <a href="<?php echo $ruta; ?>noticias/catalogo_imagenes.php">
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