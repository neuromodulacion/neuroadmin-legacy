<?php
session_start();
$time = mktime();
include('../functions/funciones_mysql.php');
include('../paciente/fun_paciente.php');

extract($_GET);
//$paciente_id = 68;
echo "<hr>$paciente_id<hr>";

$grafica = medicion_protocolo($paciente_id);

echo $grafica."<hr>";


?> 

<!DOCTYPE html>
<html>
<head>
    <title>Guardar imagen de gráfica</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
  <script src="../morris.js-master/morris.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
  <script src="../morris.js-master/examples/lib/example.js"></script>
  <!--<script src="../morris.js-master/lib/example.js"></script>-->
  <link rel="stylesheet" href="../morris.js-master/examples/lib/example.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
  <link rel="stylesheet" href="../morris.js-master/morris.css">
</head>
<body>
<h1>EVOLUCION GRAFICADA</h1>
<div id="graph"></div>
<script>
	/* data stolen from https://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
	var week_data = <?php echo $grafica; ?>
	Morris.Line({
	  element: 'graph',
	  data: week_data,
	  xkey: 'y',
	  ykeys: ['PHQ9', 'GAD7'],
	  labels: ['PHQ9', 'GAD7']
	});	
</script>

<div id="contenido">hola</div>

  <button style="display: none"  id="myButton" onclick="handleClick()">Botón</button>   
    
<script>
  window.addEventListener('DOMContentLoaded', function() {
    html2canvas(document.getElementById('graph')).then(function(canvas) {
      // Convierte el canvas en base64
      var imgData = canvas.toDataURL('image/png');

      // Datos adicionales a enviar
      var datosAdicionales = {
        paciente_id: '<?php echo $paciente_id; ?>'
      };

      // Combina los datos adicionales con la imagen en un solo objeto
      var requestData = Object.assign({}, datosAdicionales, { image: imgData });

      // Envía los datos al servidor utilizando una solicitud AJAX con jQuery
      $.ajax({
        url: 'guardar_imagen.php',
        type: 'POST',
        data: requestData,
        success: function(response) {
           alert('La imagen se ha guardado correctamente.');
        }
      });
    });  
  });
</script>    
</head>

