<?php
$ruta = "../../";
$titulo = "Gestión de Módulos";
include($ruta . 'header1.php');
include($ruta . 'header2.php');
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Gestión de Submenús</h2>
        </div>
        <div class="row clearfix">
            <!-- Formulario para agregar/editar submenús -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Registrar / Editar Submenú</h2>
                    </div>
                    <div class="body">
                        <form id="form-submenu">
                            <input type="hidden" name="sub_menu_id" id="sub_menu_id">
                            <label for="nombre_s">Nombre del Submenú:</label>
                            <input type="text" class="form-control" name="nombre_s" id="nombre_s" required>
                            <label for="ruta_submenu">Ruta del Submenú:</label>
                            <input type="text" class="form-control" name="ruta_submenu" id="ruta_submenu" required>
                            <label for="iconos">Ícono:</label>
                            <select class="form-control" id="iconos" name="iconos">
                                <!-- Opciones llenadas con Google Fonts Icons -->
                            </select>
                            <label for="menu_id">Menú Padre:</label>
                            <select class="form-control" name="menu_id" id="menu_id">
                                <!-- Opciones llenadas dinámicamente -->
                            </select>
                            
                            <label for="autorizacion">Autorización:</label>
                            <input type="text" class="form-control" name="autorizacion" id="autorizacion" required>
                            <button type="submit" class="btn btn-primary m-t-15">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Tabla para listar submenús -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Lista de Submenús</h2>
                    </div>
                    <div class="body table-responsive">
                        <table id="tabla-submenus" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Ruta</th>
                                    <th>Ícono</th>
                                    <th>Menú Padre</th>
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
        const form = document.querySelector("#form-submenu");
        const tabla = document.querySelector("#tabla-submenus tbody");

        // Llenar la lista de íconos desde Google Fonts Icons
        const iconSelector = document.querySelector("#iconos");
        fetch("https://fonts.google.com/icons?hl=es-419")
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");
                const icons = doc.querySelectorAll(".icon-name");
                icons.forEach(icon => {
                    const option = document.createElement("option");
                    option.value = icon.textContent.trim();
                    option.textContent = icon.textContent.trim();
                    iconSelector.appendChild(option);
                });
            });

        // Llenar la lista de menús
        fetch("menus.php", { method: "GET" })
            .then(response => response.json())
            .then(menus => {
                const menuSelector = document.querySelector("#menu_id");
                menus.forEach(menu => {
                    const option = document.createElement("option");
                    option.value = menu.menu_id;
                    option.textContent = menu.nombre_m;
                    menuSelector.appendChild(option);
                });
            });

        // Listar submenús
        function listarSubmenus() {
            fetch("submenus.php", { method: "GET" })
                .then(response => response.json())
                .then(submenus => {
                    tabla.innerHTML = submenus.map(submenu => `
                        <tr>
                            <td>${submenu.sub_menu_id}</td>
                            <td>${submenu.nombre_s}</td>
                            <td>${submenu.ruta_submenu}</td>
                            <td><i class="material-icons">${submenu.iconos}</i></td>
                            <td>${submenu.menu_nombre}</td>
                            <td>
                                <button class="btn btn-primary btn-edit" data-submenu='${JSON.stringify(submenu)}'>Editar</button>
                            </td>
                        </tr>
                    `).join("");

                    // Agregar eventos de edición
                    document.querySelectorAll(".btn-edit").forEach(button => {
                        button.addEventListener("click", function () {
                            const submenu = JSON.parse(this.dataset.submenu);
                            form.reset();
                            document.querySelector("#sub_menu_id").value = submenu.sub_menu_id;
                            document.querySelector("#nombre_s").value = submenu.nombre_s;
                            document.querySelector("#ruta_submenu").value = submenu.ruta_submenu;
                            document.querySelector("#iconos").value = submenu.iconos;
                            document.querySelector("#menu_id").value = submenu.menu_id;
                            document.querySelector("#autorizacion").value = submenu.autorizacion;
                        });
                    });
                });
        }

        // Guardar submenú
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            fetch("submenus.php", {
                method: "POST",
                body: new URLSearchParams(formData),
                
            })
                .then(response => response.text())
                .then(result => {
                    alert(result);
                    listarSubmenus();
                    form.reset();
                });
        });

        listarSubmenus();
    });
</script>
<?php include($ruta . 'footer1.php'); include($ruta . 'footer2.php'); ?>