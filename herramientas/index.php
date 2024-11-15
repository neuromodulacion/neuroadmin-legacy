<?php
$ruta="../../admin_35mm/";
$title = 'PERFIL';
include($ruta.'header.php');
$ruta_foto="images/".$estudio_id."/usuarios";
$ruta_foto1 = "images/".$estudio_id."/usuarios";

$ubicacion_url = $_SERVER['PHP_SELF']; 
$ubicacion_url ='..'.$ubicacion_url;
?>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>
<input type="hidden" id="ruta_foto1" name="ruta_foto1" value="<?php echo $ruta_foto1; ?>" />
<script type="text/javascript" language='javascript' src="<?php echo $ruta; ?>js/AjaxUpload.2.0.min.js"></script>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <div class="row clearfix">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header bg-<?php echo $body; ?>" >&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img id="foto_perfil1" style="width: 80%" src="<?php echo valida_fotos($ruta.$foto_user); ?>" alt="Imagen de Perfil" />
                            </div>
                            <div class="content-area">
                                <h3><?php echo $nombre_corto_user; ?></h3>
                                <!-- <p>Web Software Developer</p> -->
                                <p><?php echo $tipo_user; ?></p>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li>
                                    <span>Sesiones Realizadas</span>
                                    <span>1.234</span>
                                </li>
                                <li>
                                    <span>Sesiones Pendientes</span>
                                    <span>1.201</span>
                                </li>
                                <li>
                                    <span>Clientes</span>
                                    <span>14.252</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs tab-col-<?php echo $body; ?>" role="tablist">
                                    <!-- <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Inicio</a></li> -->
                                    <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class='material-icons'>person</i><span>&nbsp;Perfil</span></a></li>
                                    <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class='material-icons'>vpn_key</i><span>&nbsp;Contraseña</span></a></li>
                                    <?php if ($nivel<=2) { ?>
                                        <li role="presentation"><a href="#herramientas_user" aria-controls="settings" role="tab" data-toggle="tab"><i class='material-icons'>people</i><span>&nbsp;Usuarios</span></a></li>
                                        <li role="presentation"><a href="#alta_user" aria-controls="settings" role="tab" data-toggle="tab"><i class='material-icons'>person_add</i><span>&nbsp;Alta de Usuarios</span></a></li>
                                        <li role="presentation"><a href="#empresa" aria-controls="settings" role="tab" data-toggle="tab"><i class='material-icons'>business_center</i><span>&nbsp;Datos de Empresa</span></a></li>
                                    <?php } ?>
                                </ul>
                                <div class="tab-content">
                                    <!-- <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        
                                    </div> -->
                                    <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                                        <form target="_self" id="guarda_perfil" class="form-horizontal">
                                           <div  class="form-group">
                                                <label for="nombre" class="col-sm-3 control-label">Foto del Usuario</label>
                                                <div align="center" class="col-md-4">
                                                           <?php $id_foto="_perfil"; ?>
                                                        <div align="center" style="height: 270px;" id="wraper">
                                                            <input type="hidden" id="image_principal" name="image_principal" value=""> 
                                                                <section class="contentLayout" id="contentLayout">
                                                                    <div id="contenedorImagen<?php echo $id_foto; ?>">
                                                                        <img id="fotografia<?php echo $id_foto; ?>" name="fotografia<?php echo $id_foto; ?>" 
                                                                        class="img-responsive img-thumbnail" src="<?php echo valida_fotos($ruta.$foto_user); ?>"  
                                                                        style="margin: 10px; min-width:140px; max-width:180px; max-height:180px;">
                                                                    </div>
                                                                </section> 
                                                                <h6 style="text-align: center">Solo imagenes jpg, png, gif y menores de 1 mb.</h6>
                                                                <a class="btn btn-info" id="addImage<?php echo $id_foto; ?>"><i class="material-icons">add_a_photo</i><span class="icon-name">&nbsp;&nbsp;Imagen</span> </a>
                                                            </br>
                                                            </br>
                                                        </div>
                                                        <script>
                                                                $(function() {
                                                                // Botón para subir la firma
                                                                var nom ="perfil";
                                                                var ruta_foto ="<?php echo $ruta_foto; ?>";
                                                                var btn_firma = $('#addImage<?php echo $id_foto; ?>'), interval;
                                                                
                                                                    new AjaxUpload('#addImage<?php echo $id_foto; ?>', {
                                                                        action: '<?php echo $ruta; ?>uploadFile.php',
                                                                        onSubmit : function(file , ext){
                                                                            if (! (ext && /^(jpg|png|JPG|PNG|jpeg|JPEG|gif|GIF)$/.test(ext))){
                                                                                // extensiones permitidas
                                                                                alert('Sólo se permiten imagenes .gif, .jpeg, .jpg o .png');
                                                                                // cancela upload
                                                                                return false;
                                                                            } else {
                                                                                $('#loaderAjax<?php echo $id_foto; ?>').show();
                                                                                //alert(ruta_foto+" "+nom);
                                                                                btn_firma.text('Su imagen se esta cargando');
                                                                                this.disable();
                                                                                this.setData({ruta: ruta_foto, nom_f: nom});
                                                                                
                                                                            }
                                                                        },
                                                                        onComplete: function(file, response){
                                                                            //alert(response);
                                                                            btn_firma.text('Cambiar Imagen');
                                                                             this.enable();
                                                                            respuesta = $.parseJSON(response);
                                                                            //alert(respuesta.respuesta);
                                                                            if(respuesta.respuesta == 'done'){
                                                                                $('#fotografia<?php echo $id_foto; ?>').removeAttr('src');
                                                                                //alert(respuesta.mensaje+" respuesta");
                                                                                $('#fotografia<?php echo $id_foto; ?>').attr('src',"../"+ruta_foto+"/"+respuesta.mensaje);
                                                                                $('#user_header').attr('src',"../"+ruta_foto+"/"+respuesta.mensaje);
                                                                                $('#foto_perfil1').attr('src',"../"+ruta_foto+"/"+respuesta.mensaje);
                                                                                var ruta1=$('#ruta_foto1').val();
                                                                                $('#image_principal').val(ruta1+"/"+respuesta.mensaje)
                                                                                //alert(ruta1+"/"+respuesta.mensaje);
                                                                                var ubicacion = ruta1+"/"+respuesta.mensaje;
                                                                                var nom = respuesta.mensaje;
                                                                                var user_id = '<?php echo $user_id; ?>';
                                                                                var tipo_g="foto_perfil";
                                                                                var datastring = "user_id="+user_id+"&foto_user="+ubicacion+"&tipo_g="+tipo_g;
                                                                                //alert(ubicacion);
                                                                                
                                                                                $.ajax({
                                                                                    url: "guardar.php",
                                                                                    type: "POST",
                                                                                    data: datastring,
                                                                                    cache: true,
                                                                                    success:function(html){
                                                                                            $('#loaderAjax<?php echo $id_foto; ?>').hide();
                                                                                            $.notifyDefaults({
                                                                                                type: 'success',
                                                                                                allow_dismiss: false
                                                                                            });
                                                                                            $.notify("<h5><span><i class='material-icons'>done</i> Se cargo la foto correctamente </span></h5>");
                                                                                            
                                                                                        }
                                                                                    });
                                                                            }
                                                                            else{
                                                                                //alert(respuesta.mensaje); 
                                                                                var messenger = respuesta.mensaje;
                                                                                $.notifyDefaults({
                                                                                    type: 'danger',
                                                                                    allow_dismiss: false
                                                                                });
                                                                                $.notify("<h5><span><i class='material-icons'>error</i> "+messenger+"</span></h5>");
                                                                                $('#loaderAjax<?php echo $id_foto; ?>').hide();
                                                                            }
                                                                                this.enable(); 
                                                                        }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                <div align="center" class="col-sm-5">
                                                    <div style="display: none" id="loaderAjax<?php echo $id_foto; ?>" >
                                                        <div class="preloader">
                                                            <div class="spinner-layer pl-<?php echo $body; ?>">
                                                                <div class="circle-clipper left">
                                                                    <div class="circle"></div>
                                                                </div>
                                                                <div class="circle-clipper right">
                                                                    <div class="circle"></div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <h4>Subiendo archivo...</h4>
                                                    </div>
                                                </div>
                                           </div>
                                            <div class="form-group">
                                                <label for="nombre_user" class="col-sm-4 control-label">Nombre Completo</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control " id="nombre_user" name="nombre" placeholder="Nombre Completo" value="<?php echo $nombre_user; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NameSurname" class="col-sm-4 control-label">Nombre Corto</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="nombre_corto_user" name="nombre_corto_user" placeholder="Nombre Corto" value="<?php echo $nombre_corto_user; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipo_id" class="col-sm-4 control-label">Tipo de usuario</label>
                                                <div class="col-sm-8">
                                                        <div class="form-line">
                                                            <?php echo $tipo_user; ?>
                                                        </div>
                                                        <!-- <select class="form-control show-tick" id="tipo_id" name="tipo_id" disabled>
                                                            <option value="">-- Seleciona --</option>
                                                            <?php if($nivel == "1"){ ?><option <?php if($tipo_id == "1"){ echo "selected";} ?> value="1">Sistemas</option><?php } ?>
                                                            <option <?php if($tipo_id == "2"){ echo "selected";} ?> value="2">Administracion</option>
                                                            <option <?php if($tipo_id == "3"){ echo "selected";} ?> value="3">Editor</option>
                                                        </select> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-4 control-label">Email</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <b><?php echo $email; ?></b>
                                                        <!-- <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-4 control-label">Clabe de Referencia</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <h3>S4NZ*</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">GUARDAR</button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="tipo_g" name="tipo_g" value="guarda_perfil" />
                                        </form>
                                        <script>
                                            $("#guarda_perfil").submit(function(){ 
                                                var datastring = $("#guarda_perfil").serialize();
                                                 //alert(datastring);
                                                $.ajax({
                                                    url: "guardar.php",
                                                    type: "POST",
                                                    data: datastring, 
                                                    cache: false,
                                                    success:function(html){
                                                        // alert(html);     
                                                     }
                                                 });
                                                
                                            });
                                        </script>
                                        
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                        <form id="guarda_pwd" class="form-horizontal">
                                            <div class="form-group">
                                                <label for="vieja" class="col-sm-3 control-label">Contraseña Vieja</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="vieja" name="vieja" placeholder="Contraseña Vieja" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPassword" class="col-sm-3 control-label">Contraseña Nueva</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="Contraseña Nueva" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPasswordConfirm" class="col-sm-3 control-label">Contraseña Nueva (Confirm)</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="NewPasswordConfirm" name="NewPasswordConfirm" placeholder="Contraseña Nueva (Confirmar)" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-danger">GUARDAR</button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="tipo_g1" name="tipo_g" value="guarda_pwd" />
                                        </form>
                                        <script>
                                            $("#guarda_pwd").submit(function(){ 
                                                var pwd = "<?php echo $contra_cambio; ?>";
                                                var vieja = $("#vieja").val();
                                                if (pwd === vieja) {
                                                    var NewPassword1 = $("#NewPassword").val();
                                                    var NewPasswordConfirm1 = $("#NewPasswordConfirm").val();
                                                    if (NewPassword1 === NewPasswordConfirm1) {
                                                        var datastring = $("#guarda_pwd").serialize();
                                                         alert(datastring);
                                                        $.ajax({
                                                            url: "guardar.php",
                                                            type: "POST",
                                                            data: datastring, 
                                                            cache: false,
                                                            success:function(html){
                                                               //  alert(html);     
                                                             }
                                                         });
                                                    } else{
                                                        alert("La nueva contraseña no coincide en la confirmación");
                                                    };
                                                } else{
                                                    alert("Tu Contraseña es incorecta no se modifico");
                                                };
                                            });
                                        </script>
                                    </div>
                                    
                                    <div role="tabpanel" class="tab-pane fade in" id="herramientas_user">
                                        <h3>Usuarios</h3>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Tipo</th>
                                                <th>E-mail</th>
                                                <th>Estatus</th>
                                                <th>Editar</th>
                                            </tr>
                                            <?php
                                                $sql_users="
                                                    SELECT
                                                        usuarios.user_id as id,
                                                        usuarios.nombre as nombre_us,
                                                        usuarios.estatus as estatus_us,
                                                        tipo_user.tipo as tipo_us,
                                                        herramientas_sistema.email as email_us
                                                    FROM
                                                        usuarios
                                                    INNER JOIN tipo_user ON usuarios.tipo_id = tipo_user.tipo_id
                                                    INNER JOIN herramientas_sistema ON herramientas_sistema.user_id = usuarios.user_id
                                                    WHERE usuarios.estudio_id = $estudio_id  and usuarios.user_id<>$user_id";
                                                //echo $sql_estado."<br>";
                                                $result_users=ejecutar($sql_users); 
                                                        while($row_users = mysqli_fetch_array($result_users)){
                                                            extract($row_users);
                                            ?>
                                            <tr>
                                                <td><?php echo $nombre_us; ?></td>
                                                <td><?php echo $tipo_us; ?></td>
                                                <td><?php echo $email_us; ?></td>
                                                <td><?php echo $estatus_us; ?></td>
                                                <td>
                                                    <button id="boton_<?php echo $id; ?>" class="btn btn-default waves-effect" data-toggle="modal" data-target="#defaultModal"><i class="material-icons">mode_edit</i></button>
                                                    <script>
                                                        $("#boton_<?php echo $id; ?>").click(function(){ 
                                                            $("#contenido").html('');
                                                            var id = '<?php echo $id; ?>';
                                                            var tipo_g = 'editar_user';
                                                            var datastring = 'id='+id+'&tipo_g='+tipo_g;
                                                            // alert(datastring);
                                                            $.ajax({
                                                                url: "guardar.php",
                                                                type: "POST",
                                                                data: datastring, 
                                                                cache: false,
                                                                success:function(html){
                                                                    // alert(html);
                                                                    $("#contenido").html(html);     
                                                                 }
                                                             });
                                                            
                                                        });
                                                    </script>
                                                </td>
                                            </tr>
                                            <?php
            }
                                            ?>
                                         </table>
                                            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="defaultModalLabel">Editar Usuario</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="contenido">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    
                                    <div role="tabpanel" class="tab-pane fade in" id="alta_user">
                                        <form id="alta_emp" class="form-horizontal">
                                            <div class="form-group">
                                                <label for="nombre" class="col-sm-4 control-label">Nombre Completo</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control " id="nombre_user1" name="nombre" placeholder="Nombre Completo" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NameSurname" class="col-sm-4 control-label">Nombre Corto</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="nombre_corto_user1" name="nombre_corto_user" placeholder="Nombre Corto" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipo_id" class="col-sm-4 control-label">Tipo de usuario</label>
                                                <div class="col-sm-8">
                                                        <select class="form-control show-tick" id="tipo_id1" name="tipo_id_g" required>
                                                            <option value="">-- Seleciona --</option>
                                                            <option value="2">Administracion</option>
                                                            <option value="3">Editor</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-4 control-label">Email</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" id="email1" name="email_g" placeholder="Email" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">GUARDAR ALTA</button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="tipo_g2" name="tipo_g" value="alta_emp" />
                                        </form>
                                        <script>
                                            $("#alta_emp").submit(function(){ 
                                                var datastring = $("#alta_emp").serialize();
                                                 //alert(datastring);
                                                $.ajax({
                                                    url: "guardar.php",
                                                    type: "POST",
                                                    data: datastring, 
                                                    cache: false,
                                                    success:function(html){
                                                         alert(html);     
                                                     }
                                                 });
                                                
                                            });
                                        </script>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="empresa">
                                        <form id="guarda_emp" class="form-horizontal">
                                            <div  class="form-group">
                                                <label for="nombre" class="col-sm-3 control-label">Logotio del Estudio</label>
                                                <div align="center" class="col-md-4">
                                                           <?php $id_foto="_logotipo"; ?>
                                                        <div align="center" style="height: 270px;" id="wraper">
                                                            
                                                            <input type="hidden" id="image_principal1" name="image_principal1" value=""> 
                                                                <section class="contentLayout" id="contentLayout">
                                                                    <div id="contenedorImagen<?php echo $id_foto; ?>">
                                                                        <img id="fotografia<?php echo $id_foto; ?>" name="fotografia<?php echo $id_foto; ?>" 
                                                                        class="img-responsive img-thumbnail" src="<?php echo valida_fotos($ruta.$logo_estudio); ?>"  
                                                                        style="margin: 10px; min-width:140px; max-width:180px; max-height:180px;">
                                                                    </div>
                                                                </section> 
                                                                <h6 style="text-align: center">Solo imagenes jpg, png, gif y menores de 1 mb.</h6>
                                                                <a class="btn btn-info" id="addImage<?php echo $id_foto; ?>"><i class="material-icons">add_a_photo</i><span class="icon-name">&nbsp;&nbsp;Imagen</span> </a>
                                                            
                                                            </br>
                                                        </div>
                                                        <script>
                                                                $(function() {
                                                                // Botón para subir la firma
                                                                var nom ="logotipo";
                                                                var ruta_foto ="<?php echo $ruta_foto; ?>";
                                                                var btn_firma = $('#addImage<?php echo $id_foto; ?>'), interval;
                                                                
                                                                    new AjaxUpload('#addImage<?php echo $id_foto; ?>', {
                                                                        action: '<?php echo $ruta; ?>uploadFile.php',
                                                                        onSubmit : function(file , ext){
                                                                            if (! (ext && /^(jpg|png|JPG|PNG|jpeg|JPEG|gif|GIF)$/.test(ext))){
                                                                                // extensiones permitidas
                                                                                alert('Sólo se permiten imagenes .gif, .jpeg, .jpg o .png');
                                                                                // cancela upload
                                                                                return false;
                                                                            } else {
                                                                                $('#loaderAjax<?php echo $id_foto; ?>').show();
                                                                                //alert(ruta_foto+" "+nom);
                                                                                btn_firma.text('Su imagen se esta cargando');
                                                                                this.disable();
                                                                                this.setData({ruta: ruta_foto, nom_f: nom});
                                                                                
                                                                            }
                                                                        },
                                                                        onComplete: function(file, response){
                                                                            //alert(response);
                                                                            btn_firma.text('Cambiar Imagen');
                                                                             this.enable();
                                                                            respuesta = $.parseJSON(response);
                                                                            //alert(respuesta.respuesta);
                                                                            if(respuesta.respuesta == 'done'){
                                                                                $('#fotografia<?php echo $id_foto; ?>').removeAttr('src');
                                                                                //alert(respuesta.mensaje+" respuesta");
                                                                                $('#fotografia<?php echo $id_foto; ?>').attr('src',"../"+ruta_foto+"/"+respuesta.mensaje);
                                                                                $('#logo_header').attr('src',"../"+ruta_foto+"/"+respuesta.mensaje);
                                                                                $('#loaderAjax<?php echo $id_foto; ?>').show();
                                                                                var ruta1=$('#ruta_foto1').val();
                                                                                $('#image_principal1').val(ruta1+"/"+respuesta.mensaje)
                                                                                //alert(ruta1+"/"+respuesta.mensaje);
                                                                                var ubicacion = ruta1+"/"+respuesta.mensaje;
                                                                                var nom = respuesta.mensaje;
                                                                                var estudio_id = '<?php echo $estudio_id; ?>';
                                                                                var tipo_g="logo";
                                                                                var datastring = "estudio_id="+estudio_id+"&logo_estudio="+ubicacion+"&tipo_g="+tipo_g;
                                                                                //alert(datastring);
                                                                                
                                                                                $.ajax({
                                                                                    url: "guardar.php",
                                                                                    type: "POST",
                                                                                    data: datastring,
                                                                                    cache: true,
                                                                                    success:function(html){
                                                                                            $.notifyDefaults({
                                                                                                type: 'success',
                                                                                                allow_dismiss: false
                                                                                            });
                                                                                            $.notify("<h5><span><i class='material-icons'>done</i> Se cargo el logotipo correctamente </span></h5>");
                                                                                            $('#loaderAjax<?php echo $id_foto; ?>').hide();
                                                                                        }
                                                                                    });
                                                                            }
                                                                            else{
                                                                                //alert(respuesta.mensaje); 
                                                                                var messenger = respuesta.mensaje;
                                                                                $.notifyDefaults({
                                                                                    type: 'danger',
                                                                                    allow_dismiss: false
                                                                                });
                                                                                $.notify("<h5><span><i class='material-icons'>error</i> "+messenger+"</span></h5>");
                                                                                $('#loaderAjax<?php echo $id_foto; ?>').hide();
                                                                            }
                                                                                this.enable(); 
                                                                        }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                <div align="center" class="col-sm-5">
                                                    
                                                  <div style="display: none" id="loaderAjax<?php echo $id_foto; ?>" >
                                                        <div class="preloader">
                                                            <div class="spinner-layer pl-<?php echo $body; ?>">
                                                                <div class="circle-clipper left">
                                                                    <div class="circle"></div>
                                                                </div>
                                                                <div class="circle-clipper right">
                                                                    <div class="circle"></div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <h4>Subiendo archivo...</h4>
                                                    </div>
                                                </div>
                                           </div>
                                            <div class="form-group">
                                                <label for="nombre" class="col-sm-4 control-label">Nombre Empresa</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control " id="nom_estudio" name="nom_estudio" placeholder="Nombre Empresa" value="<?php echo $nom_estudio; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre" class="col-sm-4 control-label">% Utilidad Esperada</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="number" class="form-control " id="utilidad" name="utilidad1" placeholder="Utilidad" step=".01" min="0" value="<?php echo $utilidad; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">GUARDAR</button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="tipo_g3" name="tipo_g" value="guarda_emp" />
                                        </form>
                                        <script>
                                            $("#guarda_emp").submit(function(){ 
                                                var datastring = $("#guarda_emp").serialize();
                                                 alert(datastring);
                                                $.ajax({
                                                    url: "guardar.php",
                                                    type: "POST",
                                                    data: datastring, 
                                                    cache: false,
                                                    success:function(html){
                                                         alert(html);     
                                                     }
                                                 });
                                                
                                            });
                                        </script>
                                    </div>
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

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/admin.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/ui/dialogs.js"></script>
    <script src="<?php echo $ruta; ?>js/demo.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/examples/profile.js"></script>
    <script src="<?php echo $ruta; ?>js/pages/ui/notifications.js"></script>
    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-notify/bootstrap-notify.js"></script>


    
</body>

</html>
<?php
//include('footer.php');
?>