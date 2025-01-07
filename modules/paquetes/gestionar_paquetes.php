<?php
$ruta = "../../";
$titulo = "Gestión de Paquetes";
include($ruta . 'header1.php');
include($ruta . 'header2.php');
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Gestión de Paquetes</h2>
            <?php echo $ubicacion_url."<br>"; ?>
        </div>
        <div class="row clearfix">
            <!-- Formulario para agregar o editar paquetes -->
            <div class="col-lg-12">
                <div style="padding: 15px" class="card">
                    <div class="header">
                        <h2>Registrar / Editar Paquete</h2>
                    </div>
                    <div class="body">
                        <form id="form-paquete">
                            <input type="hidden" name="paquete_id" id="paquete_id">
                            <label for="nombre_paquete">Nombre del Paquete:</label>
                            <input type="text" class="form-control" name="nombre_paquete" id="nombre_paquete" required>
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
                            <label for="precio">Precio:</label>
                            <input type="number" step="0.01" class="form-control" name="precio" id="precio" required>
                            <label for="vigencia">Vigencia en días:</label>
                            <input type="number" class="form-control" name="vigencia" id="vigencia" required>
                            <label for="modulos">Módulos:</label>
                            <select style="height: 300px" name="modulos[]" id="modulos" class="form-control" multiple>
                                <?php
                                $queryModulos = "SELECT modulo_id, nombre_modulo FROM modulos";
                                $resultModulos = $mysql->consulta($queryModulos);
                                foreach ($resultModulos['resultado'] as $modulo) {
                                    echo "<option value='{$modulo['modulo_id']}'>{$modulo['nombre_modulo']}</option>";
                                }
                                ?>
                            </select>
                            <hr>
                            <button type="submit" class="btn btn-primary m-t-15">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Tabla para listar paquetes -->
            <div class="col-lg-12">
                <div style="padding: 15px" class="card">
                    <div class="header">
                        <h2>Lista de Paquetes</h2>
                    </div>
                    <div class="body">
                        <table id="tabla-paquetes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Vigencia</th>
                                    <th>Módulos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos cargados dinámicamente -->
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
        const form = document.querySelector("#form-paquete");
        const tabla = document.querySelector("#tabla-paquetes tbody");

        // Listar paquetes
        function listarPaquetes() {
            fetch("paquetes.php", { method: "GET" })
                .then(response => response.json())
                .then(paquetes => {
                    tabla.innerHTML = paquetes.map(paquete => `
                        <tr>
                            <td>${paquete.paquete_id}</td>
                            <td>${paquete.nombre_paquete}</td>
                            <td>${paquete.descripcion}</td>
                            <td>$ ${paquete.precio}</td>
                            <td>${paquete.vigencia}</td>
                            <td>${paquete.modulos.map(mod => mod.nombre_modulo).join(", ")}</td>
                            <td>
                                <button class="btn btn-primary btn-edit" data-paquete='${JSON.stringify(paquete)}'>Editar</button>
                            </td>
                        </tr>
                    `).join("");

                    // Agregar eventos de edición
                    document.querySelectorAll(".btn-edit").forEach(button => {
                        button.addEventListener("click", function () {
                            const paquete = JSON.parse(this.dataset.paquete);
                            form.reset();
                            document.querySelector("#paquete_id").value = paquete.paquete_id;
                            document.querySelector("#nombre_paquete").value = paquete.nombre_paquete;
                            document.querySelector("#descripcion").value = paquete.descripcion;
                            document.querySelector("#precio").value = paquete.precio;
                            document.querySelector("#vigencia").value = paquete.vigencia;
                            Array.from(document.querySelector("#modulos").options).forEach(option => {
                                option.selected = paquete.modulos.some(mod => mod.modulo_id == option.value);
                            });
                        });
                    });
                });
        }

        // Guardar paquete
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            fetch("paquetes.php", {
                method: "POST",
                body: new URLSearchParams(formData),
            })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    listarPaquetes();
                    form.reset();
                });
        });

        listarPaquetes();
    });
</script>
<?php 
include($ruta . 'footer1.php'); 
include($ruta . 'footer2.php'); ?>
