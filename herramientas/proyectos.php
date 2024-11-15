<?php
$ruta="../";
$title = 'USUARIOS';
include($ruta.'header.php');
//$obj=new Mysql;
extract($_SESSION);
$hoy = date("Y-m-d");
$ahora = date("H:i:00"); 
$anio = date("Y");
$mes = date("m");
$ruta_foto="gastos/$anio/$mes";
$id_foto = 1;
$proyecto_id =0;
?>



    <!-- JQuery DataTable Css -->
    <link href="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <script src="<?php echo $ruta; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
<script type="text/javascript" language='javascript' src="<?php echo $ruta; ?>js/AjaxUpload.2.0.min.js"></script>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2><?php echo $title; 
                    //print_r($_SESSION); ?></h2>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ADMINISTRACION DE PROYECTOS
                            </h2>
                        </div>
                        <div class="body">
                            <div style="width: 100%" >
                                <!-- <table class="table table-bordered table-striped table-hover js-basic-example dataTable"> -->
                                    <div class="row">
                                        <form target="_self" id="form_proyecto" class="form-horizontal" action="../herramientas/guardar_proyecto.php"   method="post">
                                            <input type="hidden" id="proyecto_id1" name="proyecto_id" value="<?php echo $proyecto_id; ?>" />
                                            <input type="hidden" id="accion" name="accion" value="crea" />
                                            <div style="border-color: #eee; border-style: solid;padding: 5px" id="linea" class="col-md-12">
                                                  <div class="col-md-2">
                                                      <label for="titulo">Proyecto Nuevo</label>
                                                      <input id="titulo" name="titulo" type="text" class="form-control" placeholder="Titulo del proyecto"  value="" required></div>
                                                  <div class="col-md-3">
                                                      <label for="descripcion">Descripción</label>
                                                      <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" required></textarea></div>
                                                  <div class="col-md-2">
                                                      <label for="encargado">Encargado</label>
                                                      <input id="encargado" name="encargado" type="text" class="form-control" placeholder="Encargado"  value="" required></div>
                                                  <div class="col-md-2">
                                                      <label for="contacto">Contacto</label>
                                                      <input id="contacto" name="contacto" type="text" class="form-control" placeholder="Contacto"  value="" required></div>
                                                  <div class="col-md-2">
                                                      <label for="estatus">Estatus</label>
                                                    <select  id="estatus" name="estatus" class="form-control " >
                                                      <option value="ACTIVO" <?php if($estatus == 'ACTIVO' ){ echo "selected";} ?> >ACTIVO</option>
                                                      <option value="CONCLUIDO" <?php if($estatus == 'CONCLUIDO' ){ echo "selected";} ?> >CONCLUIDO</option>
                                                      <option value="CANCELADO" <?php if($estatus == 'CANCELADO' ){ echo "selected";} ?> >CANCELADO</option>
                                                    </select>
                                                  </div>
                                                  <div class="col-md-1">
                                                      <label for="proyecto_id">Crea</label>

                                                        <button id="guardar_proyecto"  class="btn btn-success" type="submit"><i class="material-icons">save</i></button>

                                                  </div>
                                                  
                                            </div>
                                            
                                            </form>
                                    <!-- <tr>
                                        <th>No.</th>
                                        <th>Proyecto</th>
                                        <th>descripcion</th>
                                        <th>Encargado</th>
                                        <th>Contacto</th>
                                        <th>Estatus</th>
                                        <th>Editar</th>
                                    </tr> -->
                                    <?php
                                    $sql_tabla = "
                                        SELECT
                                            proyectos.proyecto_id,
                                            proyectos.titulo,
                                            proyectos.descripcion,
                                            proyectos.encargado,
                                            proyectos.contacto,
                                            proyectos.estatus
                                        FROM
                                            proyectos
                                    ";
                                    $result_tabla=ejecutar($sql_tabla); 
                                        //echo $cnt."<br>";      
                                        $saldo_t=0;
                                    while($row_tabla = mysqli_fetch_array($result_tabla)){
                                        extract($row_tabla); 
                                        $saldo_t = $saldo_t+$saldo;
                                        ?>
                                        <form target="_self" id="form_<?php echo $proyecto_id; ?>" class="form-horizontal"  method="post">
                                            <input type="hidden" id="proyecto_id1_<?php echo $proyecto_id; ?>" name="proyecto_id" value="<?php echo $proyecto_id; ?>" />
                                            <input type="hidden" id="accion_<?php echo $proyecto_id; ?>" name="accion" value="modifica" />
                                            <div style="border-color: #eee; border-style: solid;padding: 5px" id="linea_<?php echo $proyecto_id; ?>" class="col-md-12">
                                                  <div class="col-md-2">
                                                      <label for="titulo_<?php echo $proyecto_id; ?>">Proyecto No. <?php echo $proyecto_id; ?></label>
                                                      <input id="titulo_<?php echo $proyecto_id; ?>" name="titulo" type="text" class="form-control"  value="<?php echo $titulo; ?>" disabled></div>
                                                  <div class="col-md-3">
                                                      <label for="descripcion_<?php echo $proyecto_id; ?>">Descripción</label>
                                                      <textarea id="descripcion_<?php echo $proyecto_id; ?>" name="descripcion" class="form-control" disabled><?php echo $descripcion; ?></textarea></div>
                                                  <div class="col-md-2">
                                                      <label for="encargado_<?php echo $proyecto_id; ?>">Encargado</label>
                                                      <input id="encargado_<?php echo $proyecto_id; ?>" name="encargado" type="text" class="form-control"  value="<?php echo $encargado; ?>" disabled></div>
                                                  <div class="col-md-2">
                                                      <label for="contacto_<?php echo $proyecto_id; ?>">Contacto</label>
                                                      <input id="contacto_<?php echo $proyecto_id; ?>" name="contacto" type="text" class="form-control"  value="<?php echo $contacto; ?>" disabled></div>
                                                  <div class="col-md-2">
                                                      <label for="estatus_<?php echo $proyecto_id; ?>">Estatus</label>
                                                    <select  id="estatus_<?php echo $proyecto_id; ?>" name="estatus" class="form-control " >
                                                      <option value="ACTIVO" <?php if($estatus == 'ACTIVO' ){ echo "selected";} ?> >ACTIVO</option>
                                                      <option value="CONCLUIDO" <?php if($estatus == 'CONCLUIDO' ){ echo "selected";} ?> >CONCLUIDO</option>
                                                      <option value="CANCELADO" <?php if($estatus == 'CANCELADO' ){ echo "selected";} ?> >CANCELADO</option>
                                                    </select>
                                                  </div>
                                                  <div class="col-md-1">
                                                      <label for="proyecto_id_<?php echo $proyecto_id; ?>">Editar</label>
                                                        <button id="proyecto_id_<?php echo $proyecto_id; ?>" name="proyecto_id_<?php echo $proyecto_id; ?>" class="btn btn-default" type="button"><i class="material-icons">mode_edit</i></button>
                                                        <script>
                                                            $("#proyecto_id_<?php echo $proyecto_id; ?>").click(function(){    
                                                                //alert("titulo_<?php echo $proyecto_id; ?>");
                                                                
                                                                 $('#titulo_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                                 $('#descripcion_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                                 $('#encargado_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                                 $('#contacto_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                                 $('#estatus_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                                 $('#proyecto_id_<?php echo $proyecto_id; ?>').hide();
                                                                 $('#guardar<?php echo $proyecto_id; ?>').show();
                                                                 $('#linea_<?php echo $proyecto_id; ?>').removeClass( "bg-light-green" ).addClass('bg-grey');
        
                                                            });
                                                        </script>
                                                        <button style="display:  none" id="guardar<?php echo $proyecto_id; ?>"  class="btn btn-success" type="button"><i class="material-icons">save</i></button>
                                                        <script>
                                                            $("#guardar<?php echo $proyecto_id; ?>").click(function(){    
                                                                //alert("titulo_<?php echo $proyecto_id; ?>");
                                                                
                                                                var datastring = $("#form_<?php echo $proyecto_id; ?>").serialize();;
                                                               // alert(datastring);                    
                                                                $.ajax({
                                                                    url: "guardar_proyecto.php",
                                                                    type: "POST",
                                                                    data: datastring,
                                                                    cache: false,
                                                                    success:function(html){     
                                                                      //  alert(html); 
                                                                             $('#titulo_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                             $('#descripcion_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                             $('#encargado_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                             $('#contacto_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                             $('#estatus_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                             //$('#proyecto_id_<?php echo $proyecto_id; ?>').show();
                                                                             $('#guardar<?php echo $proyecto_id; ?>').hide();
                                                                             $('#linea_<?php echo $proyecto_id; ?>').removeClass( "bg-grey" ).addClass('bg-light-green');
                                                                                        }
                                                                    }); 
                                                                
        
        
                                                            });
                                                        </script>
                                                  </div>
                                                  
                                            </div>
                                            
                                            </form>
                                        <!-- <tr class="" id="linea_<?php echo $proyecto_id; ?>">
                                            

                                            <td><?php echo $proyecto_id; ?></td>
                                            <td><input id="titulo_<?php echo $proyecto_id; ?>" name="titulo" type="text" class="form-control"  value="<?php echo $titulo; ?>" disabled></td>
                                            <td><textarea id="descripcion_<?php echo $proyecto_id; ?>" name="descripcion" class="form-control" disabled><?php echo $descripcion; ?></textarea></td>
                                            <td><input id="encargado_<?php echo $proyecto_id; ?>" name="encargado" type="text" class="form-control"  value="<?php echo $encargado; ?>" disabled></td>
                                            <td><input id="contacto_<?php echo $proyecto_id; ?>" name="contacto" type="text" class="form-control"  value="<?php echo $contacto; ?>" disabled></td>
                                            <td>

                                                <select  id="estatus_<?php echo $proyecto_id; ?>" name="estatus" class="form-control " >
                                                  <option value="ACTIVO" <?php if($estatus == 'ACTIVO' ){ echo "selected";} ?> >ACTIVO</option>
                                                  <option value="CONCLUIDO" <?php if($estatus == 'CONCLUIDO' ){ echo "selected";} ?> >CONCLUIDO</option>
                                                  <option value="CANCELADO" <?php if($estatus == 'CANCELADO' ){ echo "selected";} ?> >CANCELADO</option>
                                                </select>

                                                
                                            </td>
                                            <td><button id="proyecto_id_<?php echo $proyecto_id; ?>" name="proyecto_id_<?php echo $proyecto_id; ?>" class="btn btn-default" type="button"><i class="material-icons">mode_edit</i></button>
                                                <script>
                                                    $("#proyecto_id_<?php echo $proyecto_id; ?>").click(function(){    
                                                        //alert("titulo_<?php echo $proyecto_id; ?>");
                                                        
                                                         $('#titulo_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                         $('#descripcion_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                         $('#encargado_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                         $('#contacto_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                         $('#estatus_<?php echo $proyecto_id; ?>').prop( 'disabled', false );
                                                         $('#proyecto_id_<?php echo $proyecto_id; ?>').hide();
                                                         $('#guardar<?php echo $proyecto_id; ?>').show();
                                                         $('#linea_<?php echo $proyecto_id; ?>').removeClass( "bg-light-green" ).addClass('bg-grey');

                                                    });
                                                </script>
                                                <button style="display:  none" id="guardar<?php echo $proyecto_id; ?>"  class="btn btn-success" type="button"><i class="material-icons">save</i></button>
                                                <script>
                                                    $("#guardar<?php echo $proyecto_id; ?>").click(function(){    
                                                        //alert("titulo_<?php echo $proyecto_id; ?>");
                                                        
                                                        var datastring = $("#form_<?php echo $proyecto_id; ?>").serialize();;
                                                        alert(datastring);                    
                                                        $.ajax({
                                                            url: "guardar_proyecto.php",
                                                            type: "POST",
                                                            data: datastring,
                                                            cache: false,
                                                            success:function(html){     
                                                                alert(html); 
                                                                     $('#titulo_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                     $('#descripcion_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                     $('#encargado_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                     $('#contacto_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                     $('#estatus_<?php echo $proyecto_id; ?>').prop( 'disabled', true );
                                                                     //$('#proyecto_id_<?php echo $proyecto_id; ?>').show();
                                                                     $('#guardar<?php echo $proyecto_id; ?>').hide();
                                                                     $('#linea_<?php echo $proyecto_id; ?>').removeClass( "bg-grey" ).addClass('bg-light-green');
                                                                                }
                                                            }); 
                                                        


                                                    });
                                                </script>
                                            </td>
                                            </form>
                                        </tr> -->
                                       
                                    <?php } ?>
                                    </div>
                                <!-- </table> -->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>





    
    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

    <!-- SweetAlert Plugin Js -->
    <!-- <script src="<?php echo $ruta; ?>plugins/sweetalert/sweetalert.min.js"></script> -->
    <!-- Ckeditor -->
    <!-- <script src="<?php echo $ruta; ?>plugins/ckeditor/ckeditor.js"></script> -->
    <!-- Custom Js -->
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <!-- TinyMCE -->
    <!-- <script src="<?php echo $ruta; ?>plugins/tinymce/tinymce.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/forms/editors.js"></script> -->
    <!-- SweetAlert Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/admin.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/tables/jquery-datatable.js"></script>
    <!-- <script src="<?php echo $ruta; ?>js/pages/ui/dialogs.js"></script>
    <script src="<?php echo $ruta; ?>js/demo.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/examples/profile.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/ui/notifications.js"></script> -->
    <!-- Autosize Plugin Js -->
    <!-- <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script> -->


    <script src="<?php echo $ruta; ?>js/demo.js"></script>
    




    
</body>

</html>
<?php
//include('footer.php');
?>