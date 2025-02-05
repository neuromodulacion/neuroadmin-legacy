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
    #demo" {
        border: 2px solid #000000;
        
        max-width: 95%; /* Corrección aquí */
        min-width: 200px;
        height: 300px;
        box-sizing: border-box; /* Asegúrate de que el borde está incluido en el ancho */
    }
</style>
<style>
body{
    margin-top:20px;
    background:#ebeef0;
}
.panel {
    box-shadow: 0 2px 0 rgba(0,0,0,0.075);
    border-radius: 0;
    border: 0;
    margin-bottom: 24px;
}
.panel .panel-heading, .panel>:first-child {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.panel-heading {
    position: relative;
    height: 50px;
    padding: 0;
    border-bottom:1px solid #eee;
}
.panel-control {
    height: 100%;
    position: relative;
    float: right;
    padding: 0 15px;
}
.panel-title {
    font-weight: normal;
    padding: 0 20px 0 20px;
    font-size: 1.416em;
    line-height: 50px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.panel-control>.btn:last-child, .panel-control>.btn-group:last-child>.btn:first-child {
    border-bottom-right-radius: 0;
}
.panel-control .btn, .panel-control .dropdown-toggle.btn {
    border: 0;
}
.nano {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.nano>.nano-content {
    position: absolute;
    overflow: scroll;
    overflow-x: hidden;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.pad-all {
    padding: 15px;
}
.mar-btm {
    margin-bottom: 15px;
}
.media-block .media-left {
    display: block;
    float: left;
}
.img-sm {
    width: 46px;
    height: 46px;
}
.media-block .media-body {
    display: block;
    overflow: hidden;
    width: auto;
}
.pad-hor {
    padding-left: 15px;
    padding-right: 15px;
}
.speech {
    position: relative;
    background: #b7dcfe;
    color: #317787;
    display: inline-block;
    border-radius: 0;
    padding: 12px 20px;
}
.speech:before {
    content: "";
    display: block;
    position: absolute;
    width: 0;
    height: 0;
    left: 0;
    top: 0;
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-right: 7px solid #b7dcfe;
    margin: 15px 0 0 -6px;
}
.speech-right>.speech:before {
    left: auto;
    right: 0;
    border-top: 7px solid transparent;
    border-bottom: 7px solid transparent;
    border-left: 7px solid #ffdc91;
    border-right: 0;
    margin: 15px -6px 0 0;
}
.speech .media-heading {
    font-size: 1.2em;
    color: #317787;
    display: block;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    margin-bottom: 10px;
    padding-bottom: 5px;
    font-weight: 300;
}
.speech-time {
    margin-top: 20px;
    margin-bottom: 0;
    font-size: .8em;
    font-weight: 300;
}
.media-block .media-right {
    float: right;
}
.speech-right {
    text-align: right;
}
.pad-hor {
    padding-left: 15px;
    padding-right: 15px;
}
.speech-right>.speech {
    background: #ffda87;
    color: #a07617;
    text-align: right;
}
.speech-right>.speech .media-heading {
    color: #a07617;
}
.btn-primary, .btn-primary:focus, .btn-hover-primary:hover, .btn-hover-primary:active, .btn-hover-primary.active, .btn.btn-active-primary:active, .btn.btn-active-primary.active, .dropdown.open>.btn.btn-active-primary, .btn-group.open .dropdown-toggle.btn.btn-active-primary {
    background-color: #579ddb;
    border-color: #5fa2dd;
    color: #fff !important;
}
.btn {
    cursor: pointer;
    /* background-color: transparent; */
    color: inherit;
    padding: 6px 12px;
    border-radius: 0;
    border: 1px solid 0;
    font-size: 11px;
    line-height: 1.42857;
    vertical-align: middle;
    -webkit-transition: all .25s;
    transition: all .25s;
}
.form-control {
    font-size: 11px;
    height: 100%;
    border-radius: 0; 
    box-shadow: none; 
    border: 1px solid #e9e9e9;
    transition-duration: .5s;
}
.nano>.nano-pane {
    background-color: rgba(0,0,0,0.1);
    position: absolute;
    width: 5px;
    right: 0;
    top: 0; 
    bottom: 0;
    opacity: 0;
    -webkit-transition: all .7s; 
    transition: all .7s;
}	
</style>

<section class="content">
    <div class="container-fluid">
        <!-- ... -->
        <div align="center" class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div style="min-height: 450px;" class="header">
                        <div style="max-width: 100%" align="center" class="container">          	

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div>
    <div class="col-md-12 col-lg-12">
        <div class="panel">
        	<!--Heading-->
    		<div class="panel-heading">
    			<div class="panel-control">
    				<div class="btn-group">
    					<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#demo-chat-body"><i class="fa fa-chevron-down"></i></button>
    					<button type="button" class="btn btn-default" data-toggle="dropdown"><i class="fa fa-gear"></i></button>
    					<ul class="dropdown-menu dropdown-menu-right">
    						<li><a href="#">Available</a></li>
    						<li><a href="#">Busy</a></li>
    						<li><a href="#">Away</a></li>
    						<li class="divider"></li>
    						<li><a id="demo-connect-chat" href="#" class="disabled-link" data-target="#demo-chat-body">Connect</a></li>
    						<li><a id="demo-disconnect-chat" href="#" data-target="#demo-chat-body">Disconect</a></li>
    					</ul>
    				</div>
    			</div>
    			<h3 class="panel-title">Neuro Bot</h3>
    		</div>
    
    		<!--Widget body-->
    		<div style="border: 2px solid #eee;" id="demo-chat-body" class="collapse in">
    			<div class="nano has-scrollbar" style="height: 400px">
    				<div class="nano-content pad-all" tabindex="0" style="right: -17px;">
    					<ul class="list-unstyled media-block">
    						<li class="mar-btm">
    							<div class="media-left">
    								<img src="../images/neuro_bot.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor">
    								<div class="speech">
    									<a href="#" class="media-heading">Neuro Bot</a>
    									<p>Hello Lucy, how can I help you today ?</p>
    									<p class="speech-time">
    									<i class="fa fa-clock-o fa-fw"></i>09:23AM
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-right">
    								<img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor speech-right">
    								<div class="speech">
    									<a href="#" class="media-heading">Lucy Doe</a>
    									<p>Hi, I want to buy a new shoes.</p>
    									<p class="speech-time">
    										<i class="fa fa-clock-o fa-fw"></i> 09:23AM
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-left">
    								<img src="../images/neuro_bot.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor">
    								<div class="speech">
    									<a href="#" class="media-heading">Neuro Bot</a>
    									<p>Shipment is free. You\'ll get your shoes tomorrow!</p>
    									<p class="speech-time">
    										<i class="fa fa-clock-o fa-fw"></i> 09:25
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-right">
    								<img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor speech-right">
    								<div class="speech">
    									<a href="#" class="media-heading">Lucy Doe</a>
    									<p>Wow, that\'s great!</p>
    									<p class="speech-time">
    										<i class="fa fa-clock-o fa-fw"></i> 09:27
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-right">
    								<img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor speech-right">
    								<div class="speech">
    									<a href="#" class="media-heading">Lucy Doe</a>
    									<p>Ok. Thanks for the answer. Appreciated.</p>
    									<p class="speech-time">
    									<i class="fa fa-clock-o fa-fw"></i> 09:28
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-left">
    								<img src="../images/neuro_bot.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor">
    								<div class="speech">
    									<a href="#" class="media-heading">Neuro Bot</a>
    									<p>You are welcome! <br> Is there anything else I can do for you today?</p>
    									<p class="speech-time">
    										<i class="fa fa-clock-o fa-fw"></i> 09:30
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-right">
    								<img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor speech-right">
    								<div class="speech">
    									<a href="#" class="media-heading">Lucy Doe</a>
    									<p>Nope, That\'s it.</p>
    									<p class="speech-time">
    										<i class="fa fa-clock-o fa-fw"></i> 09:31
    									</p>
    								</div>
    							</div>
    						</li>
    						<li class="mar-btm">
    							<div class="media-left">
    								<img src="../images/neuro_bot.png" class="img-circle img-sm" alt="Profile Picture">
    							</div>
    							<div class="media-body pad-hor">
    								<div class="speech">
    									<a href="#" class="media-heading">Neuro Bot</a>
    									<p>Thank you for contacting us today</p>
    									<p class="speech-time">
    										<i class="fa fa-clock-o fa-fw"></i> 09:32
    									</p>
    								</div>
    							</div>
    						</li>
    					</ul>
    				</div>
    			<div class="nano-pane"><div class="nano-slider" style="height: 141px; transform: translate(0px, 0px);"></div></div></div>
    
    			<!--Widget footer-->
    			<div class="panel-footer">
    				<div class="row">
    					<div class="col-xs-9">
    						<input type="text" placeholder="Enter your text" class="form-control chat-input">
    					</div>
    					<div class="col-xs-3">
    						<button class="btn btn-primary btn-block" type="submit">Send</button>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
				                                           
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