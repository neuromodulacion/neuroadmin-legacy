<?php
$ruta="../";

$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes_ahora = date("m");
$titulo ="Consultorios";
include($ruta.'header.php'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>cONSULTORIOS</h2>
                <?php echo $ubicacion_url."<br>"; 
                //echo $ruta."proyecto_medico/menu.php"?>
            </div>
<!-- // ************** Contenido ************** // -->
            <!-- CKEditor -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div style="height: 95%"  class="header">
                        	<h1 align="center">Consultorios</h1>
        	                <!-- <div align="center" class="image">
			                    <img  src= "<?php echo $ruta.'images/menu.jpg'; ?>" style="max-width:100%;width:auto;height:auto;" />
			                </div> -->
                    	</div>
                	</div>
            	</div>
        	</div>
              

        </div>
    </section>
<?php	include($ruta.'footer.php');	?>