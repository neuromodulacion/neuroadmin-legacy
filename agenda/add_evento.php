<?php
// Incluir archivo de funciones MySQL necesarias para interactuar con la base de datos
include('../functions/funciones_mysql.php');

// Iniciar sesión y configurar opciones de error, codificación y zona horaria
session_start();
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time'] = time(); // Guardar la hora actual en la sesión

$ruta = "../"; // Ruta base para incluir archivos y recursos

// Extraer variables de la sesión y del formulario POST
extract($_SESSION);
extract($_POST);

// Configurar variables de fecha y hora actuales
$f_registro = date("Y-m-d");
$h_registro = date("H:i:s"); 
?>

<!-- Formulario para guardar una nueva cita en la agenda -->
<form id="form_guarda_agenda" class="form-evento" method="POST">
    <input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agenda_id; ?>"/>
    <div class="modal-body">  
        <h3 align="center">Agrega Cita</h3>
        
        <!-- Selección de Paciente -->
        <div class="form-group">
            <label for="color" class="col-sm-2 control-label">Paciente</label>
            <div class="col-sm-10">
                <select name="paciente_id" class='form-control show-tick' id="paciente_id" required>
                    <option <?php if($paciente_id == ''){ echo "selected";} ?> value="">Seleccionar</option>
                    <?php
                        // Consulta SQL para obtener los pacientes de la empresa actual
                        $sql_paciente = "
                            SELECT
                                pacientes.paciente_id as paciente_idx, 
                                CONCAT( pacientes.paciente, ' ', pacientes.apaterno, ' ', pacientes.amaterno ) AS paciente
                            FROM
                                pacientes
                            WHERE
                                pacientes.estatus NOT IN('No interezado') 
                                AND pacientes.empresa_id = $empresa_id
                            ORDER BY 2 ASC";
                        
                        // Ejecutar la consulta y listar los pacientes en el dropdown
                        $result_paciente = ejecutar($sql_paciente);  
                        while($row_paciente = mysqli_fetch_array($result_paciente)){
                            extract($row_paciente); 
                    ?>
                    <option <?php if($paciente_idx == $paciente_id){ echo "selected";} ?> value="<?php echo $paciente_idx; ?>"><?php echo $paciente; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <!-- Separador visual -->
            <div class="col-sm-12">
                <hr>
            </div>
            
            <!-- Campo para la fecha de inicio de la cita -->
            <label for="title" class="col-sm-2 control-label">Fecha inicio</label>
            <div class="col-sm-4">
                <input type="date" name="f_ini" class="form-control" id="f_ini" placeholder="Fecha inicio" value="<?php echo $f_ini; ?>" required>
                <script>
                    // Sincronizar la fecha de fin con la fecha de inicio cuando esta cambia
                    $('#f_ini').change(function(){    
                        var f_ini = $('#f_ini').val();
                        $('#f_fin').val(f_ini);  
                    });  
                </script>          
            </div>

            <!-- Campo para la hora de inicio de la cita -->
            <label for="title" class="col-sm-2 control-label">Hora inicio</label>
            <div class="col-sm-4">
              <input type="time" name="h_ini" class="form-control" id="h_ini" placeholder="Hora inicio" value="<?php echo $h_ini; ?>" required>
                <script>
                    // Sincronizar la hora de fin con la hora de inicio más 30 minutos
                    $('#h_ini').change(function(){    
                        var hora = $('#h_ini').val();
                        var horaNueva = sumarMinutos(hora, 30);
                        $('#h_fin').val(horaNueva);

                        // Función para sumar minutos a una hora dada
                        function sumarMinutos(hora, minutos) {
                            var partes = hora.split(':');
                            var horaActual = parseInt(partes[0]);
                            var minutoActual = parseInt(partes[1]);

                            var nuevaHora = horaActual;
                            var nuevoMinuto = minutoActual + minutos;

                            if (nuevoMinuto >= 60) {
                                nuevaHora += Math.floor(nuevoMinuto / 60);
                                nuevoMinuto = nuevoMinuto % 60;
                            }

                            var horaFormateada = ('0' + nuevaHora).slice(-2);
                            var minutoFormateado = ('0' + nuevoMinuto).slice(-2);

                            return horaFormateada + ':' + minutoFormateado;
                        }                        
                    });  
                </script>
            </div>

            <!-- Separador visual -->
            <div class="col-sm-12">
                <hr>
            </div>

            <!-- Campo para la fecha de fin de la cita -->
            <label for="title" class="col-sm-2 control-label">Fecha final</label>
            <div class="col-sm-4">
              <input type="date" name="f_fin" class="form-control" id="f_fin" placeholder="Fecha final" value="<?php echo $f_fin; ?>" required>
            </div>
    
            <!-- Campo para la hora de fin de la cita -->
            <label for="title" class="col-sm-2 control-label">Hora final</label>
            <div class="col-sm-4">
              <input type="time" name="h_fin" class="form-control" id="h_fin" placeholder="Hora final" value="<?php echo $h_fin; ?>" required>
            </div>

            <!-- Separador visual -->
            <div class="col-sm-12">
                <hr>
            </div>

            <!-- Campo para la descripción de la cita -->
            <label for="title" class="col-sm-2 control-label">Descripción</label>
            <div class="col-sm-10">
               <div class="form-line">
                    <textarea rows='4' id='observ' name='observ' class='form-control no-resize' placeholder='Descripción' required><?php echo $observ; ?></textarea>
                </div>
            </div>

            <!-- Separador visual -->
            <div class="col-sm-12">
                <hr>
            </div>

            <!-- Selección de los días de la semana para la recurrencia -->
            <label for="title" class="col-sm-2 control-label">Días de la semana</label>
            <div class="col-sm-10">
                <div id="check" class="checkbox">
                    <input type="checkbox" name="dias_semana[]" value="1" id="lunes" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="lunes">Lunes</label>
                    <input type="checkbox" name="dias_semana[]" value="2" id="martes" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="martes">Martes</label>
                    <input type="checkbox" name="dias_semana[]" value="3" id="miercoles" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="miercoles">Miércoles</label>
                    <input type="checkbox" name="dias_semana[]" value="4" id="jueves" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="jueves">Jueves</label>
                    <input type="checkbox" name="dias_semana[]" value="5" id="viernes" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="viernes">Viernes</label>
                    <input type="checkbox" name="dias_semana[]" value="6" id="sabado" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="sabado">Sábado</label>
                    <input type="checkbox" name="dias_semana[]" value="7" id="domingo" class="filled-in chk-col-<?php echo $body; ?>" />
                    <label for="domingo">Domingo</label>
                </div>
            </div>

            <!-- Separador visual -->
            <div class="col-sm-12">
                <hr>
            </div>

            <!-- Selección de la recurrencia de la cita -->
            <label for="title" class="col-sm-2 control-label">Recurrencia</label>
            <div class="col-sm-4">
                <select name="recurrencia" class="form-control" id="recurrencia" required>
                    <option value="diaria">Diaria</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                </select>
                <script>
                    // Mostrar u ocultar la selección de días de la semana según la recurrencia
                    $('#recurrencia').change(function(){                          
                        var recurrencia = $('#recurrencia').val();
                        if (recurrencia === 'mensual'){
                        	$('#check').hide();
                        }else{
                        	$('#check').show();
                        }                               
                    });  
                </script>                
            </div>

            <!-- Campo para definir la frecuencia de la recurrencia -->
            <label for="title" class="col-sm-2 control-label">Frecuencia</label>
            <div class="col-sm-4">
                <input type="number" name="frecuencia" class="form-control" id="frecuencia" placeholder="Frecuencia" value="1" required>
                <script>
                    // Validar que la frecuencia no sea menor a 1
                    $('#frecuencia').change(function(){
                        var frecuencia = $('#frecuencia').val();
                        if (frecuencia < 1) {
                            $('#frecuencia').val(1);
                        }
                    });
                </script>       
                <script>
                    // Validar que la frecuencia no sea menor a 1 al hacer clic
                    $('#frecuencia').click(function(){
                        var frecuencia = $('#frecuencia').val();
                        if (frecuencia < 1) {
                            $('#frecuencia').val(1);
                        }
                    });
                </script>                     
            </div>           
        </div>                                  
    </div>
    
    <div id="guardado"></div>
    <div class="modal-footer">
        <div class="form-group"> 
            <div class="col-sm-12"> 
            	<hr>            
                <button type="button" id="cerrar" class="btn btn-info" data-dismiss="modal"><i class="material-icons">close</i>Cerrar</button>
                <button type="button" id="guarda_agenda" class="btn btn-success"><i class="material-icons">save</i>Guardar</button>
                <button style="display: none" type="submit" id="submit_test" class="btn btn-success">submit_test</button>
                <script>
                    // Validar campos requeridos y enviar el formulario para guardar la cita
                    $('#guarda_agenda').click(function(){    
                        var emptyFields = $('#form_guarda_agenda').find('input[required], select[required], textarea[required]').filter(function() {
                            return this.value === '';
                        });
                        var frecuencia = $('#frecuencia').val();
                        if (frecuencia < 1) {
                            $('#frecuencia').val(1);
                        }                        
                        if (emptyFields.length > 0) {
                            emptyFields.each(function() {
                                $('#submit_test').click();
                            });
                        } else {                            
                            var datastring = $('#form_guarda_agenda').serialize();
                            $('#guardado').html('');
                            $('#load').show();
                            $.ajax({
                                url: 'guarda_agenda.php',
                                type: 'POST',
                                data: datastring,
                                cache: false,
                                success:function(html){                                
                                    $('#guardado').html(html);                                   
                                    $('#load').hide();
                                    $('#cerrar').hide();
                                    $('#guarda_agenda').hide(); 
                                }
                            });                         
                        }           
                    });  
                </script>                   
            </div>
        </div>
    </div>
</form>