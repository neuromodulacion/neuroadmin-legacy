<?php
$ruta = "../../";
$titulo = "Gestión de Módulos";
include($ruta . 'header1.php');
include($ruta . 'header2.php');
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Gestión de Módulos</h2>
            <?php echo $ubicacion_url."<br>"; ?>
        </div>
        <div class="row clearfix">
            <!-- Formulario para agregar módulos -->
            <div class="col-lg-12">
                <div style="padding: 15px" class="card">
                    <div class="header">
                        <h2>Registrar Módulo</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="modulos.php">
                            <label for="nombre_modulo">Nombre del Módulo:</label>
                            <input type="text" class="form-control" name="nombre_modulo" id="nombre_modulo" required>
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
                            <hr>
                            <button type="submit" class="btn btn-primary m-t-15">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Tabla para listar módulos -->
            <div class="col-lg-12">
                <div style="padding: 15px" class="card">
                    <div class="header">
                        <h2>Lista de Módulos</h2>
                    </div>
                    <div class="body">
                        <table id="tabla-modulos" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se cargan los módulos usando JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Listar módulos
        fetch("modulos.php", { method: "GET" })
            .then(response => response.json())
            .then(data => {
                const tabla = document.querySelector("#tabla-modulos tbody");
                tabla.innerHTML = data.map(modulo =>
                    `<tr>
                        <td>${modulo.modulo_id}</td>
                        <td>${modulo.nombre_modulo}</td>
                        <td>${modulo.descripcion}</td>
                        <td>
                            <button class="btn btn-primary btn-edit" data-id="${modulo.modulo_id}" data-descripcion="${modulo.descripcion}">Editar</button>
                        </td>
                    </tr>`
                ).join("");

                // Asignar eventos de edición
                document.querySelectorAll(".btn-edit").forEach(button => {
                    button.addEventListener("click", function () {
                        const moduloId = this.dataset.id;
                        const descripcionActual = this.dataset.descripcion;

                        // Mostrar modal de edición
                        const nuevaDescripcion = prompt("Editar descripción:", descripcionActual);
                        if (nuevaDescripcion !== null) {
                            editarDescripcion(moduloId, nuevaDescripcion);
                        }
                    });
                });
            });

        // Función para editar la descripción de un módulo
        function editarDescripcion(moduloId, descripcion) {
            fetch("modulos.php", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `modulo_id=${moduloId}&descripcion=${encodeURIComponent(descripcion)}`
            })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    location.reload(); // Recargar tabla
                })
                .catch(err => console.error(err));
        }
    });
</script>

<?php include($ruta . 'footer1.php'); include($ruta . 'footer2.php'); ?>
