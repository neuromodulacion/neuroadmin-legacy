<?php

session_start();
error_reporting(7);
iconv_set_encoding('internal_encoding', 'utf-8'); 
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Monterrey');
setlocale(LC_TIME, 'es_ES.UTF-8');
$_SESSION['time']=mktime();

$ruta="../";
$title = 'INICIO';

extract($_SESSION);
extract($_POST);
extract($_GET);
//print_r($_SESSION);

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$mes = strftime("%B");
$dia = date("N");
$semana = date("W");
$titulo ="Agenda";
$genera ="";



include($ruta.'header1.php');
include($ruta.'header2.php'); ?>
<style>
    #signature-pad {
        border: 2px solid #000000;
        
        max-width: 95%; /* Corrección aquí */
        min-width: 200px;
        height: 300px;
        box-sizing: border-box; /* Asegúrate de que el borde está incluido en el ancho */
    }
</style>


<section class="content">
    <div class="container-fluid">
        <!-- ... -->
        <div align="center" class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="min-height: 450px;" class="header">
                        <div align="center" class="container">          	
							<div class="row">
								<div class="col-md-6">
									<h3>Firma aquí</h3>
									<canvas id="signature-pad" class="border" ></canvas>
								</div>
								<div class="col-md-4">
							        <button id="save" class="btn btn-primary mt-2">Guardar Firma</button>
							        <button id="clear" class="btn btn-secondary mt-2">Limpiar</button>	
							        								
								</div>
								<div class="col-md-2">
		 	                        <div style="display: none" align="center" id="load">
		                                <div class="preloader pl-size-xl">
		                                    <div class="spinner-layer">
			                                   <div class="spinner-layer pl-teal">
			                                        <div class="circle-clipper left">
			                                            <div class="circle"></div>
			                                        </div>
			                                        <div class="circle-clipper right">
			                                            <div class="circle"></div>
			                                        </div>
			                                    </div>
		                                    </div>
		                                </div>
		                                <h3>Procesando la información...</h3>			                        	
			                        </div>         								
								</div>								
								
								

							</div>                       	
                        	
					        
					        

					    </div>
						<hr>
						
						<script>
							document.addEventListener("DOMContentLoaded", function() {
							    var canvas = document.getElementById('signature-pad');
							    var context = canvas.getContext('2d');
							
							    var isDrawing = false;
							
								function getMousePos(canvas, evt) {
								    var rect = canvas.getBoundingClientRect();
								    return {
								        x: (evt.clientX - rect.left) / (rect.right - rect.left) * canvas.width,
								        y: (evt.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height
								    };
								}
								
								function getTouchPos(canvas, touchEvent) {
								    var rect = canvas.getBoundingClientRect();
								    return {
								        x: (touchEvent.touches[0].clientX - rect.left) / (rect.right - rect.left) * canvas.width,
								        y: (touchEvent.touches[0].clientY - rect.top) / (rect.bottom - rect.top) * canvas.height
								    };
								}
								
								function startDrawing(e) {
								    var mousePos = e.type.includes('mouse') ? getMousePos(canvas, e) : getTouchPos(canvas, e);
								    isDrawing = true;
								    context.beginPath();
								    context.moveTo(mousePos.x, mousePos.y);
								    e.preventDefault();
								}  
								
								function draw(e) {
								    if (!isDrawing) return;
								    var mousePos = e.type.includes('mouse') ? getMousePos(canvas, e) : getTouchPos(canvas, e);
								    context.lineTo(mousePos.x, mousePos.y);
								    context.stroke();
								    e.preventDefault();
								}

							      
							    function stopDrawing() {
							        if (!isDrawing) return;
							        context.closePath();
							        isDrawing = false;
							    }
							 
							    // Eventos para dispositivos no táctiles
							    canvas.addEventListener('mousedown', startDrawing);
							    canvas.addEventListener('mousemove', draw);
							    window.addEventListener('mouseup', stopDrawing);
							
							    // Eventos táctiles para móviles y tablets
							    canvas.addEventListener('touchstart', startDrawing);
							    canvas.addEventListener('touchmove', draw);
							    canvas.addEventListener('touchend', stopDrawing);
							
							
								// Botón para guardar la firma
								document.getElementById('save').addEventListener('click', function() {
								    canvas.toBlob(function(blob) {
								    	$("#load").show();
								        var formData = new FormData();
								        formData.append('file', blob, 'firma_01.png');
								
								        $.ajax({
								            url: 'guardar_firma.php',
								            type: 'POST',
								            data: formData,
								            processData: false,  // Indica a jQuery que no procese los datos
								            contentType: false,  // Indica a jQuery que no establezca el tipo de contenido
								            success: function(data) {
								                $("#load").hide();
								                alert('Firma guardada correctamente.');
								                window.location.href = "https://neuromodulaciongdl.com/test/firmado.php";
								            },
								            error: function(xhr, status, error) {
								                alert('Error: ' + xhr.status + ' ' + error);
								            }
								        });
								    }, 'image/png');
								});

							    
							    // document.getElementById('save').addEventListener('click', function() {
							        // alert("Test");
							        // var dataURL = canvas.toDataURL();
							        // $.ajax({
							            // type: "POST",
							            // url: "guardar_firma.php",
							            // data: {
							                // imagenFirma: dataURL
							            // },
							            // success: function(data) {
							                // alert("Firma guardada correctamente.");
							            // }
							        // });
							    // });
							    document.getElementById('clear').addEventListener('click', function() {
							        context.clearRect(0, 0, canvas.width, canvas.height);
							    });							    
							});

						</script>
				                                           
                	</div>
            	</div>
        	</div>
    	</div>
    </div>   
</section>
<?php	
include($ruta.'footer1.php');
include($ruta.'footer2.php');	
?>                    	