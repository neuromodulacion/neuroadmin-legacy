<?php
// Definir ruta base y variables iniciales
$ruta = "../";
$a = "";
$ticket = "";
$titulo = "Cobros";

// Incluir archivos de cabecera
include($ruta . 'header1.php');
?>
<!-- Incluir estilos necesarios -->
<!-- JQuery DataTable Css -->
<link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
<!-- Bootstrap DatePicker Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<!-- Wait Me Css -->
<link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />
<!-- Bootstrap Css -->
<link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php include($ruta . 'header2.php'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>COBROS</h2> 
            <?php echo $ubicacion_url; ?>                 
        </div>
        <!-- Contenido principal -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="height: 95%" class="header">
                        <!-- Botón de modal oculto -->
                        <button style="display: none" id="modal" type="button" class="btn btn-default waves-effect" data-toggle="modal" data-target="#smallModal">MODAL - SMALL SIZE</button>
                        <!-- Modal para mostrar pago realizado -->
                        <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="smallModalLabel">Aviso</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h2 style="color: green" align="center"><b>Pago Realizado</b></h2>
                                        <p style="color: green; font-size: 24px" align="center"><i class="material-icons">done</i><br>Ok</p>
                                        <p style="color: green; font-size: 16px" align="center"><br>Ticket - <?php echo $ticket; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <a target="_blank" class="btn bg-<?php echo $body; ?> waves-effect" href="https://neuromodulaciongdl.com/caja/ticket.php?ticket=<?php echo $ticket; ?>" role="button">IMPRIME TICKET</a>
                                        <a target="_blank" class="btn bg-<?php echo $body; ?> waves-effect" href="https://neuromodulaciongdl.com/caja/pdf_html.php?ticket=<?php echo $ticket; ?>" role="button">DESCARGA RECIBO</a>
                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h1 align="center">Cobros</h1>
                        <hr>
                        <div class="body">
                            <!-- Formulario principal para guardar cobro -->
                            <form id="wizard_with_validation" method="POST" action="guarda_cobro.php">
                                <h3>Tipo de cobro</h3>
                                <fieldset>
                                    <div class="demo-radio-button">
                                        <input type="hidden" id="paciente_cons_id" name="paciente_cons_id" value="" />
                                        <input type="hidden" id="tipo_c" name="tipo_c" value="" />
                                        <input style='height: 0px; width: 0px' name="val_tipo" type="text" id="val_tipo" value="" required />
                                        <!-- Opciones de tipo de cobro -->
                                        <input name="tipo" type="radio" id="radio_1" value="Consulta Medica" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radio_1">Consulta Medica</label>
                                        <script type='text/javascript'>
                                            $('#radio_1').change(function() {
                                                $('#val_tipo').val('ok');
                                                $('#medico').show();
                                                $('#terapia').hide();
                                                $('#paciente').hide(); //registro de pacientes
                                                $('#otro').hide();
                                                
                                                $('#doctor').val("");
                                                $("#doctor1").prop('disabled', false);
                                                $("#consultaxx").prop('disabled', false);
                                                $("#paciente_consulta").prop('disabled', false);
                                                $("#paciente_consultax").prop('disabled', false);
                                                
                                                $("#radio_cons1").prop('disabled', false);
                                                $("#radio_cons2").prop('disabled', false);
                                                $("#radio_cons3").prop('disabled', false);					                                   
                                                $("#costos_id").prop('disabled', true);
                                                $("#terapia").prop('disabled', true);
                                                $("#paciente").prop('disabled', true);
                                                
                                                $("#paciente_id").prop('disabled', true); 
                                                $("#otros").prop('disabled', true);
                                                $('#consulta').val('Consulta Medica');
                                                $('#tipo_c').val('Consulta Medica');
                                            });
                                        </script>
                                        <input name="tipo" type="radio" id="radio_2" value="Terapia" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radio_2">Terapia</label>
                                        <script type='text/javascript'>
                                            $('#radio_2').change(function() {
                                                $('#val_tipo').val('ok');
                                                $('#medico').hide();
                                                $('#terapia').show();
                                                $('#paciente').show(); //registro de pacientes
                                                $('#otro').hide();
                                                
                                                $('#doctor').val("<?php echo $emp_nombre; ?>");
                                                $("#doctor1").prop('disabled', true);
                                                $("#consultaxx").prop('disabled', true);
                                                $("#paciente_consulta").prop('disabled', false);
                                                $("#paciente_consultax").prop('disabled', false);
                                                
                                                $("#radio_cons1").prop('disabled', true);
                                                $("#radio_cons2").prop('disabled', true);
                                                $("#radio_cons3").prop('disabled', true);
                                                $("#costos_id").prop('disabled', false);
                                                $("#terapia").prop('disabled', false);
                                                $("#paciente").prop('disabled', false);
                                                
                                                $("#paciente_id").prop('disabled', false);	 								                    
                                                $("#otros").prop('disabled', true);	
                                                $('#consulta').val('Terapia');		
                                                $('#tipo_c').val('Terapia');						                    
                                            });
                                        </script>
                                        <input name="tipo" type="radio" id="radio_3" value="Renta Consultorio" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radio_3">Renta Consultorio</label>
                                        <script type='text/javascript'>
                                            $('#radio_3').change(function() {
                                                $('#val_tipo').val('ok');
                                                $('#medico').hide();
                                                $('#terapia').hide();
                                                $('#paciente').hide(); //registro de pacientes
                                                $('#otro').hide();
                                                
                                                $('#doctor').val("Renta Consultorio");
                                                $("#doctor1").prop('disabled', true);
                                                $("#consultaxx").prop('disabled', true);
                                                $("#paciente_consulta").prop('disabled', true);	
                                                $("#paciente_consultax").prop('disabled', true);	
                                                			                   
                                                $("#radio_cons1").prop('disabled', true);
                                                $("#radio_cons2").prop('disabled', true);
                                                $("#radio_cons3").prop('disabled', true);					                    					                    
                                                $("#costos_id").prop('disabled', true);
                                                $("#terapia").prop('disabled', true);
                                                $("#paciente").prop('disabled', true);
                                                
                                                $("#paciente_id").prop('disabled', true); 								                    
                                                $("#otros").prop('disabled', true);		
                                                $('#consulta').val('Renta Consultorio');	
                                                $('#tipo_c').val('Renta Consultorio');						                    
                                            });
                                        </script>
                                        <input name="tipo" type="radio" id="radio_4" value="Otros" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radio_4">Otros</label>
                                        <script type='text/javascript'>
                                            $('#radio_4').change(function() {
                                                $('#val_tipo').val('ok');
                                                $('#medico').hide();
                                                $('#terapia').hide();
                                                $('#paciente').hide(); //registro de pacientes
                                                $('#otro').show();
                                                
                                                $('#doctor').val("<?php echo $emp_nombre; ?>");
                                                $("#doctor1").prop('disabled', true);
                                                $("#consultaxx").prop('disabled', true);
                                                $("#paciente_consulta").prop('disabled', true);	
                                                $("#paciente_consultax").prop('disabled', true);
                                                				                   
                                                $("#radio_cons1").prop('disabled', true);
                                                $("#radio_cons2").prop('disabled', true);
                                                $("#radio_cons3").prop('disabled', true);					                    					                    
                                                $("#costos_id").prop('disabled', true);
                                                $("#terapia").prop('disabled', true);
                                                $("#paciente").prop('disabled', true);
                                                $("#paciente_id").prop('disabled', true);
                                                									                    
                                                $("#otros").prop('disabled', false);		
                                                $('#consulta').val('Otros');	
                                                $('#tipo_c').val('Otros');						                    
                                            });
                                        </script>
                                    </div>
                                    <hr>
                                    <!-- Selección de doctor y tipo de consulta para "Consulta Medica" -->
                                    <div id="medico" style="display: none" class="form-group form-float">
                                        <input type="hidden" value="" id="doctor" name="doctor" />
                                        <label for="doctor_">Doctor *</label>
                                        <select class='form-control show-tick' id="doctor1" name="doctor1" required>
                                            <option value="">-- Selecciona Doctor--</option>
                                            <?php
                                            $sql_medico = "
                                                SELECT
                                                    medicos.medico_id,
                                                    medicos.medico,
                                                    medicos.empresa_id,
                                                    medicos.LocationID 
                                                FROM
                                                    medicos 
                                                WHERE
                                                    medicos.empresa_id = $empresa_id
                                            ";
                                            $result_medico = ejecutar($sql_medico);
                                            while ($row_medico = mysqli_fetch_array($result_medico)) { 
                                                extract($row_medico); ?>
                                                <option value="<?php echo $medico; ?>"><?php echo $medico; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            $('#doctor1').change(function() {
                                                var doctor = $('#doctor1').val();
                                                $('#doctor').val(doctor);
                                                $('#paciente').show();
                                            });
                                        </script>
                                        <hr>
                                        <label for="consulta">Tipo consulta</label>
                                        <input style='height: 0px; width: 0px' name="consultaxx" type="text" id="consultaxx" value="" required />
                                        <input name="consultax" type="radio" id="radio_cons1" value="Cita primera vez" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radio_cons1">Cita primera vez</label>
                                        <input name="consultax" type="radio" id="radio_cons2" value="Cita ordinaria" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radio_cons2">Cita ordinaria</label>
                                        <script>
                                            $(document).ready(function() {
                                                $('input[type="radio"][name="consultax"]').change(function() {
                                                    $('#consulta').val(this.value);
                                                    $('#consultaxx').val(this.value);
                                                });
                                                $('#otros').on('input', function() {
                                                    $('#consulta').val($(this).val());
                                                });
                                            });
                                        </script>
                                        <hr>
                                    </div>
                                    <!-- Selección de paquete para "Terapia" -->
                                    <div id="terapia" style="display: none" class="form-group form-float">
                                        <label class="form-label">Paquete*</label>
                                        <select class='form-control show-tick' id="costos_id" name="costos_id" required>
                                            <option value="">Selecciona Paquete</option>
                                            <?php
                                            $sql_costo = "
                                                SELECT
                                                    costos_productos.costos_id, 
                                                    costos_productos.producto, 
                                                    costos_productos.costos, 
                                                    costos_productos.sesiones,
                                                    costos_productos.ID, 
													costos_productos.descripcion
                                                FROM
                                                    costos_productos
                                                WHERE
                                                    costos_productos.empresa_id = $empresa_id";
                                            $result_costo = ejecutar($sql_costo);
                                            while ($row_costo = mysqli_fetch_array($result_costo)) {
                                                extract($row_costo); ?>
                                                <option value="<?php echo $costos_id; ?>|<?php echo $producto; ?>|<?php echo $costos; ?>|<?php echo $sesiones; ?>|<?php echo $ID; ?>|<?php echo $descripcion; ?>"><?php echo $producto . " - $ " . number_format($costos); ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                            $(document).ready(function() {
                                                $('#costos_id').change(function() {
                                                    var valoresConcatenados = $(this).val();
                                                    var valores = valoresConcatenados.split('|');
                                                    var costos = valores[2];
                                                    var sesiones = valores[3];
                                                    $('#importe').val(costos);
                                                    $('#cantidad').val(sesiones);
                                                    $('#consulta').val(valores[1]);
                                                    $('#ID').val(valores[4]);
                                                    $('#descripcion').val(valores[5]);
                                                });
                                            });
                                        </script>
                                        <input type="hidden" name="doctor1" value="" />
                                    </div>
                                    <!-- Selección de paciente -->
                                    <div id="paciente" style="display: none" class="form-group form-float">
                                        <input type="hidden" name="costos_id_ter_id1" value="0" />
                                        <label for="paciente_">Paciente</label>
                                        <p style="text-decoration: underline; text-align: center" id="info_busca">
                                            <i>Busca primero el paciente con algunos de los datos como nombre, apellidos, celular o correo y seleccionalo para continuar</i>
                                            <br>
                                        </p>
                                        <input style='height: 0px; width: 0px' name="paciente_consultax" type="text" id="paciente_consultax" value="" required />
                                        <div style="display: none" id="info_cliente" class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="paciente_consulta" name="paciente_consulta" class="form-control" placeholder="Paciente" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="nombre_busca">Nombre</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="paciente_c" name="paciente" class="form-control" placeholder="Nombre">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="apaterno_busca">Apellido Paterno</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="apaterno" name="apaterno" class="form-control" placeholder="Apellido Paterno">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="amaterno_busca">Apellido Materno</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="amaterno" name="amaterno" class="form-control" placeholder="Apellido Materno">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="telefono_busca">Teléfono</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="celular" name="celular" class="form-control" placeholder="Teléfono">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="email_busca">Correo</label>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="email" id="mail" name="email" class="form-control" placeholder="Correo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" id="buscar_paciente" class="btn bg-purple waves-effect" data-toggle="modal" data-target="#Modal_busca" data-toggle="tooltip" data-placement="top" title="Buscar">
                                                    <i class="material-icons">search</i>
                                                </button>
                                                <script>
                                                    $('#buscar_paciente').click(function() {
                                                        $('#contenido_busca').html('');
                                                        var doctor = $('#doctor1').val();
                                                        var paciente = $('#paciente_c').val();
                                                        var apaterno = $('#apaterno').val();
                                                        var amaterno = $('#amaterno').val();
                                                        var celular = $('#celular').val();
                                                        var email = $('#mail').val();
                                                        var tipo_c = $('#tipo_c').val();
                                                        var datastring = 'paciente=' + paciente + '&tipo_c=' + tipo_c + '&apaterno=' + apaterno + '&amaterno=' + amaterno + '&celular=' + celular + '&email=' + email + '&doctor=' + doctor;
                                                        $.ajax({
                                                            url: 'busca_paciente.php',
                                                            type: 'POST',
                                                            data: datastring,
                                                            cache: false,
                                                            success: function(html) {
                                                                $('#contenido_busca').html(html);
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <button type="button" id="limpiar_paciente" class="btn bg-cyan waves-effect" data-toggle="tooltip" data-placement="top" title="Limpiar">
                                                    <i class="material-icons">delete_sweep</i>
                                                </button>
                                                <script>
                                                    $('#limpiar_paciente').click(function() {
                                                        $('#paciente_consulta').val("");
                                                        $('#paciente_c').val("");
                                                        $('#apaterno').val("");
                                                        $('#amaterno').val("");
                                                        $('#celular').val("");
                                                        $('#mail').val("");
                                                        $('#paciente_id').val("");
                                                        $('#paciente_cons_id').val("");
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <!-- Modal para buscar paciente -->
                                        <div class="modal fade" id="Modal_busca" tabindex="-1" role="dialog">
                                            <div style="width: 90%" class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="Modal_buscaLabel">Busca Pacientes</h4>
                                                    </div>
                                                    <div id="contenido_busca" class="modal-body"></div>
                                                    <div class="modal-footer">
                                                        <button id="cerrar_modal" type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                               
                                        
                                    </div>
                                    <input style="height: 0px; width: 0px" type="text" id="consulta" name="consulta" value="" required />
                                    <input type="hidden" id="paciente_id" name="paciente_id" value="" required />
                                    <input type="hidden" name="ID" id="ID" value="" />
                                    <input type="hidden" name="descripcion" id="descripcion" value="" />
                                    <!-- Sección para "Otros" -->
                                    <div id="otro" style="display: none" class="form-group form-float">
                                        <?php if ($funcion == 'SISTEMAS' || $funcion == 'ADMINISTRADOR') { ?>
                                            <label class="form-label">Otros</label>
                                            <select name="otros_id" class='form-control show-tick' id="otros_id">
                                                <option value="">Seleccionar Otros</option>
                                                <?php
                                                $sql_paciente = "
                                                    SELECT
                                                        otros_menu.otros_id, 
                                                        otros_menu.otros
                                                    FROM
                                                        otros_menu
                                                    WHERE
                                                        otros_menu.empresa_id = $empresa_id
                                                    ORDER BY 2 asc";
                                                $result_paciente = ejecutar($sql_paciente);
                                                while ($row_paciente = mysqli_fetch_array($result_paciente)) {
                                                    extract($row_paciente); ?>
                                                    <option value="<?php echo $otros; ?>"><?php echo $otros; ?></option>
                                                <?php } ?>
                                                <option value="Otros">Otros</option>
                                            </select>
                                            <script>
                                                $('#otros_id').change(function() {
                                                    var otros = $('#otros_id').val();
                                                    if (otros !== 'Otros') {
                                                        $('#otros').val(otros);
                                                        $('#otros').click();
                                                    } else {
                                                        $('#otros').val('');
                                                    }
                                                });
                                            </script>
                                            <hr>
                                        <?php } ?>
                                        <div class="form-line">
                                            <input type="tel" class="form-control" id="otros" name="otros" required>
                                            <label class="form-label">Otros*</label>
                                        </div>
                                    </div>
                                    <!-- Selección de cantidad e importe -->
                                    <div class="row clearfix">
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input style="text-align: center" type="text" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad" value="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon">$</span>
                                                <div class="form-line">
                                                    <input type="text" id="importe" name="importe" class="form-control" placeholder="Importe" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('importe').addEventListener('input', function (e) {
                                            this.value = this.value.replace(/[^0-9]/g, '');
                                        });
                                    </script>
                                    <!-- Selección de si desea factura -->
                                    <div class="demo-radio-button">
                                        <label class="form-label">Desea factura</label>
                                        <input style='height: 0px; width: 0px' name="fac_tipo" type="text" id="fac_tipox" value="" required />
                                        <input name="fact1" type="radio" id="factura_1" value="Si" class="radio-col-<?php echo $body; ?>" />
                                        <label for="factura_1">Si</label>
                                        <script type='text/javascript'>
                                            $('#factura_1').change(function() {
                                                $('#fac_tipox').val('Si');
                                            });
                                        </script>
                                        <input name="fact1" type="radio" id="factura_2" value="No" class="radio-col-<?php echo $body; ?>" />
                                        <label for="factura_2">No</label>
                                        <script type='text/javascript'>
                                            $('#factura_2').change(function() {
                                                $('#fac_tipox').val('No');
                                            });
                                        </script>
                                    </div>
                                    <button style="display: none" type="button" id="modal_rfc" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button>
                                    <!-- Modal para validar datos del paciente -->
                                    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="largeModalLabel">Valida los datos del Paciente</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" id="cRFCx" name="cRFC" class="form-control" placeholder="RFC">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                                <button id="buscar_rfc" type="button" style="background: #0096AA; color: white" class="btn btn-lg m-l-15 waves-effect">
                                                                    BUSCAR
                                                                </button>
                                                                <script>
                                                                    $('#buscar_rfc').click(function() {
                                                                        $('#contenido2').html('');
                                                                        var cRFC = $('#cRFCx').val();
                                                                        var accion = "cobro";
                                                                        var ticket = '<?php echo $ticket; ?>';
                                                                        var rutas = '../facturacion/';
                                                                        if (cRFC !== '') {
                                                                            var datastring = 'cRFC=' + cRFC + '&ticket=' + ticket + '&accion=' + accion;
                                                                            $.ajax({
                                                                                url: '../facturacion/busca_rfc.php',
                                                                                type: 'POST',
                                                                                data: datastring,
                                                                                cache: false,
                                                                                success: function(html) {
                                                                                    $('#contenido2').html(html);
                                                                                }
                                                                            });
                                                                        } else {
                                                                            alert('Debes ingresar el numero de RFC');
                                                                        }
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>
                                                        <div id="contenido2"></div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
		                                <div align="center" style="display: none" id="load" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			                                <div  class="preloader pl-size-xl">
			                                    <div class="spinner-layer pl-teal">
			                                        <div class="circle-clipper left">
			                                            <div class="circle"></div>
			                                        </div>
			                                        <div class="circle-clipper right">
			                                            <div class="circle"></div>
			                                        </div>
			                                    </div>
			                                </div> 
		                                    <h1>Procesando...</h1>		                                	
		                                </div>                                    
                                    <div>
                                        <label for="email_address">Correo electronico</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Ingresa el correo electronico">
                                            </div>
                                        </div>
                                    </div>
                                    <label class="form-label">Forma de pago</label>
                                    <div class="demo-radio-button">
                                        <input style='height: 0px; width: 0px' name="val_pago" type="text" id="val_pago" value="" required />
                                        <!-- Opciones de forma de pago -->
                                        <input name="f_pago" type="radio" id="radiox_1" value="Tarjeta Credito" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radiox_1">Tarjeta de Crédito</label>
                                        <script type='text/javascript'>
                                            $('#radiox_1').change(function() {
                                                $('#val_pago').val('ok');
                                            });
                                        </script>
                                        <input name="f_pago" type="radio" id="radiox_2" value="Tarjeta Debito" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radiox_2">Tarjeta de débito</label>
                                        <script type='text/javascript'>
                                            $('#radiox_2').change(function() {
                                                $('#val_pago').val('ok');
                                            });
                                        </script>
                                        <input name="f_pago" type="radio" id="radiox_3" value="Transferencia" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radiox_3">Transferencia</label>
                                        <script type='text/javascript'>
                                            $('#radiox_3').change(function() {
                                                $('#val_pago').val('ok');
                                            });
                                        </script>
                                        <input name="f_pago" type="radio" id="radiox_4" value="Efectivo" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radiox_4">Efectivo</label>
                                        <script type='text/javascript'>
                                            $('#radiox_4').change(function() {
                                                $('#val_pago').val('ok');
                                            });
                                        </script>
                                        <input name="f_pago" type="radio" id="radiox_5" value="Cortesía" class="radio-col-<?php echo $body; ?>" />
                                        <label for="radiox_5">Cortesía</label>
                                        <script type='text/javascript'>
                                            $('#radiox_5').change(function() {
                                                $('#val_pago').val('ok');
                                            });
                                        </script>
                                    </div>
                                    <hr>
                                    <!-- Botón de submit -->
                                    <div class="row clearfix demo-button-sizes">
                                        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                            <button id="btn_submit" type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
                                        </div>

                                       
                                        <script type='text/javascript'>
                                            $('#wizard_with_validation').submit(function(event) {                                           	
                                                $("#load").show();
                                                $("#btn_submit").hide();
                                                
                                            });
                                        </script>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($a == 1) { ?>	
    <script>
        $(document).ready(function() {
            $('#modal').click();
        });    	
    </script>
<?php } ?>
<?php include($ruta . 'footer1.php'); ?>

<!-- Incluir scripts necesarios -->
<!-- Moment Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Bootstrap Datepicker Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- Autosize Plugin Js -->
<script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

<?php include($ruta . 'footer2.php'); 

/*
 * Definir ruta base y variables iniciales:
 *     Se define la ruta base y se inicializan variables para la fecha y hora actuales.
 * Incluir archivos de cabecera:
 *     Se incluyen los archivos de cabecera necesarios para la página.
 * Incluir estilos necesarios:
 *     Se incluyen los archivos CSS necesarios para los componentes utilizados.
 * Contenido principal:
 *     Sección principal del contenido de la página, incluyendo el formulario de cobros.
 * Opciones de tipo de cobro:
 *     Se presentan las opciones de tipo de cobro (Consulta Medica, Terapia, Renta Consultorio, Otros) y se configuran eventos para mostrar/ocultar campos relevantes.
 * Selección de doctor y tipo de consulta para "Consulta Medica":
 *     Sección para seleccionar el doctor y el tipo de consulta si se elige "Consulta Medica".
 * Selección de paquete para "Terapia":
 *     Sección para seleccionar el paquete si se elige "Terapia".
 * Selección de paciente:
 *     Sección para buscar y seleccionar un paciente.
 * Modal para buscar paciente:
 *     Modal para buscar y seleccionar un paciente desde una lista.
 * Sección para "Otros":
 *     Sección para ingresar información adicional si se elige "Otros".
 * Selección de cantidad e importe:
 *     Campos para ingresar la cantidad y el importe del cobro.
 * Selección de si desea factura:
 *     Campos para seleccionar si se desea factura.
 * Modal para validar datos del paciente:
 *     Modal para validar los datos del paciente si se desea factura.
 * Selección de forma de pago:
 *     Campos para seleccionar la forma de pago (Tarjeta Credito, Tarjeta Debito, Transferencia, Efectivo, Cortesía).
 * Botón de submit:
 *     Botón para enviar el formulario y ocultarlo después de enviar.
 * Incluir scripts necesarios:
 *     Se incluyen los archivos JavaScript necesarios para los componentes utilizados.
 */
?>