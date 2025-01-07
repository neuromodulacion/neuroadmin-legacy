<?php
$ruta="../../";
include($ruta.'functions/conexion_mysqli.php');

// Incluir el archivo de configuración y obtener las credenciales
$configPath = $ruta.'../config.php';

if (!file_exists($configPath)) {
    die('Archivo de configuración no encontrado.');
}

$config = require $configPath;

// Crear una instancia de la clase Mysql
$mysql = new Mysql($config['servidor'], $config['usuario'], $config['contrasena'], $config['baseDatos']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $categoria = $_POST['categoria'];

    try {
        $mysql->conectarse();

        $query = "SELECT DISTINCT icono_id, nombre, icono, traduccion FROM iconos WHERE categoria = ?";
        $resultados = $mysql->consulta($query, [$categoria]);
		echo "<table style='width:100%' class=\"table\" >
				<tr>
					<th>Icono</th>
					<th>Nombre</th>
					<td>Acción</td>
				</tr>";
		// Verifica si hay resultados
		if ($resultados['numFilas'] > 0) {
		    // Itera a través de los resultados y los almacena en variables
		    foreach ($resultados['resultado'] as $fila) {
		        $icono_id = $fila['icono_id'];
		        $nombre = $fila['nombre'];
		        $icono = $fila['icono'];
		        $traduccion = $fila['traduccion'];
		
		        // Aquí puedes usar las variables, por ejemplo, imprimirlas
		        
		        ?>
			        <tr>
				        <td><?php echo $icono; ?></td>
				        <td><?php echo $traduccion; ?></td>
				        <td>	<button id='btn_<?php echo $icono_id; ?>' type='button' class='btn btn-primary m-t-15'>Selecciona</button>
			        	</td>
			        </tr>
					<script>
					    $('#btn_<?php echo $icono_id; ?>').click(function () {
					        var icono = '<?php echo $icono; ?>';
					        $('#icono_menu').val(icono);
					    });
					</script>

					<?php		              
			        
		    }
		} else {
		    echo "No se encontraron resultados para la categoría proporcionada.";
		}
		echo "</table>";
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo $e;
    }
} else {
    http_response_code(400);
}
?>
