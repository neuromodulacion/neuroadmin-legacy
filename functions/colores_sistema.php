<div role="tabpanel" class="tab-pane fade in active in active" id="skins">
    <ul class="demo-choose-skin">
        <li id="red" data-theme="red">
            <div  class="red" <?php if ($body=='red') { echo 'class="active"'; } ?> ></div>
            <span id="red">Red</span>
        </li>
            <script>
                $("#red").click(function(){ 
                    var color_body = 'red';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                   //alert(datastring);
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                            //alert(html);
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                            });
                });
            </script> 
        <li id="pink" data-theme="pink"  <?php if ($body=='pink') { echo 'class="active"'; } ?> >
            <div class="pink"></div>
            <span >Pink</span>
        </li>
            <script>
                $("#pink").click(function(){ 
                    var color_body = 'pink';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                            });
                });
            </script>
        <li id="purple" data-theme="purple" <?php if ($body=='purple') { echo 'class="active"'; } ?> >
            <div class="purple"></div>
            <span id="purple">Purple</span>
        </li>
            <script>
                $("#purple").click(function(){ 
                    var color_body = 'purple';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="deep-purple" data-theme="deep-purple" <?php if ($body=='deep-purple') { echo 'class="active"'; } ?> >
            <div class="deep-purple"></div>
            <span>Deep Purple</span>
        </li>
            <script>
                $("#deep-purple").click(function(){ 
                    var color_body = 'deep-purple';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                            });
                });
            </script>
        <li id="indigo" data-theme="indigo" <?php if ($body=='indigo') { echo 'class="active"'; } ?> >
            <div class="indigo"></div>
            <span>Indigo</span>
        </li>
            <script>
                $("#indigo").click(function(){ 
                    var color_body = 'indigo';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="blue" data-theme="blue" <?php if ($body=='blue') { echo 'class="active"'; } ?> >
            <div class="blue"></div>
            <span>Blue</span>
        </li>
            <script>
                $("#blue").click(function(){ 
                    var color_body = 'blue';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                     });
                });
            </script>
        <li id="light-blue" data-theme="light-blue" <?php if ($body=='light-blue') { echo 'class="active"'; } ?> >
            <div class="light-blue"></div>
            <span>Light Blue</span>
        </li>
            <script>
                $("#light-blue").click(function(){ 
                    var color_body = 'light-blue';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                            });
                });
            </script>
        <li id="cyan" data-theme="cyan" <?php if ($body=='cyan') { echo 'class="active"'; } ?> >
            <div class="cyan"></div>
            <span>Cyan</span>
        </li>
            <script>
                $("#cyan").click(function(){ 
                    var color_body = 'cyan';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="teal" data-theme="teal" <?php if ($body=='teal') { echo 'class="active"'; } ?> >
            <div class="teal"></div>
            <span>Teal</span>
        </li>
            <script>
                $("#teal").click(function(){ 
                    var color_body = 'teal';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>

        <li id="aldana" data-theme="aldana" <?php if ($body=='aldana') { echo 'class="active"'; } ?> >
            <div class="aldana"></div>
            <span>Aldana</span>
        </li>
            <script>
                $("#aldana").click(function(){ 
                    var color_body = 'aldana';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
            
        <li id="green" data-theme="green" <?php if ($body=='green') { echo 'class="active"'; } ?> >
            <div class="green"></div>
            <span>Green</span>
        </li>
            <script>
                $("#green").click(function(){ 
                    var color_body = 'green';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                            });
                });
            </script>
        <li id="light-green" data-theme="light-green" <?php if ($body=='light-green') { echo 'class="active"'; } ?> >
            <div class="light-green"></div>
            <span>Light Green</span>
        </li>
            <script>
                $("#light-green").click(function(){ 
                    var color_body = 'light-green';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="lime" data-theme="lime" <?php if ($body=='lime') { echo 'class="active"'; } ?> >
            <div class="lime"></div>
            <span>Lime</span>
        </li>
            <script>
                $("#lime").click(function(){ 
                    var color_body = 'lime';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="yellow" data-theme="yellow" <?php if ($body=='yellow') { echo 'class="active"'; } ?> >
            <div class="yellow"></div>
            <span>Yellow</span>
        </li>
            <script>
                $("#yellow").click(function(){ 
                    var color_body = 'yellow';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="amber" data-theme="amber" <?php if ($body=='amber') { echo 'class="active"'; } ?> >
            <div class="amber"></div>
            <span>Amber</span>
        </li>
            <script>
                $("#amber").click(function(){ 
                    var color_body = 'yeamberllow';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="orange" data-theme="orange" <?php if ($body=='orange') { echo 'class="active"'; } ?> >
            <div class="orange"></div>
            <span>Orange</span>
        </li>
            <script>
                $("#orange").click(function(){ 
                    var color_body = 'orange';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";      
                         }
                                           });
                });
            </script>
        <li id="deep-orange" data-theme="deep-orange" <?php if ($body=='deep-orange') { echo 'class="active"'; } ?> >
            <div class="deep-orange"></div>
            <span>Deep Orange</span>
        </li>
            <script>
                $("#deep-orange").click(function(){ 
                    var color_body = 'deep-orange';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){  
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";    
                         }
                                           });
                });
            </script>
        <li id="brown" data-theme="brown" <?php if ($body=='brown') { echo 'class="active"'; } ?> >
            <div class="brown"></div>
            <span>Brown</span>
        </li>
            <script>
                $("#brown").click(function(){ 
                    var color_body = 'brown';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){ 
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";     
                         }
                                           });
                });
            </script>
        <li id="grey" data-theme="grey" <?php if ($body=='grey') { echo 'class="active"'; } ?> >
            <div class="grey"></div>
            <span>Grey</span>
        </li>
            <script>
                $("#grey").click(function(){ 
                    var color_body = 'grey';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){ 
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";     
                         }
                                           });
                });
            </script>
        <li id="blue-grey" data-theme="blue-grey" <?php if ($body=='blue-grey') { echo 'class="active"'; } ?> >
            <div class="blue-grey"></div>
            <span>Blue Grey</span>
        </li>
            <script>
                $("#blue-grey").click(function(){ 
                    var color_body = 'blue-grey';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){ 
                             window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";     
                         }
                                    });
                });
            </script>
        <li id="black" data-theme="black" <?php if ($body=='black') { echo 'class="active"'; } ?> >
            <div class="black"></div>
            <span>Black</span>
        </li>
            <script>
                $("#black").click(function(){ 
                    var color_body = 'black';
                    var ruta = "<?php echo $ruta; ?>";
                    var usuario_id = "<?php echo $usuario_id; ?>";
                    var datastring = 'color_body='+color_body+'&usuario_id='+usuario_id+'&ruta='+ruta;
                    $.ajax({
                        url: "<?php echo $ruta; ?>herramientas/body.php",
                        type: "POST",
                        data: datastring, 
                        cache: false,
                        success:function(html){  
                            window.location.href = "<?php echo $ruta.$ubicacion_url; ?>";   
                         }

                        });
                });
            </script>
    </ul>
                    
                