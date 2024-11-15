<?php

?>
    <!-- Jquery Core Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<?php if ($ubicacion_url <> "paciente/pendientes.php") { ?>
    <!-- Jquery Validation Plugin Css -->
    <script src="<?php echo $ruta; ?>plugins/jquery-validation/jquery.validate.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/sweetalert/sweetalert.min.js"></script>
<?php }   ?>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/node-waves/waves.js"></script>

<?php if ($ubicacion_url <> "paciente/pendientes.php") { ?>
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo $ruta; ?>plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="<?php echo $ruta; ?>plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?php echo $ruta; ?>plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?php echo $ruta; ?>plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?php echo $ruta; ?>plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?php echo $ruta; ?>plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/jquery-sparkline/jquery.sparkline.js"></script>


    <!-- Autosize Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php echo $ruta; ?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<?php }   ?>
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
    <!-- Custom Js -->
    <script src="<?php echo $ruta; ?>js/admin.js"></script>
    
<?php if ($ubicacion_url <> "paciente/alta.php") { ?>
    <script src="<?php echo $ruta; ?>js/pages/index.js"></script>     
<?php }   ?>

	 <!-- form-wizard -->
    <!--<script src="<?php echo $ruta; ?>js/pages/forms/form-wizard.js"></script> -->

	<!-- form-wizard -->
    <!-- <script src="<?php echo $ruta; ?>js/pages/forms/basic-form-elements.js"></script> -->

    <!-- Demo Js -->
    <script src="<?php echo $ruta; ?>js/demo.js"></script>
</body>

</html>