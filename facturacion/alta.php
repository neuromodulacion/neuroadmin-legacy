<?php


$ruta="../";
$title = 'INICIO';
$titulo ="Altas";
//include($ruta.'header.php'); 

include($ruta.'header1.php');
?>
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    
     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo $ruta; ?>plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap  Css -->
    <link href="<?php echo $ruta; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />   
<?php
include($ruta.'header2.php'); 
//print_r($_SESSION);
?>
<?php // echo $ubicacion_url; ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ALTAS</h2>
                <!-- <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?> -->
            </div>
            

            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Altas</h1>
                        	<?php //echo "hola ".$ubicacion_url;
                        	//print_r($_SESSION); ?>
        	                <!-- <div align="center" class="image">
			                    <img  src= "<?php echo $ruta.'images/menu.jpg'; ?>" style="max-width:100%;width:auto;height:auto;" />
			                </div> -->
                    	</div>
                	</div>
            	</div>
        	</div>            
<!-- // ************** Contenido ************** // -->
            <!-- Advanced Form Example With Validation -->
            
<!--
	
{
    "cCodigoCliente": "10001",
    
    "cRazonSocial": "Salvador Vazquez Cardenas",
    "cRFC": "VACS9408239Z3",
    "cNombreCalle": "Alcatraz",
    "cNumeroExterior": "52",
    "cNumeroInterior": "1",
    "cColonia": "Chapalita",
    "cCodigoPostal": "49600",
    "cCiudad": "Guadalajara",
    "cEstado": "Jalisco",
    "cPais": "Mexico",
    "aRegimen": "601",
    "aCodConcepto": "65040",
    "aSerie": "",
    "aCodigoAgente": "(Ninguno)",
    "aNumMoneda": "1",
    "aTipoCambio": "1",
    "aImporte": "0",
    "Movimientos":[
        {
            "aCodAlmacen": "1",
            "aCodProdSer":"02",
            "aUnidades": "1",
            "aPrecio": "1"
        }
    ]
}	
	-->            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ALTA DE PACIENTE</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" method="POST" action="guarda_alta.php" >
                            	
                               <h3>Información del Paciente</h3>
                                <fieldset>
                                    
                                     <div class="form-group form-float">
                                        <div class="form-line">                                   
											<input type="text" name="cCodigoCliente" class="form-control" required>
                                            <label class="form-label">Código Cliente:</label>
                                        </div>
                                    </div>
                                    <hr>
                                     <div class="form-group form-float">
                                        <div class="form-line">                                      
     <input type="text" name="cRazonSocial" class="form-control" required>
                                            <label class="form-label">Razón Social:</label>
                                        </div>
                                    </div>    
                                     <div class="form-group form-float">
                                        <div class="form-line">      
    <input type="text" name="cRFC" class="form-control" required>
                                            <label class="form-label">RFC: </label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">  
     <input type="text" name="cNombreCalle" class="form-control" required>
                                            <label class="form-label">Nombre Calle:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cNumeroExterior" class="form-control" required>
                                            <label class="form-label">Número Exterior:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cNumeroInterior" class="form-control" required>
                                            <label class="form-label">Número Interior:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cColonia" class="form-control" required>
                                            <label class="form-label">Colonia:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cCodigoPostal" class="form-control" required>
                                            <label class="form-label">Código Postal:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cCiudad" class="form-control" required>
                                            <label class="form-label">Ciudad:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cEstado" class="form-control" required>
                                            <label class="form-label">Estado:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="cPais" class="form-control" required>
                                            <label class="form-label">País:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aRegimen" class="form-control" required>
                                            <label class="form-label">Régimen:</label>
                                        </div>
                                    </div>
                                    <hr>
                                    
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aCodConcepto" class="form-control" required>
                                            <label class="form-label">Código Concepto:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aSerie" class="form-control" required>
                                            <label class="form-label">Serie:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aCodigoAgente" class="form-control" required>
                                            <label class="form-label">Código Agente:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aNumMoneda" class="form-control" required>
                                            <label class="form-label">Número Moneda:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aTipoCambio" class="form-control" required>
                                            <label class="form-label">Tipo Cambio:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aImporte" class="form-control" required>
                                            <label class="form-label">Importe:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">  
    <!-- Movimientos (Esto podría requerir una lógica más compleja si hay múltiples movimientos) -->
     <input type="text" name="aCodAlmacen" class="form-control" required>
                                            <label class="form-label">Código Almacén:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aCodProdSer" class="form-control" required>
                                            <label class="form-label">Código Prod/Ser:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aUnidades" class="form-control" required>
                                            <label class="form-label">Unidades:</label>
                                        </div>
                                    </div>
                                     <div class="form-group form-float">
                                        <div class="form-line">      
     <input type="text" name="aPrecio" class="form-control" required>
                                            <label class="form-label">Precio:</label>
                                        </div>
                                    </div>
     

    <input type="submit" value="Guardar">
                         
                                    
                                    
                                    
                                     
                                </fieldset> 
                                <hr>                               
                                <div class="row clearfix demo-button-sizes">
                                	<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                                		<button type="submit" class="btn bg-green btn-block btn-lg waves-effect">GUARDAR</button>
                            		</div>
                        		</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Advanced Form Example With Validation -->
              

        </div>
    </section>
   <?php /* 
    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/admin.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/forms/basic-form-elements.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo $ruta; ?>js/demo.js"></script> -->
    * 
    */?>
</body>
</html>    
    
<?php	include($ruta.'footer1.php');	?>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Waves Effect Plugin Js -->
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    
<?php	include($ruta.'footer2.php');	?>