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
                                ADMINISTRACION DE USUARIOS
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                    $sql_tabla = "
                                    SELECT DISTINCT
                                        admin.casa_id,
                                        admin.nombre,
                                        admin.funcion,
                                        casas.telefono_fijo,
                                        casas.celular,
                                        casas.tel_oficina,
                                        casas.mail,
                                        casas.tipo,
                                        casas.remoto,
                                        admin.observaciones
                                    FROM
                                        admin
                                    INNER JOIN casas ON admin.casa_id = casas.casas_id
                                    ";
                                    $result_tabla=ejecutar($sql_tabla); 
                                        //echo $cnt."<br>";      
                                        $saldo_t=0;
                                    while($row_tabla = mysqli_fetch_array($result_tabla)){
                                        extract($row_tabla); 
                                        if ($funcion=='NINGUNA') {
                                            $funcionx='';
                                        }else{
                                            $funcionx=" - ".$funcion;
                                        }
                                        $saldo_t = $saldo_t+$saldo;
                                        
                                        if ($remoto <>'NO') {
                                            $control ='<i class="material-icons">settings_remote</i>';
                                        } else {
                                            $control ='';
                                        }
                                        
                                        if ($celular <>'') {
                                            $cel ='<i class="material-icons">smartphone</i>';
                                        } else {
                                            $cel ='';
                                        }
                                        
                                        if ($mail <>'') {
                                            $cor ='<i class="material-icons">email</i>';
                                        } else {
                                            $cor ='';
                                        }
                                        ?>
                                  <div id="linea_<?php echo $casa_id; ?>" class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                      <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $casa_id; ?>" aria-expanded="false" aria-controls="collapse<?php echo $casa_id; ?>">
                                        <?php echo $control." ".$cel." ".$cor; ?>Casa <?php echo $casa_id." - ".$tipo." - ".$nombre.$funcionx; ?>
                                        </a>
                                      </h4>
                                    </div>
                                    <div id="collapse<?php echo $casa_id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $casa_id; ?>">
                                      <div id="body_<?php echo $casa_id; ?>" class="panel-body">
                                          <form target="_self" id="form_<?php echo $casa_id; ?>" class="form-horizontal"  method="post">
                                             <input type="hidden" id="casa_<?php echo $casa_id; ?>" name="casa_id" value="<?php echo $casa_id; ?>" /> 
                                            <div class="row">
                                              <div class="col-md-3">
                                                  <label for="nombre_<?php echo $casa_id; ?>"><span class="icon-name">Nombre</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">account_box</i></span>
                                                  <input id="nombre_<?php echo $casa_id; ?>" name="nombre" type="text" class="form-control" placeholder="Nombre del Vecino"  value="<?php echo $nombre; ?>" disabled>
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <label for="funcion_<?php echo $casa_id; ?><?php echo $casa_id; ?>"><span class="icon-name">Función en la Mesa Directiva</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">assignment</i></span>
                                                        <select id="funcion_<?php echo $casa_id; ?>" name="funcionx" class="form-control  show-tick" >
                                                          <option value="NINGUNA" <?php if($funcion == 'NINGUNA' ){ echo "selected";} ?> >NINGUNA</option>
                                                          <option value="VOCAL" <?php if($funcion == 'COBRA' ){ echo "selected";} ?> >COBRA</option>
                                                          <option value="ADMINISTRADOR" <?php if($funcion == 'ADMINISTRADOR' ){ echo "selected";} ?> >ADMINISTRADOR</option>
                                                          <option value="TESORERO" <?php if($funcion == 'TESORERO' ){ echo "selected";} ?> >TESORERO</option>
                                                          <option value="TESORERO" <?php if($funcion == 'SECRETARIO' ){ echo "selected";} ?> >SECRETARIO</option>
                                                          <option value="VOCAL" <?php if($funcion == 'VOCAL' ){ echo "selected";} ?> >VOCAL</option>
                                                        </select>
                                                    </div>
                                              </div>
                                              <div class="col-md-2">
                                                  <label for="telefono_fijo_<?php echo $casa_id; ?><?php echo $casa_id; ?>"><span class="icon-name">Teléfono Fijo</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">local_phone</i></span>
                                                    <input id="telefono_fijo_<?php echo $casa_id; ?>" name="telefono_fijo" type="text" class="form-control" placeholder="Teléfono Fijo" value="<?php echo $telefono_fijo; ?>" disabled>
                                                </div>
                                              </div>
                                              <div class="col-md-2">
                                                  <label for="celular_<?php echo $casa_id; ?><?php echo $casa_id; ?>"><span class="icon-name">Celular</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">smartphone</i></span>
                                                  <input id="celular_<?php echo $casa_id; ?>" name="celular" type="text" class="form-control" placeholder="Celular" value="<?php echo $celular; ?>" disabled>
                                                </div>
                                              </div>
                                              <div class="col-md-2">
                                                  <label for="tel_oficina_<?php echo $casa_id; ?><?php echo $casa_id; ?>"><span class="icon-name">Teléfono Oficina</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">contact_phone</i></span>
                                                  <input id="tel_oficina_<?php echo $casa_id; ?>" name="tel_oficina" type="text" class="form-control" placeholder="Teléfono Oficina" value="<?php echo $tel_oficina; ?>" disabled>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <label for="mail_<?php echo $casa_id; ?><?php echo $casa_id; ?>"><span class="icon-name">Correo Electronico</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">email</i></span>
                                                  <input id="mail_<?php echo $casa_id; ?>" name="mail" type="text" class="form-control" placeholder="Correo Electronico" value="<?php echo $mail; ?>" disabled>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <label for="remoto2_<?php echo $casa_id; ?>>"><span class="icon-name">Control del portón</span></label>
                                                  <div class="input-group">
                                                     <span class="input-group-addon"><i class="material-icons">settings_remote</i></span> 
                                                    <select  id="remoto2_<?php echo $casa_id; ?>" name="remoto" class="form-control  show-tick" >
                                                      
                                                      <option <?php if($remoto == 'NO' ){ echo "selected";} ?> >NO</option>
                                                      <option <?php if($remoto == 'MERIK 4 BOTONES' ){ echo "selected";} ?> >MERIK 4 BOTONES</option>
                                                      <option <?php if($remoto == 'AZUL CON ANTENA' ){ echo "selected";} ?> >AZUL CON ANTENA</option>
                                                      <option <?php if($remoto == 'OTRO' ){ echo "selected";} ?> >OTRO</option>
                                                    </select>
                                                </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <label for="tipo_<?php echo $casa_id; ?>"><span class="icon-name">Tipo de Habitante</span></label>
                                                  <div class="input-group">
                                                     <span class="input-group-addon"><i class="material-icons">home</i></span> 
                                                    <select  id="tipo_<?php echo $casa_id; ?>" name="tipo" class="form-control  show-tick" >
                                                      <option <?php if($tipo == 'ABANDONADA' ){ echo "selected";} ?> >ABANDONADA</option>
                                                      <option <?php if($tipo == 'DESCONOSIDO' || $tipo == ''){ echo "selected";} ?> >DESCONOSIDO</option>
                                                      <option <?php if($tipo == 'OTRO' ){ echo "selected";} ?> >OTRO</option>
                                                      <option <?php if($tipo == 'PRESTADO' ){ echo "selected";} ?> >PRESTADO</option>
                                                      <option <?php if($tipo == 'PROPIETARIO' ){ echo "selected";} ?> >PROPIETARIO</option>
                                                      <option <?php if($tipo == 'RENTA' ){ echo "selected";} ?> >RENTA</option>
                                                      
                                                      
                                                      
                                                    </select>
                                                </div>
                                              </div>

                                              <div id="dueno_<?php echo $casa_id; ?>" class="col-md-3">
                                                  <label for="nom_adic_<?php echo $casa_id; ?>"><span class="icon-name">Nombre del Dueño</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">account_box</i></span>
                                                  <input id="nom_adic_<?php echo $casa_id; ?>" name="nom_adic" type="text" class="form-control" placeholder="Nombre del Dueño" value="<?php echo $nom_adic; ?>" disabled>
                                                  </div>
                                              </div>
                                              <div id="tel_dueno_<?php echo $casa_id; ?>" class="col-md-3">
                                                  <label for="tel_adic_<?php echo $casa_id; ?>"><span class="icon-name">Teléfono Dueño</span></label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon"><i class="material-icons">assignment</i></span>
                                                    <input id="tel_adic_<?php echo $casa_id; ?>" name="tel_adic" type="text" class="form-control" placeholder="Teléfono Dueño" value="<?php echo $tel_adic; ?>" disabled>
                                                </div>
                                              </div>
                                              <?php if ($tipo == "PROPIETARIO") { ?>
                                                  <script>
                                                      $("#dueno_<?php echo $casa_id; ?>").hide();
                                                      $("#tel_dueno_<?php echo $casa_id; ?>").hide();
                                                  </script>
                                              <?php } ?>
                                              <div class="col-md-6">
                                                  <label for="observaciones_<?php echo $casa_id; ?>"><span class="icon-name">Observaciones</span></label>
                                                  <textarea class="form-control" id="observaciones_<?php echo $casa_id; ?>" name="observaciones" placeholder="Observaciones" disabled><?php echo $observaciones; ?></textarea>
                                              </div>

                                              <div class="col-md-3">
                                                    <button id="casa_id_<?php echo $casa_id; ?>" name="casa_id_<?php echo $casa_id; ?>" class="btn btn-info" type="button"><i class="material-icons">mode_edit</i>&nbsp;Editar</button>
                                                    <script>
                                                        $("#casa_id_<?php echo $casa_id; ?>").click(function(){    
                                                            //alert("nombre_<?php echo $casa_id; ?>");
                                                            var tipo = "<?php echo $tipo; ?>";
                                                             $('#nombre_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                             $('#funcion_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                             $('#telefono_fijo_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                             $('#celular_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                             $('#tel_oficina_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                             $('#mail_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                             $('#remoto2_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                              $('#observaciones_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                              $('#tipo_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                              if (tipo !== "PROPIETARIO") {
                                                                  $('#nom_adic_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                                  $('#tel_adic_<?php echo $casa_id; ?>').prop( 'disabled', false );
                                                              };
                                                             $('#casa_id_<?php echo $casa_id; ?>').hide();
                                                             $('#guardar<?php echo $casa_id; ?>').show();
                                                             $('#linea_<?php echo $casa_id; ?>').removeClass( "panel-default" ).addClass('panel-info');
                                                            $('#body_<?php echo $casa_id; ?>').addClass('alert alert-info');
                                                        });
                                                    </script>
                                                    <button style="display:  none" id="guardar<?php echo $casa_id; ?>"  class="btn btn-success" type="button"><i class="material-icons">save</i>&nbsp;Guardar</button>
                                                    <script>
                                                        $("#guardar<?php echo $casa_id; ?>").click(function(){    
                                                            //alert("nombre_<?php echo $casa_id; ?>");
                                                            var tipo = "<?php echo $tipo; ?>";
                                                            var datastring = $("#form_<?php echo $casa_id; ?>").serialize();;
                                                            //alert(datastring);                    
                                                            $.ajax({
                                                                url: "guardar_usuario.php",
                                                                type: "POST",
                                                                data: datastring,
                                                                cache: false,
                                                                success:function(html){     
                                                                    //alert(html); 
                                                                         $('#nombre_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                         
                                                                         $('#telefono_fijo_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                         $('#celular_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                         $('#tel_oficina_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                         $('#mail_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                         $('#observaciones_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                          
                                                                          $('#remoto2_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                          $('#funcion_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                          $('#tipo_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                          
                                                                          if (tipo !== "PROPIETARIO") {
                                                                              $('#nom_adic_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                              $('#tel_adic_<?php echo $casa_id; ?>').prop( 'disabled', true );
                                                                          };
                                                                         $('#casa_id_<?php echo $casa_id; ?>').show();
                                                                         $('#guardar<?php echo $casa_id; ?>').hide();
                                                                         $('#linea_<?php echo $casa_id; ?>').removeClass( "panel-info" ).addClass('panel-success');
                                                                         $('#body_<?php echo $casa_id; ?>').removeClass( "alert alert-info" ).addClass('alert alert-success');
                                                                                    }
                                                                }); 
                                                            
    
    
                                                        });
                                                    </script>
                                              </div>
                                            </div>
                                            </form>

                                      </div>
                                    </div>
                                  </div>
                                 <?php } ?>
                                </div>
                                
                                
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