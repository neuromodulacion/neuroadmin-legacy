<?php
$ruta="../";
$title = 'INICIO';

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Altas Protocolo";

include($ruta.'header1.php');

include('calendario.php');

?>
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<?php
include($ruta.'header2.php');

//include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ALTAS CLINIMETRIA</h2>
                <?php //echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                            <h1 align="center">Altas Protocolos</h1>
                            
<div class="body">
    <h1 class="mt-5">Crear Nueva Clinimetria</h1>
    <form action="guardar_Clinimetria.php" method="post">
        <div class="form-line">
            <label for="encuesta">Título de la Clinimetria</label>
            <input type="text" class="form-control" id="encuesta" name="encuesta" required>
        </div>
        <div class="form-line">
            <label for="descripcion">Descripción de la Clinimetria</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>
        <hr>
        <div id="preguntas_container">
            <div class="pregunta">
                <hr>
                <h4>Pregunta 1</h4>
                <div class="form-line">
                    <label for="pregunta_1">Pregunta</label>
                    <!-- Cambiado de input a textarea -->
                    <textarea class="form-control" id="pregunta_1" name="preguntas[1][pregunta]" required></textarea>
                </div>
                <div class="form-line">
                    <label for="tipo_1">Tipo de Pregunta</label>
                    <select class="form-control" id="tipo_1" name="preguntas[1][tipo]" required>
                        <option value="">Selecciona</option>
                        <option value="titulo">Título</option>
                        <option value="instrucciones">Instrucciones</option>
                        <option value="radio">Radio</option>
                        <option value="date">Fecha</option>
                        <option value="number">Número</option>
                        <option value="text">Texto</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </div>
                <!-- Campo para asignar número a la pregunta -->
                <div class="form-line question-number-container" id="question_number_container_1" style="display: none;">
                    <label for="numero_1">Número de Pregunta</label>
                    <input type="number" class="form-control" id="numero_1" name="preguntas[1][numero]" min="1">
                </div>
                <!-- Sección de respuestas -->
                <hr>
                <div class="form-line respuestas-container" id="respuestas_container_1" style="display: none;">
                    <label>Respuestas</label>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="preguntas[1][respuestas][<?= $i ?>][texto]" placeholder="Respuesta <?= $i ?>">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="preguntas[1][respuestas][<?= $i ?>][valor]" placeholder="Valor" min="0">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mt-3" id="add_pregunta">Agregar Pregunta</button>
        <button type="submit" class="btn btn-primary mt-3">Guardar Clinimetria</button>
    </form>
</div>

<!-- Script para manejar la visibilidad de campos en la primera pregunta -->
<script>
    document.getElementById('tipo_1').addEventListener('change', function() {
        const selectedType = this.value;
        const questionNumberContainer = document.getElementById('question_number_container_1');
        const respuestasContainer = document.getElementById('respuestas_container_1');
        if (selectedType == 'radio' ) {
            questionNumberContainer.style.display = 'block';
            respuestasContainer.style.display = 'block';
        } else {
            questionNumberContainer.style.display = 'none';
            respuestasContainer.style.display = 'none';
        }
    });
</script>

<!-- Script para agregar nuevas preguntas dinámicamente -->
<script>
    let preguntaIndex = 1;
    document.getElementById('add_pregunta').addEventListener('click', function() {
        preguntaIndex++;
        const preguntaTemplate = `
            <div class="pregunta">
                <hr>
                <h4>Pregunta ${preguntaIndex}</h4>
                <div class="form-line">
                    <label for="pregunta_${preguntaIndex}">Pregunta</label>
                    <!-- Cambiado de input a textarea -->
                    <textarea class="form-control" id="pregunta_${preguntaIndex}" name="preguntas[${preguntaIndex}][pregunta]" required></textarea>
                </div>
                <div class="form-line">
                    <label for="tipo_${preguntaIndex}">Tipo de Pregunta</label>
                    <select class="form-control" id="tipo_${preguntaIndex}" name="preguntas[${preguntaIndex}][tipo]" required>
                        <option value="">Selecciona</option>
                        <option value="titulo">Título</option>
                        <option value="instrucciones">Instrucciones</option>
                        <option value="radio">Radio</option>
                        <option value="date">Fecha</option>
                        <option value="number">Número</option>
                        <option value="text">Texto</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </div>
                <!-- Campo para asignar número a la pregunta -->
                <div class="form-line question-number-container" id="question_number_container_${preguntaIndex}" style="display: none;">
                    <label for="numero_${preguntaIndex}">Número de Pregunta</label>
                    <input type="number" class="form-control" id="numero_${preguntaIndex}" name="preguntas[${preguntaIndex}][numero]" min="1">
                </div>
                <!-- Sección de respuestas -->
                <hr>
                <div class="form-line respuestas-container" id="respuestas_container_${preguntaIndex}" style="display: none;">
                    <label>Respuestas</label>
                    ${Array.from({length: 10}, (_, i) => `
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="preguntas[${preguntaIndex}][respuestas][${i + 1}][texto]" placeholder="Respuesta ${i + 1}">
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="preguntas[${preguntaIndex}][respuestas][${i + 1}][valor]" placeholder="Valor" min="0">
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
        document.getElementById('preguntas_container').insertAdjacentHTML('beforeend', preguntaTemplate);

        // Agrega el listener al nuevo select de tipo de pregunta
        document.getElementById(`tipo_${preguntaIndex}`).addEventListener('change', function() {
            const selectedType = this.value;
            const questionNumberContainer = document.getElementById(`question_number_container_${preguntaIndex}`);
            const respuestasContainer = document.getElementById(`respuestas_container_${preguntaIndex}`);
            if (selectedType == 'radio' ) {
                questionNumberContainer.style.display = 'block';
                respuestasContainer.style.display = 'block';
            } else {
                questionNumberContainer.style.display = 'none';
                respuestasContainer.style.display = 'none';
            }
        });
    });
</script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include($ruta.'footer1.php'); ?>

    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<?php include($ruta.'footer2.php'); ?>
