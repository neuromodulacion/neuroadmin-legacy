<?php
// Define la ruta base para las inclusiones de archivos
$ruta = "../";
$titulo = "Administración"; // Título de la página

// Incluye el archivo header1.php, que contiene configuraciones y elementos comunes de la cabecera
include($ruta . 'header1.php');

// Fecha pasada (7 días antes de la fecha actual)
$date_past = date("Y-m-d", strtotime('-7 day'));
$ahora = date("d-m-Y"); // Fecha actual en formato "DD-MM-YYYY"

// Verifica si la fecha de entrada está vacía, de ser así, se asigna la fecha actual
if ($fechaInput == "") {
    $fechaInput = $anio . "-" . $mes_ahora; // Fecha en formato "YYYY-MM"
}

// Función que obtiene la abreviatura del nombre del mes en español
function OptieneMesCorto($mes) {
    if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Ene'; }
    if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Feb'; }    
    if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Mar'; }    
    if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abr'; }    
    if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'May'; }    
    if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Jun'; }    
    if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Jul'; }    
    if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Ago'; }    
    if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Sep'; }    
    if ($mes == 10 || $mes == '10' ){ $xmes = 'Oct'; }    
    if ($mes == 11 || $mes == '11' ){ $xmes = 'Nov'; }    
    if ($mes == 12 || $mes == '12' ){ $xmes = 'Dic'; }  

    return $xmes; // Devuelve la abreviatura del mes seleccionado
}

// Función que obtiene el nombre completo del mes en español
function OptieneMesLargo($mes) {
    if ($mes == 1  || $mes == '1' || $mes == '01') { $xmes = 'Enero'; }
    if ($mes == 2  || $mes == '2' || $mes == '02') { $xmes = 'Febrero'; }    
    if ($mes == 3  || $mes == '3' || $mes == '03') { $xmes = 'Marzo'; }    
    if ($mes == 4  || $mes == '4' || $mes == '04') { $xmes = 'Abril'; }    
    if ($mes == 5  || $mes == '5' || $mes == '05') { $xmes = 'Mayo'; }    
    if ($mes == 6  || $mes == '6' || $mes == '06') { $xmes = 'Junio'; }    
    if ($mes == 7  || $mes == '7' || $mes == '07') { $xmes = 'Julio'; }    
    if ($mes == 8  || $mes == '8' || $mes == '08') { $xmes = 'Agosto'; }    
    if ($mes == 9  || $mes == '9' || $mes == '09') { $xmes = 'Septiembre'; }    
    if ($mes == 10 || $mes == '10' ){ $xmes = 'Octubre'; }    
    if ($mes == 11 || $mes == '11' ){ $xmes = 'Noviembre'; }    
    if ($mes == 12 || $mes == '12' ){ $xmes = 'Diciembre'; }  

    return $xmes; // Devuelve el nombre completo del mes seleccionado
}

// Variables que representan el mes y año seleccionados a partir de la fecha de entrada
$mes_sel = date('m', strtotime($fechaInput));
$anio_sel = date('Y', strtotime($fechaInput));
?>
<!-- Estilos y plugins CSS -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php  
// Incluye el archivo header2.php, que contiene la segunda parte de la cabecera con la barra de navegación y el menú
include($ruta . 'header2.php'); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>CORTE</h2>
            <?php echo $ubicacion_url; ?>
        </div>

        <!-- Contenido principal de la página -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Corte</h1>     
                        <hr>
                        <div align="right">
                            <!-- Formulario para seleccionar un mes específico -->
                            <form action="administracion.php" method="post">
                                <div class="row">
                                  <div class="col-md-6"></div>
                                  <div class="col-md-3"><h2><b>Mes</b></h2></div>
                                  <div class="col-md-3">
                                    <input id="fechaInput" name="fechaInput" style="width: 180px" align="center" type="month" class="form-control" value="<?php echo $fechaInput; ?>"/>
                                  </div>
                                </div>                                           
                            </form> 
                            <script>
                                // Al cambiar la fecha, el formulario se envía automáticamente
                                $(document).ready(function() {
                                    $('#fechaInput').change(function() {
                                        $(this).closest('form').submit();
                                    });
                                });                                 
                            </script>                                      
                        </div>
                        <hr>  
                        <h1>Fondos</h1> 
                        <h3>Usuarios:</h3>  
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Tabla que muestra el saldo por usuario -->
                                <table style="width: 70%" class="table table-bordered">
                                    <tr>
                                        <th colspan="4" align="center"><h2 align="center"><B>Saldo por Usuario al <?php echo $ahora; ?></B></h2></th>
                                    </tr>                                              
                                    <tr>
                                        <th style="text-align: center">Usuario</th>
                                        <th style="text-align: center">Nombre</th>
                                        <th style="text-align: center">Fondo</th>
                                    </tr>
                                    <?php
                                        // Consulta SQL para obtener el saldo por usuario
                                        $sql_cob = "
                                            SELECT
                                                admin.usuario_id, 
                                                admin.nombre, 
                                                admin.saldo
                                            FROM
                                                admin
                                            WHERE
                                                admin.empresa_id = $empresa_id AND
                                                admin.saldo <> 0
                                        ";
                                        
                                        // Ejecuta la consulta y obtiene el número de filas resultantes
                                        $result_cob = ejecutar($sql_cob);
                                        $cnt_cob = mysqli_num_rows($result_cob);
                                        
                                        // Si hay resultados, los muestra en la tabla
                                        if ($cnt_cob <> 0) {
                                            while($row_cob = mysqli_fetch_array($result_cob)) {
                                                extract($row_cob);    
                                                ?>
                                                <tr>
                                                    <td><?php echo $usuario_id; ?></td> 
                                                    <td><?php echo $nombre; ?></td>
                                                    <td>$&nbsp;<?php echo number_format($saldo); ?></td>
                                                </tr>                                                    
                                                <?php 
                                            } 
                                        } else {  
                                            // Si no hay resultados, muestra un mensaje indicándolo
                                            ?>
                                            <tr>
                                                <th style="text-align: center" colspan="3"><i>Sin Resultados</i></th> 
                                            </tr>                                                    
                                            <?php 
                                        } 
                                    ?>
                                </table>                                
                            </div>
                            <div class="col-md-12">                                
                                <!-- Sección de últimos movimientos -->
                                <h3>Últimos Movimientos:</h3>  
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Tabla que muestra los cobros de Neuromodulación -->
                                        <table class="table table-bordered">
                                            <tr>
                                                <th colspan="4" align="center"><h2 align="center"><B>Cobros de Neuromodulacion Gdl</B></h2></th>
                                            </tr>                                              
                                            <tr>
                                                <th style="text-align: center;">Ticket</th>
                                                <th style="text-align: center;">Fecha</th>
                                                <th style="text-align: center">Paciente</th>
                                                <th style="text-align: center">Usuario</th>
                                                <th style="text-align: center">Forma de pago</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th style="text-align: center">Importe</th>
                                            </tr>
                                            <?php
                                            // Consulta SQL para obtener los cobros de terapia en el mes y año seleccionados
                                            $sql_cob = "
                                                SELECT
                                                    cobros.cobros_id,
                                                    cobros.usuario_id,
                                                    cobros.tipo,
                                                    cobros.doctor,
                                                    cobros.protocolo_ter_id,
                                                    cobros.f_pago,
                                                    cobros.importe,
                                                    cobros.f_captura,
                                                    cobros.h_captura,
                                                    cobros.ticket,
                                                    cobros.otros,
                                                    ( SELECT pacientes_bind.Number FROM pacientes INNER JOIN pacientes_bind ON pacientes.id_bind = pacientes_bind.ID WHERE pacientes.paciente_id = cobros.paciente_id ) AS id_bind,
                                                    cobros.paciente_id,
                                                    (SELECT
                                                    CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente
                                                FROM
                                                    pacientes
                                                WHERE pacientes.paciente_id = cobros.paciente_id ) as paciente,
                                                    cobros.empresa_id,
                                                    admin.nombre 
                                                FROM
                                                    cobros
                                                    INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
                                                WHERE
                                                    cobros.empresa_id = $empresa_id
                                                    AND cobros.tipo = 'Terapia'
                                                    AND month(cobros.f_captura) = $mes_sel
                                                    AND year(cobros.f_captura) = $anio_sel
                                                ORDER BY cobros.f_captura desc
                                            ";
                                            // Ejecuta la consulta y obtiene el número de filas resultantes
                                            $result_cob = ejecutar($sql_cob); 
                                            $cnt_cob = mysqli_num_rows($result_cob);
                                            
                                            // Si hay resultados, los muestra en la tabla
                                            if ($cnt_cob <> 0) {
                                                while($row_cob = mysqli_fetch_array($result_cob)) {
                                                    extract($row_cob); 
                                                    $f_captura = format_fecha_esp_dmy($f_captura);   
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $ticket; ?></td>
                                                        <td style="text-align: center"><?php echo $f_captura . " T " . $h_captura; ?></td> 
                                                        <td><?php echo $paciente_id . "-" . $paciente." / Bind-".$id_bind;; ?></td>
                                                        <td><?php echo $nombre; ?></td>
                                                        <td><?php echo $f_pago; ?></td> 
                                                        <td><?php echo $tipo; ?></td>
                                                        <td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
                                                    </tr>                                                    
                                                    <?php 
                                                } 
                                            } else {  
                                                // Si no hay resultados, muestra un mensaje indicándolo
                                                ?>
                                                <tr>
                                                    <th style="text-align: center" colspan="6"><i>Sin Resultados</i></th> 
                                                </tr>                                                    
                                                <?php 
                                            } 
                                            ?>
                                        </table>
                                    </div>
                                    <!-- Tabla que muestra los cobros de consultas médicas -->
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th colspan="4" align="center"><h2 align="center"><B>Cobros de Consultas</B></h2></th>
                                            </tr>                                              
                                            <tr>
                                                <th style="text-align: center">Fecha</th>
                                                <th style="text-align: center">Paciente</th>
                                                <th style="text-align: center">Cobro</th>
                                                <th style="text-align: center">Medico</th>
                                                <th style="text-align: center">Forma de pago</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th style="text-align: center">Importe</th>
                                            </tr>
                                            <?php
                                            // Consulta SQL para obtener los cobros de consultas médicas en el mes y año seleccionados
                                            $sql_cob = "
                                                SELECT
                                                    cobros.cobros_id,
                                                    cobros.usuario_id,
                                                    cobros.tipo,
                                                    cobros.doctor,
                                                    cobros.protocolo_ter_id,
                                                    cobros.f_pago,
                                                    cobros.importe,
                                                    cobros.f_captura,
                                                    cobros.h_captura,
                                                    cobros.otros,
                                                    cobros.paciente_id,
                                                    cobros.empresa_id,
                                                    admin.nombre,
                                                    (SELECT
														pacientes_bind.Number 
													FROM
														paciente_consultorio
														INNER JOIN pacientes_bind ON paciente_consultorio.id_bind = pacientes_bind.ID 
													WHERE
														paciente_consultorio.paciente_cons_id = cobros.paciente_cons_id) as id_bind,
                                                    cobros.paciente_cons_id,
                                                    paciente_consultorio.paciente,
                                                    paciente_consultorio.apaterno,
                                                    paciente_consultorio.amaterno 
                                                FROM
                                                    cobros
                                                    INNER JOIN admin ON cobros.usuario_id = admin.usuario_id
                                                    INNER JOIN paciente_consultorio ON cobros.paciente_cons_id = paciente_consultorio.paciente_cons_id 
                                                WHERE
                                                    cobros.empresa_id = $empresa_id
                                                    AND cobros.tipo = 'Consulta Medica'
                                                    AND month(cobros.f_captura) = $mes_sel
                                                    AND year(cobros.f_captura) = $anio_sel
                                                ORDER BY cobros.f_captura desc
                                            ";
                                            //echo $sql_cob."<hr>";
                                            // Ejecuta la consulta y obtiene el número de filas resultantes
                                            $result_cob = ejecutar($sql_cob); 
                                            $cnt_cob = mysqli_num_rows($result_cob);
                                            
                                            // Si hay resultados, los muestra en la tabla ." / Bind-".$id_bind
                                            if ($cnt_cob <> 0) {
                                                while($row_cob = mysqli_fetch_array($result_cob)) {
                                                    extract($row_cob);  
                                                    $f_captura = format_fecha_esp_dmy($f_captura);   
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center"><?php echo $f_captura . " T " . $h_captura; ?></td> 
                                                        <td><?php echo $paciente_cons_id . " - " . $paciente . " " . $apaterno . " " . $amaterno." / Bind-".$id_bind; ?></td>
                                                        <td><?php echo $nombre; ?></td>
                                                        <td><?php echo $doctor; ?></td>
                                                        <td><?php echo $f_pago; ?></td> 
                                                        <td><?php echo $tipo; ?></td>
                                                        <td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
                                                    </tr>                                                    
                                                    <?php 
                                                } 
                                            } else {  
                                                // Si no hay resultados, muestra un mensaje indicándolo
                                                ?>
                                                <tr>
                                                    <th style="text-align: center" colspan="6"><i>Sin Resultados</i></th> 
                                                </tr>                                                    
                                                <?php 
                                            } 
                                            ?>
                                        </table>
                                    </div>                                      
                                    <!-- Tabla que muestra los pagos -->
                                    <div class="col-md-12">
                                        <table style="width: 80%" class="table table-bordered">
                                            <tr>
                                                <th colspan="4" align="center"><h2 align="center"><B>Pagos</B></h2></th>
                                            </tr>                                              
                                            <tr>
                                                <th style="text-align: center">Fecha</th>
                                                <th style="text-align: center">Usuario</th>
                                                <th style="text-align: center">Forma de pago</th>
                                                <th style="text-align: center">Tipo</th>
                                                <th style="text-align: center">Importe</th>
                                            </tr>
                                            <?php
                                            // Consulta SQL para obtener los pagos en el mes y año seleccionados
                                            $sql_cob = "
                                                SELECT
                                                    pagos.pagos_id,
                                                    pagos.usuario_id,
                                                    pagos.f_captura,
                                                    pagos.h_captura,
                                                    pagos.importe,
                                                    pagos.tipo,
                                                    pagos.f_pago,
                                                    pagos.terapeuta,
                                                    pagos.empresa_id,
                                                    admin.nombre 
                                                FROM
                                                    pagos
                                                    INNER JOIN admin ON pagos.usuario_id = admin.usuario_id 
                                                WHERE
                                                    pagos.empresa_id = $empresa_id
                                                    AND month(pagos.f_captura) = $mes_sel
                                                    AND year(pagos.f_captura) = $anio_sel                                                
                                                ORDER BY pagos.f_captura desc
                                                LIMIT 15;
                                            ";
                                            // Ejecuta la consulta y obtiene el número de filas resultantes
                                            $result_cob = ejecutar($sql_cob); 
                                            $cnt_cob = mysqli_num_rows($result_cob);
                                            
                                            // Si hay resultados, los muestra en la tabla
                                            if ($cnt_cob <> 0) {
                                                while($row_cob = mysqli_fetch_array($result_cob)) {
                                                    extract($row_cob);    
                                                    $f_captura = strftime("%e-%b-%Y", strtotime($f_captura));
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $f_captura; ?></td>
                                                        <td><?php echo $nombre; ?></td> 
                                                        <td><?php echo $f_pago; ?></td> 
                                                        <td><?php echo $tipo; ?></td>
                                                        <td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
                                                    </tr>                                                    
                                                    <?php 
                                                } 
                                            } else {  
                                                // Si no hay resultados, muestra un mensaje indicándolo
                                                ?>
                                                <tr>
                                                    <th style="text-align: center" colspan="5"><i>Sin Resultados</i></th> 
                                                </tr>                                                    
                                                <?php 
                                            } 
                                            ?>
                                        </table>
                                    </div>
                                    <!-- Tabla que muestra los retiros -->
                                    <div class="col-md-12">
                                        <table style="width: 100%" class="table table-bordered">
                                            <tr>
                                                <th colspan="4" align="center"><h2 align="center"><B>Retiros</B></h2></th>
                                            </tr>                                              
                                            <tr>
                                                <th style="text-align: center">Fecha</th>
                                                <th style="text-align: center">Usuario</th>
                                                <th style="text-align: center">Usuario Retira</th>
                                                <th style="text-align: center">Importe</th>
                                            </tr>
                                            <?php
                                            // Consulta SQL para obtener los retiros en el mes y año seleccionados
                                            $sql_cob = "
                                                SELECT
                                                    retiros.retiros_id,
                                                    retiros.usuario_id,
                                                    retiros.usuario_id_retira,
                                                    retiros.f_captura,
                                                    retiros.h_captura,
                                                    retiros.importe,
                                                    admin.nombre as retiro,
                                                    adminx.nombre as usuario,
                                                    retiros.empresa_id 
                                                FROM
                                                    retiros
                                                    INNER JOIN admin ON retiros.usuario_id_retira = admin.usuario_id
                                                    INNER JOIN admin as adminx  ON retiros.usuario_id = adminx.usuario_id
                                                WHERE
                                                    retiros.empresa_id = $empresa_id
                                                    AND month(retiros.f_captura) = $mes_sel
                                                    AND year(retiros.f_captura) = $anio_sel                                                
                                                ORDER BY retiros.f_captura desc;
                                            ";
                                            // Ejecuta la consulta y obtiene el número de filas resultantes
                                            $result_cob = ejecutar($sql_cob);
                                            $cnt_cob = mysqli_num_rows($result_cob);
                                            
                                            // Si hay resultados, los muestra en la tabla
                                            if ($cnt_cob <> 0) {
                                                while($row_cob = mysqli_fetch_array($result_cob)) {
                                                    extract($row_cob);  
                                                    $f_captura = format_fecha_esp_dmy($f_captura);   
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $f_captura; ?></td> 
                                                        <td><?php echo $usuario; ?></td> 
                                                        <td><?php echo $retiro; ?></td>
                                                        <td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
                                                    </tr>                                                    
                                                    <?php 
                                                } 
                                            } else {  
                                                // Si no hay resultados, muestra un mensaje indicándolo
                                                ?>
                                                <tr>
                                                    <th style="text-align: center" colspan="4"><i>Sin Resultados</i></th> 
                                                </tr>                                                    
                                                <?php 
                                            } 
                                            ?>
                                        </table>
                                    </div>
                                    <!-- Botón para abrir el modal de retiro de efectivo -->
                                    <div align="center" class="col-md-12">
                                        <hr>
                                        <button type="button" class="btn bg-<?php echo $body; ?> waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Retirar</button>
                                        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form id="wizard_with_validation" method="POST"  >                                                    
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="defaultModalLabel">Retiro de Efectivo</h4>
                                                        </div>
                                                        <div id="contenido" class="modal-body">
                                                            <h3>Saldo pendiente: $<?php echo number_format($saldo); ?></h3>
                                                            <!-- Campos para el retiro de efectivo -->
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">attach_money</i>
                                                                </span> 
                                                                <div class="form-line">
                                                                    <input type="number" class="form-control" id="importe" name="importe" placeholder="Saldo a Retirar" value="" required >
                                                                </div>
                                                            </div>                                                        
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">person</i>
                                                                </span> 
                                                                <div class="form-line">
                                                                    <input type="email" class="form-control" id="usernamex" name="usernamex" placeholder="Correo electronico" value="" required >
                                                                </div>
                                                            </div>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">lock</i>
                                                                </span> 
                                                                <div class="form-line">
                                                                    <input type="password" class="form-control" id="passwordx" name="passwordx" placeholder="Contraseña" value="" autocomplete="off" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- Botón para confirmar el retiro -->
                                                            <button id="retira" type="button" class="btn btn-link waves-effect">RETIRAR</button>
                                                            <button id="submit_test" type="submit" style="display: none" class="btn btn-link waves-effect">RETIRAR</button>
                                                            <script>
                                                                // Script para validar el formulario y enviar los datos por AJAX
                                                                $('#retira').click(function() {          
                                                                    var emptyFields = $('#wizard_with_validation').find('input[required], select[required], textarea[required]').filter(function() {
                                                                        return this.value === '';
                                                                    });
                                                                    if (emptyFields.length > 0) {
                                                                        emptyFields.each(function() {
                                                                            $('#submit_test').click();
                                                                        });
                                                                    } else {                           
                                                                        var datastring = $('#wizard_with_validation').serialize();
                                                                        $('#contenido').html('');
                                                                        $.ajax({
                                                                            url: 'guarda_retiro.php', 
                                                                            type: 'POST',
                                                                            data: datastring,
                                                                            cache: false,
                                                                            success:function(html) {     
                                                                                $('#contenido').html(html); 
                                                                                $('#retira').hide();
                                                                            }
                                                                        });                         
                                                                    }        
                                                                });  
                                                            </script>
                                                            <!-- Botón para cerrar el modal -->
                                                            <a class="btn btn-link waves-effect" href="administracion.php" role="button">CERRAR</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>    
                                        <hr>        
                                    </div>    
                                    <!-- Tabla que muestra los abonos -->
                                    <div class="col-md-12">
                                        <table style="width: 70%"  class="table table-bordered">
                                            <tr>
                                                <th colspan="4" align="center"><h2 align="center"><B>Abonos</B></h2></th>
                                            </tr>                                              
                                            <tr>
                                                <th style="text-align: center">Fecha</th>
                                                <th style="text-align: center">Usuario</th>
                                                <th style="text-align: center">Usuario Abona</th>
                                                <th style="text-align: center">Importe</th>
                                            </tr>
                                            <?php
                                            // Consulta SQL para obtener los abonos en el mes y año seleccionados
                                            $sql_cob = "
                                                SELECT
                                                    abonos.abono_id,
                                                    abonos.usuario_id,
                                                    abonos.usuario_id_abona,
                                                    abonos.f_captura,
                                                    abonos.h_captura,
                                                    abonos.importe,
                                                    admin.nombre as abona,
                                                    admin2.nombre as usuario,
                                                    admin.empresa_id 
                                                FROM
                                                    abonos
                                                    INNER JOIN admin ON abonos.usuario_id_abona = admin.usuario_id 
                                                    INNER JOIN admin as admin2 ON abonos.usuario_id = admin2.usuario_id
                                                WHERE
                                                    abonos.empresa_id = $empresa_id
                                                    AND month(abonos.f_captura) = $mes_sel
                                                    AND year(abonos.f_captura) = $anio_sel                                                        
                                                ORDER BY abonos.f_captura desc
                                            ";
                                            // Ejecuta la consulta y obtiene el número de filas resultantes
                                            $result_cob = ejecutar($sql_cob); 
                                            $cnt_cob = mysqli_num_rows($result_cob);
                                            
                                            // Si hay resultados, los muestra en la tabla
                                            if ($cnt_cob <> 0) {
                                                while($row_cob = mysqli_fetch_array($result_cob)) {
                                                    extract($row_cob);  
                                                    $f_captura = format_fecha_esp_dmy($f_captura);   
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $f_captura; ?></td> 
                                                        <td><?php echo $usuario; ?></td> 
                                                        <td><?php echo $abona; ?></td> 
                                                        <td align="right">$&nbsp;<?php echo number_format($importe); ?></td>
                                                    </tr>                                                    
                                                    <?php 
                                                } 
                                            } else {  
                                                // Si no hay resultados, muestra un mensaje indicándolo
                                                ?>
                                                <tr>
                                                    <th style="text-align: center" colspan="4"><i>Sin Resultados</i></th> 
                                                </tr>                                                    
                                                <?php 
                                            } 
                                            ?>
                                        </table>
                                    </div>                                          
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>              
    </div>
</section>

<?php  
// Incluye el archivo footer1.php, que contiene configuraciones y scripts comunes para el pie de página
include($ruta . 'footer1.php');  
?>

<!-- Scripts JS -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

<?php  
// Incluye el archivo footer2.php, que contiene la segunda parte del pie de página y el cierre del cuerpo del documento
include($ruta . 'footer2.php');  
?>