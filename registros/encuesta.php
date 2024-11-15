<?php
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Mazatlan');
setlocale(LC_TIME, 'es_ES.UTF-8');
		
$ruta = "../";
extract($_POST);
extract($_GET);

//print_r($_SESSION);


include($ruta.'functions/funciones_mysql.php');

$sql ="
SELECT
	participantes.id, 
	participantes.nombre_completo, 
	participantes.profesion, 
	participantes.celular, 
	participantes.correo, 
	participantes.fecha_registro, 
	participantes.estatus
FROM
	participantes
WHERE
	participantes.id = $id";
	//echo $sql;	
    $result=ejecutar($sql); 
    $row = mysqli_fetch_array($result);
    extract($row);	



//'..'.
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción del Seminario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

 <body style="background: #0096AA;" >    <!--class="theme-teal" -->
    
	<nav style="background: #0096AA" class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button> -->
	      <a href="../index.html" style=" color: white" class="navbar-brand">Neuromodulaci&oacute;n Gdl</a>
	      <!-- <a style=" color: white" class="navbar-brand" href="#">Neuromodulacion Gdl</a> -->
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	     
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
<hr>
<div align="center" class="row clearfix" >
	<div align="center" class="card" style="width: 100%">	
		
    <div class="container mt-5">
        <h1>Encuesta de Satisfacción del Seminario</h1>
        <form action="procesar_encuesta.php" method="POST">
        	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
            <h3>Datos Generales del Participante</h3>
            <hr>
            <div class="form-group">
                <label for="nombre_completo"><b>Nombre Completo:</b></label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $nombre_completo; ?>" required>
            </div>
            <!-- Datos de Contacto -->
            <h3>Datos de Contacto</h3>
            <div class="form-group">
                <label for="celular"><b>Número de Celular:</b></label>
                <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $celular; ?>" required>
            </div>
            <div class="form-group">
                <label for="correo_electronico"><b>Correo Electrónico:</b></label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?php echo $correo; ?>" required>
            </div>            
            <div class="form-group">
                <label for="especialidad"><b>Especialidad:</b></label>
                <select class="form-control" id="especialidad" name="especialidad" required>
                    <option value="">Selecciona</option>
                    <option value="Psiquiatría">Psiquiatría</option>
                    <option value="Neurología">Neurología</option>
                    <option value="Otra">Otra</option>
                </select>
                <input type="text" class="form-control mt-2" id="otra_especialidad" name="otra_especialidad" placeholder="Especificar otra especialidad">
            </div>
            <div class="form-group">
                <label for="experiencia_clinica"><b>Años de Experiencia Clínica:</b></label>
                <input type="number" class="form-control" id="experiencia_clinica" name="experiencia_clinica" required>
            </div>
            <div class="form-group">
                <label><b>¿Acostumbra ver padecimientos como depresión resistente a tratamiento (TRD)?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="trd_si" name="trd" value="1" required>
                        <label class="form-check-label" for="trd_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="trd_no" name="trd" value="0" required>
                        <label class="form-check-label" for="trd_no">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><b>En promedio, ¿cuántos pacientes con TRD ve al mes?</b></label>
                <select class="form-control" id="pacientes_trd_mes" name="pacientes_trd_mes" required>
                    <option value="">Selecciona</option>
                    <option value="Menos de 5">Menos de 5</option>
                    <option value="5-10">5-10</option>
                    <option value="Más de 10">Más de 10</option>
                </select>
            </div>
            <div class="form-group">
                <label><b>¿Tenía conocimientos previos sobre técnicas de neuromodulación antes del seminario?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="conocimiento_si" name="conocimiento_neuromodulacion" value="1" required>
                        <label class="form-check-label" for="conocimiento_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="conocimiento_no" name="conocimiento_neuromodulacion" value="0" required>
                        <label class="form-check-label" for="conocimiento_no">No</label>
                    </div>
                </div>
            </div>
<hr>
            <!-- Parte Expositiva -->
            <h3>Evaluación del Seminario - Parte Expositiva</h3>
            <div class="form-group">
                <label for="claridad_presentaciones"><b>Califique la claridad de las presentaciones teóricas (de 0 a 10):</b></label>
				<select class="form-control" id="claridad_presentaciones" name="claridad_presentaciones" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
				</select>
            </div>
            <div class="form-group">
                <label><b>¿Considera que los temas tratados fueron relevantes para su práctica clínica?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="temas_relevantes_si" name="temas_relevantes" value="1" required>
                        <label class="form-check-label" for="temas_relevantes_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="temas_relevantes_no" name="temas_relevantes" value="0" required>
                        <label class="form-check-label" for="temas_relevantes_no">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><b>¿Hubo algún tema que le gustaría que se hubiera tratado con mayor profundidad?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="tema_profundo_si" name="tema_profundo_si" value="1">
                        <label class="form-check-label" for="tema_profundo_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="tema_profundo_no" name="tema_profundo_si" value="0">
                        <label class="form-check-label" for="tema_profundo_no">No</label>
                    </div>
                </div>
                <input type="text" class="form-control mt-2" id="tema_profundo" name="tema_profundo" placeholder="Especificar tema">
            </div>
			<div class="form-group">
			    <label for="calidad_contenidos"><b>Califique la calidad de los contenidos revisados durante el seminario (de 1 a 10):</b></label>
			    <select class="form-control" id="calidad_contenidos" name="calidad_contenidos" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
			    </select>
			</div> 
			<div class="form-group">
			    <label for="duracion_seminario"><b>Califique que tan apropiada fue la duración del seminario (de 1 a 10):</b></label>
			    <select class="form-control" id="duracion_seminario" name="duracion_seminario" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
			    </select>
			</div>			           
<hr>
            <!-- Parte Demostrativa -->
            <h3>Evaluación del Seminario - Parte Demostrativa</h3>
            <div class="form-group">
                <label for="utilidad_rtms"><b>Califique la utilidad de las demostraciones prácticas de rTMS (de 0 a 10):</b></label>
				<select class="form-control" id="utilidad_rtms" name="utilidad_rtms" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
				</select>                
            </div>
            <div class="form-group">
                <label for="utilidad_tdcs"><b>Califique la utilidad de las demostraciones prácticas de tDCS (de 0 a 10):</b></label>
				<select class="form-control" id="utilidad_tdcs" name="utilidad_tdcs" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
				</select>                   
            </div>
            <div class="form-group">
                <label><b>¿Le gustaría asistir a más demostraciones prácticas de técnicas de neuromodulación?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="mas_demostraciones_si" name="mas_demostraciones" value="1" required>
                        <label class="form-check-label" for="mas_demostraciones_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="mas_demostraciones_no" name="mas_demostraciones" value="0" required>
                        <label class="form-check-label" for="mas_demostraciones_no">No</label>
                    </div>
                </div>
            </div>
<hr>
            <!-- Evaluación General -->
            <h3>Evaluación General</h3>
            <div class="form-group">
                <label><b>¿Considera que la propuesta de servicios de tratamiento de neuromodulación de Neuromodulación GDL es viable para sus pacientes?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="viabilidad_si_muy_probable" name="viabilidad_servicios" value="Sí es muy probable" required>
                        <label class="form-check-label" for="viabilidad_si_muy_probable">Sí es muy probable</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="viabilidad_algo_probable" name="viabilidad_servicios" value="Es algo probable" required>
                        <label class="form-check-label" for="viabilidad_algo_probable">Es algo probable</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="viabilidad_no_muy_probable" name="viabilidad_servicios" value="No es muy probable" required>
                        <label class="form-check-label" for="viabilidad_no_muy_probable">No es muy probable</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><b>¿Cree que podría prescribir y referir a sus pacientes mediante nuestra plataforma durante el trimestre siguiente?</b></label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="prescripcion_si_muy_probable" name="prescripcion_plataforma" value="Sí es muy probable" required>
                        <label class="form-check-label" for="prescripcion_si_muy_probable">Sí es muy probable</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="prescripcion_algo_probable" name="prescripcion_plataforma" value="Es algo probable" required>
                        <label class="form-check-label" for="prescripcion_algo_probable">Es algo probable</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="prescripcion_no_muy_probable" name="prescripcion_plataforma" value="No es muy probable" required>
                        <label class="form-check-label" for="prescripcion_no_muy_probable">No es muy probable</label>
                    </div>
                </div>
            </div>
			<div class="form-group">
			    <label for="servicio_alimentos"><b>Califique el servicio de alimentos (coffee break) (de 1 a 10):</b></label>
			    <select class="form-control" id="servicio_alimentos" name="servicio_alimentos" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
			    </select>
			</div>
			<div class="form-group">
			    <label for="dinamica_tecnicas"><b>Califique la dinámica y técnicas de aprendizaje del seminario (de 1 a 10):</b></label>
			    <select class="form-control" id="dinamica_tecnicas" name="dinamica_tecnicas" required>
				    <option value="">Selecciona</option>
				    <option value="10">10</option>
				    <option value="9">9</option>
				    <option value="8">8</option>
				    <option value="7">7</option>
				    <option value="6">6</option>
				    <option value="5">5</option>
				    <option value="4">4</option>
				    <option value="3">3</option>
				    <option value="2">2</option>
				    <option value="1">1</option>
				    <option value="0">0</option>
			    </select>
			</div>
            <div class="form-group">
                <label for="comentarios"><b>Comentarios y Sugerencias:</b></label>
                <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="mejoras"><b>¿Qué aspectos del seminario cree que podrían mejorarse?</b></label>
                <textarea class="form-control" id="mejoras" name="mejoras" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="sugerencias"><b>¿Tiene alguna sugerencia adicional para futuros seminarios?</b></label>
                <textarea class="form-control" id="sugerencias" name="sugerencias" rows="3"></textarea>
            </div>
<hr>

            <button type="submit" class="btn btn-primary"><b>Enviar Encuesta</b></button>
        </form>
    </div>
    
</body>

</html>        

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> -->
