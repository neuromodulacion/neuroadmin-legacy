<?php
// Define la ruta base para las inclusiones de archivos
$ruta = "../";
$titulo = "Balance Mensual"; // Título de la página


// Incluye el archivo header1.php, que contiene configuraciones y elementos comunes de la cabecera
include($ruta . 'header1.php');

// Verifica si "fechaInput" existe en el arreglo $_POST
$fechaInput = $_POST['fechaInput'] ?? null;

// Si no está definido, puedes asignar un valor predeterminado
if (!$fechaInput) {
    // Usar la fecha actual como predeterminado
    $fechaInput = $anio . "-" . $mes_ahora; // Fecha en formato "YYYY-MM"
}

// Si no se ha recibido una fecha de entrada, se asigna la fecha actual
// if ($_POST['fechaInput'] == '') {
//     $fechaInput = $anio . "-" . $mes_ahora; // Fecha en formato "YYYY-MM"
// }

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

// Obtiene el mes y año seleccionados a partir de la fecha de entrada
$mes_sel = date('m', strtotime($fechaInput.'-01'));
$anio_sel = date('Y', strtotime($fechaInput.'-01'));

?>

<!-- Incluye los estilos y plugins CSS necesarios -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<link href="<?php echo $ruta; ?>css/style.css" rel="stylesheet">
<link href="<?php echo $ruta; ?>css/themes/all-themes.css" rel="stylesheet" />

<?php  
// Incluye el archivo header2.php, que contiene la segunda parte de la cabecera con la barra de navegación y el menú
include($ruta . 'header2.php'); 
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>BALANCE MENSUAL</h2>
            <?php echo $ubicacion_url; ?>
        </div>        
        <!-- Contenido principal de la página -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <h1 align="center">Balance Mensual</h1>
                        <div align="right">
                            <!-- Formulario para seleccionar un mes específico -->
                            <form action="balance_mes.php" method="post">
                                <input id="fechaInput" name="fechaInput" style="width: 180px" align="center" type="month" class="form-control" value="<?php echo $fechaInput; ?>"/>
                                <input id="us" name="us" align="center" type="hidden" class="form-control" value="<?php echo $us; ?>"/>
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
                        
                        <div align="center">
                            <h1>Entradas</h1>
                            <hr>
                            <!-- Botón para generar el reporte en Excel y enviarlo por correo -->
                            <?php if ($empresa_id == 1) { ?>
                                <button id="genera_excel" type="button" class="btn bg-teal waves-effect">Genera Excel y envia correo <i class="material-icons">mail_outline</i></button>
                            <?php } ?>
                            <div style="display: none" id="load_mail">
                                <h4>Generando Correo</h4><i class="material-icons">clear_all</i><i class="material-icons">mail_outline</i>
                                <div class="preloader pl-size-sm">                                  
                                    <div class="spinner-layer pl-purple">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>                                      
                            </div>

                            <script>
                                // Al hacer clic en el botón de generar Excel, se envía una solicitud AJAX
                                $('#genera_excel').click(function() {
                                    $('#respuesta').html('');
                                    $('#load_mail').show();
                                    $('#genera_excel').hide();
                                    var mes_sel = <?php echo $mes_sel; ?>;
                                    var anio_sel = <?php echo $anio_sel; ?>;
                                    var datastring = 'anio_sel=' + anio_sel + '&mes_sel=' + mes_sel;
                                    $.ajax({
                                        url: 'descargar_excel.php',
                                        type: 'POST',
                                        data: datastring,
                                        cache: false,
                                        success: function(html) {
                                            $('#respuesta').html(html);
                                            $('#load_mail').hide();
                                            $('#genera_excel').show();
                                        }
                                    });
                                });
                            </script>                                        
                            <p id="respuesta"></p>
                            <hr>

                            <!-- Muestra las tablas de cobros, pagos y balances -->
                            <div class="row">
                                <?php if ($emp_nombre == $us) { ?>
                                <div class="col-md-12">
                                    <h2 align="center"><B>Cobros de <?php echo $us; ?></B></h2>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">                                              
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 100px">Fecha</th>
                                                    <th style="text-align: center; width: 100px">Ticket</th>
                                                    <th style="text-align: center; width: 60px">Solicita Factura</th>
                                                    <th style="text-align: center">Paciente</th>
                                                    <th style="text-align: center; width: 180px">Usuario</th>
                                                    <th style="text-align: center; width: 100px">Forma de pago</th>
                                                    <th style="text-align: center; width: 80px">Tipo</th>
                                                    <th style="text-align: center; width: 80px">Importe</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: center; width: 100px">Fecha</th>
                                                    <th style="text-align: center; width: 100px">Ticket</th>
                                                    <th style="text-align: center; width: 60px">Solicita Factura</th>
                                                    <th style="text-align: center">Paciente</th>
                                                    <th style="text-align: center; width: 180px">Usuario</th>
                                                    <th style="text-align: center; width: 100px">Forma de pago</th>
                                                    <th style="text-align: center; width: 80px">Tipo</th>
                                                    <th style="text-align: center; width: 80px">Importe</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>                                            
                                            <?php
                                            // Consulta SQL para obtener los cobros del usuario en el mes y año seleccionados
                                            $sql_cob = "
                                                SELECT
                                                    cobros.cobros_id,
                                                    cobros.usuario_id,
                                                    cobros.tipo,
                                                    cobros.doctor,
                                                    cobros.consulta,
                                                    cobros.protocolo_ter_id,
                                                    cobros.f_pago,
                                                    cobros.importe,
                                                    cobros.f_captura,
                                                    cobros.h_captura,
                                                    cobros.otros,
                                                    cobros.paciente_id,
                                                    (
                                                    SELECT
                                                        CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente 
                                                    FROM
                                                        pacientes 
                                                    WHERE
                                                        pacientes.paciente_id = cobros.paciente_id 
                                                    ) AS paciente,
                                                        (
                                                    SELECT DISTINCT
                                                        CONCAT( paciente_consultorio.paciente, ' ', paciente_consultorio.apaterno, ' ', paciente_consultorio.amaterno ) AS paciente
                                                    FROM
                                                        paciente_consultorio 
                                                    WHERE
                                                        paciente_consultorio.paciente_cons_id = cobros.paciente_cons_id 
                                                    ) AS paciente_con,                                                
                                                    cobros.empresa_id,
                                                    admin.nombre, 
                                                    cobros.req_factura, 
                                                    cobros.ticket
                                                FROM
                                                    cobros
                                                    INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
                                                WHERE
                                                    cobros.empresa_id = $empresa_id 
                                                    AND cobros.doctor = '$us'
                                                    AND MONTH(cobros.f_captura) = $mes_sel
                                                    AND YEAR(cobros.f_captura) = $anio_sel
                                                ORDER BY
                                                    cobros.f_captura DESC                                              
                                            ";
                                               // echo $sql_cob."<br>";
                                            // Ejecuta la consulta SQL y muestra los resultados en la tabla
                                                $result_cob = ejecutar($sql_cob); 
                                                $cnt_cob = mysqli_num_rows($result_cob);
                                                if ($cnt_cob <> 0) {
                                                    while($row_cob = mysqli_fetch_array($result_cob)) {
                                                        extract($row_cob);    
                                                        $f_captura = format_fecha_esp_dmy($f_captura);
                                                        if ($paciente == '') {
                                                            $paciente = $paciente_con;
                                                        } 
                                                        if ($paciente == '') {
                                                            $paciente = $consulta;
                                                            $paciente_id = '';
                                                        }                                                       
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center"><?php echo $f_captura . " T " . $h_captura; ?></td>
                                                            <td>
                                                                <a target="_blank" href="pdf_html.php?ticket=<?php echo $ticket; ?>" role="button"><?php echo $ticket; ?></a>
                                                            </td> 
                                                            <td style="text-align: center"><?php echo $req_factura; ?></td>
                                                            <td><?php echo $paciente_id . " - " . codificacionUTF($paciente); ?></td>
                                                            <td><?php echo codificacionUTF($nombre); ?></td>
                                                            <td><?php echo $f_pago; ?></td> 
                                                            <td><?php echo codificacionUTF($tipo); ?></td>
                                                            <td align="right">$&nbsp;<?php echo number_format($importe, 2); ?></td>
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
                                            </tbody>    
                                        </table>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <div class="col-md-12">
                                    <h3 align="center"><b><h2 align="center"><B>Cobros de Consultas del <?php echo $us; ?></B></h2></b></h3>
                                    <div class="table-responsive">
                                        <table id="cobros_tabla" class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 100px">Fecha</th>
                                                    <th style="text-align: center; width: 100px">Ticket</th>
                                                    <th style="text-align: center; width: 60px">Solicita Factura</th>
                                                    <th style="text-align: center">Paciente</th>
                                                    <th style="text-align: center; width: 180px">Usuario</th>
                                                    <th style="text-align: center; width: 100px">Forma de pago</th>
                                                    <th style="text-align: center; width: 80px">Tipo</th>
                                                    <th style="text-align: center; width: 80px">Importe</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: center; width: 100px">Fecha</th>
                                                    <th style="text-align: center; width: 100px">Ticket</th>
                                                    <th style="text-align: center; width: 60px">Solicita Factura</th>
                                                    <th style="text-align: center">Paciente</th>
                                                    <th style="text-align: center; width: 180px">Usuario</th>
                                                    <th style="text-align: center; width: 100px">Forma de pago</th>
                                                    <th style="text-align: center; width: 80px">Tipo</th>
                                                    <th style="text-align: center; width: 80px">Importe</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>                                            
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
                                                    cobros.paciente_cons_id,
                                                    cobros.paciente_consulta,                                                    
                                                    cobros.empresa_id,
                                                    cobros.consulta,
                                                    admin.nombre, 
                                                    cobros.req_factura,
                                                    cobros.ticket
                                                FROM
                                                    cobros
                                                    INNER JOIN admin ON cobros.usuario_id = admin.usuario_id 
                                                WHERE
                                                    cobros.empresa_id = $empresa_id 
                                                    AND cobros.tipo = 'Consulta Medica'
                                                    AND MONTH(f_captura) = $mes_sel
                                                    AND YEAR(f_captura) = $anio_sel
                                                    AND cobros.doctor = '$us'
                                                ORDER BY
                                                    cobros.f_captura DESC                                              
                                            ";
                                                // Ejecuta la consulta SQL y muestra los resultados en la tabla
                                                $result_cob = ejecutar($sql_cob); 
                                                $cnt_cob = mysqli_num_rows($result_cob);
                                                if ($cnt_cob <> 0) {
                                                    while($row_cob = mysqli_fetch_array($result_cob)) {
                                                        extract($row_cob);  
                                                        $f_captura = format_fecha_esp_dmy($f_captura);  
                                                        ?>
                                                        <tr>
                                                            <td style="text-align: center"><?php echo $f_captura . " T " . $h_captura; ?></td>
                                                            <td>
                                                                <a target="_blank" href="https://neuromodulaciongdl.com/caja/pdf_html.php?ticket=<?php echo $ticket; ?>" role="button"><?php echo $ticket; ?></a>
                                                            </td>
                                                            <td style="text-align: center"><?php echo $req_factura; ?></td> 
                                                            <td><?php echo "A-" . $paciente_cons_id . " - " . $paciente_consulta . "<br>" . $consulta; ?></td>
                                                            <td><?php echo codificacionUTF($nombre); ?></td>
                                                            <td><?php echo $f_pago; ?></td> 
                                                            <td><?php echo $tipo; ?></td>
                                                            <td align="right">$&nbsp;<?php echo number_format($importe, 2); ?></td>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php } ?>                                  
                                <div class="col-md-12"> 
                                </div>
                            </div>                                        
                        </div>
                        <div align="center">
                            <h1>Salidas</h1>
                            <hr>
                            <!-- Muestra la tabla de pagos -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 align="center"><b>Pagos</b></h3>
                                    <table class="table table-bordered">                                              
                                        <tr>
                                            <th style="text-align: center;">Fecha</th>
                                            <th style="text-align: center">Usuario</th>
                                            <th style="text-align: center">Forma de pago</th>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Concepto</th>
                                            <th style="text-align: center">Importe</th>
                                        </tr>
                                        <?php
                                        // Consulta SQL para obtener los pagos realizados en el mes y año seleccionados
                                        $sql_cob = "
                                            SELECT
                                                pagos.pagos_id,
                                                pagos.usuario_id,
                                                pagos.empresa_id,
                                                pagos.f_captura,
                                                pagos.h_captura,
                                                pagos.importe,
                                                pagos.tipo,
                                                pagos.f_pago,
                                                pagos.concepto,
                                                pagos.terapeuta AS terapeuta_id,
                                                ( SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.terapeuta ) AS terapeuta,
                                                ( SELECT ad.nombre FROM admin AS ad WHERE ad.usuario_id = pagos.usuario_id ) AS usuario
                                            FROM
                                                pagos
                                            WHERE
                                                pagos.empresa_id = $empresa_id 
                                                AND MONTH(pagos.f_captura) = $mes_sel
                                                AND YEAR(pagos.f_captura) = $anio_sel
                                                AND negocio = '$us'
                                            ORDER BY
                                                pagos.f_captura DESC                                              
                                        ";
                                            // Ejecuta la consulta SQL y muestra los resultados en la tabla
                                            $result_cob = ejecutar($sql_cob); 
                                            $cnt_cob = mysqli_num_rows($result_cob);
                                            if ($cnt_cob <> 0) {
                                                while($row_cob = mysqli_fetch_array($result_cob)) {
                                                    extract($row_cob);    
                                                    $f_captura = format_fecha_esp_dmy($f_captura);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $f_captura; ?></td> 
                                                        <td><?php echo $usuario; ?></td>
                                                        <td><?php echo $f_pago; ?></td> 
                                                        <td><?php echo codificacionUTF($tipo); ?></td>
                                                        <td><?php echo codificacionUTF($terapeuta . $concepto); ?></td>
                                                        <td align="right">$&nbsp;<?php echo number_format($importe, 2); ?></td>
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
                                <div class="col-md-12"> 
                                </div>
                            </div>                                        
                        </div>   
                        <div align="center">
                            <h1>Balance</h1>
                            <hr>
                            <!-- Muestra el balance de entradas y salidas -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>Entradas</h1>
                                </div>
                                <div class="col-md-6">
                                    <table style="width: 100%; font-size: 25px" class="table table-bordered">                                              
                                        <tr>
                                            <th style="text-align: center">Forma de pago</th>
                                            <th style="text-align: center">Importe</th>
                                        </tr>
                                        <?php
                                        // Consulta SQL para obtener los cobros agrupados por forma de pago
                                        $sql_cobro = "
                                            SELECT
                                                cobros.f_pago,
                                                sum(cobros.importe) as total
                                            FROM
                                                cobros 
                                            WHERE
                                                cobros.empresa_id = $empresa_id 
                                                AND MONTH ( cobros.f_captura ) = '$mes_sel' 
                                                AND YEAR ( cobros.f_captura ) = '$anio_sel' 
                                                AND cobros.doctor = '$us'
                                            GROUP BY 1
                                            ORDER BY
                                                cobros.f_pago ASC                                              
                                        ";
                                        $Gtotal = 0;
                                        $result_cob = ejecutar($sql_cobro);
                                        while($row_cob = mysqli_fetch_array($result_cob)){
                                            extract($row_cob);    
                                            $Gtotal = $Gtotal + $total;
                                        ?>
                                        <tr>
                                            <td><?php echo $f_pago ; ?></td>
                                            <td style="text-align: right"> $ <?php echo number_format($total, 2) ; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total</td>
                                            <td style="text-align: right"> $ <?php echo number_format($Gtotal, 2) ; ?></td>
                                        </tr>                                              
                                    </table>                                        
                                </div>
                                <div class="col-md-6">
                                    <table style="width: 100%;  font-size: 25px" class="table table-bordered">                                              
                                        <tr>
                                            <th style="text-align: center">Tipo</th>
                                            <th style="text-align: center">Importe</th>
                                        </tr>
                                        <?php
                                        // Consulta SQL para obtener los cobros agrupados por tipo de cobro
                                        $sql_cobro = "
                                            SELECT
                                                cobros.tipo,
                                                sum(cobros.importe) as total
                                            FROM
                                                cobros 
                                            WHERE
                                                cobros.empresa_id = $empresa_id 
                                                AND MONTH ( cobros.f_captura ) = '$mes_sel' 
                                                AND YEAR ( cobros.f_captura ) = '$anio_sel' 
                                                AND cobros.doctor = '$us'
                                            GROUP BY 1
                                            ORDER BY
                                                cobros.f_pago ASC                                              
                                        ";
                                        $Gtotal = 0;
                                        $result_cob = ejecutar($sql_cobro);
                                        while($row_cob = mysqli_fetch_array($result_cob)){
                                            extract($row_cob);    
                                            $Gtotal = $Gtotal + $total;
                                            $Gtotal_cobros = $Gtotal;
                                        ?>
                                        <tr>
                                            <td><?php echo $tipo ; ?></td>
                                            <td style="text-align: right"> $ <?php echo number_format($total, 2) ; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total</td>
                                            <td style="text-align: right"> $ <?php echo number_format($Gtotal, 2) ; ?></td>
                                        </tr>
                                    </table>                                        
                                </div>
                                <div class="col-md-12">
                                    <h1>Salidas</h1>
                                </div>
                                <div class="col-md-6">
                                    <table style="width: 600px; font-size: 25px" class="table table-bordered">                                              
                                        <tr>
                                            <th style="text-align: center">Forma de pago</th>
                                            <th style="text-align: center">Importe</th>
                                        </tr>
                                        <?php
                                        // Consulta SQL para obtener los pagos agrupados por forma de pago
                                        $sql_cobro = "
                                            SELECT
                                                pagos.f_pago, 
                                                sum(pagos.importe) as total
                                            FROM
                                                pagos
                                            WHERE
                                                pagos.empresa_id = $empresa_id 
                                                AND MONTH ( pagos.f_captura ) = '$mes_sel' 
                                                AND YEAR ( pagos.f_captura ) = '$anio_sel' 
                                                AND pagos.negocio = '$us'
                                            GROUP BY 1
                                            ORDER BY
                                                pagos.f_pago ASC                                              
                                        ";
                                        $Gtotal = 0;
                                        $result_cob = ejecutar($sql_cobro);
                                        while($row_cob = mysqli_fetch_array($result_cob)){
                                            extract($row_cob);    
                                            $Gtotal = $Gtotal + $total;
                                        ?>
                                        <tr>
                                            <td><?php echo $f_pago ; ?></td>
                                            <td style="text-align: right"> $ <?php echo number_format($total, 2) ; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total</td>
                                            <td style="text-align: right"> $ <?php echo number_format($Gtotal, 2) ; ?></td>
                                        </tr>
                                    </table>                                        
                                </div>
                                <div class="col-md-6">
                                    <table style="width: 600px; font-size: 25px" class="table table-bordered">                                              
                                        <tr>
                                            <th style="text-align: center">Tipo de pago</th>
                                            <th style="text-align: center">Importe</th>
                                        </tr>
                                        <?php
                                        // Consulta SQL para obtener los pagos agrupados por tipo de pago
                                        $sql_cobro = "
                                            SELECT
                                                pagos.tipo, 
                                                sum(pagos.importe) as total
                                            FROM
                                                pagos
                                            WHERE
                                                pagos.empresa_id = $empresa_id 
                                                AND MONTH ( pagos.f_captura ) = '$mes_sel' 
                                                AND YEAR ( pagos.f_captura ) = '$anio_sel' 
                                                AND pagos.negocio = '$us'
                                            GROUP BY 1
                                            ORDER BY
                                                pagos.f_pago ASC                                              
                                        ";
                                        $Gtotal = 0;
                                        $result_cob = ejecutar($sql_cobro);
                                        while($row_cob = mysqli_fetch_array($result_cob)){
                                            extract($row_cob);    
                                            $Gtotal = $Gtotal + $total;
                                            $Gtotal_pagos = $Gtotal;
                                        ?>
                                        <tr>
                                            <td><?php echo $tipo ; ?></td>
                                            <td style="text-align: right"> $ <?php echo number_format($total, 2) ; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Total</td>
                                            <td style="text-align: right"> $ <?php echo number_format($Gtotal, 2) ; ?></td>
                                        </tr>
                                    </table>                                        
                                </div>                                                                                                    

                                <div class="col-md-12">
                                    <!-- Muestra el balance final de pagos y cobros -->
                                    <h1 align="center"><b><?php echo $us; ?></b></h1>
                                    <table style="width: 80%; font-size: 25px" class="table table-bordered">                                              
                                        <tr>
                                            <th style="text-align: center">Mes</th>
                                            <th style="text-align: center">Pagos</th>
                                            <th style="text-align: center">Cobros</th>
                                            <th style="text-align: center">Diferencia</th>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td><?php echo OptieneMesLargo($mes_sel) . " " . $anio_sel; ?></td> 
                                            <td>$ <?php echo number_format($Gtotal_pagos, 2); ?></td>
                                            <td>$ <?php echo number_format($Gtotal_cobros, 2); ?></td> 
                                            <td>$ <?php echo number_format(($Gtotal_cobros - $Gtotal_pagos), 2); ?></td>
                                        </tr>                                                    
                                    </table>
                                    
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

<!-- Incluye los scripts JS necesarios -->
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

<script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>

<?php  
// Incluye el archivo footer2.php, que contiene la segunda parte del pie de página y el cierre del cuerpo del documento
include($ruta . 'footer2.php'); 
?>
