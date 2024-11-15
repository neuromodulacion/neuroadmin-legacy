<?php
// Consulta SQL para obtener los eventos de la agenda asociados a una empresa específica
$sql_agenda = "
SELECT
    agenda.agenda_id, 
    agenda.paciente_id, 
    agenda.usuario_id, 
    agenda.f_ini, 
    agenda.h_ini, 
    agenda.f_fin, 
    agenda.h_fin, 
    agenda.f_registro, 
    agenda.h_registro, 
    agenda.color, 
    CONCAT(pacientes.paciente,' ',pacientes.apaterno,' ',pacientes.amaterno) as paciente,  
    agenda.observ, 
    pacientes.email, 
    pacientes.celular,
    pacientes.empresa_id
FROM
    agenda
    INNER JOIN pacientes ON agenda.paciente_id = pacientes.paciente_id
WHERE
    pacientes.empresa_id = $empresa_id";

// Ejecutar la consulta SQL y obtener los resultados
$result_agenda = ejecutar($sql_agenda);  
$cnt_agenda = mysqli_num_rows($result_agenda); // Contar el número de eventos obtenidos
?>

<script>
// Esperar a que el DOM esté completamente cargado antes de inicializar el calendario
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar'); // Elemento donde se renderizará el calendario
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // Configuración inicial del calendario
        initialDate: '<?php echo $hoy; ?>', // Fecha de inicio del calendario
        initialView: 'timeGridWeek', // Vista inicial por semana
        slotMinTime: '09:00:00', // Hora mínima mostrada en la cuadrícula
        slotMaxTime: '20:00:00', // Hora máxima mostrada en la cuadrícula
        headerToolbar: {    
            language: 'es', // Idioma del calendario
            left: 'prev,next today', // Botones de navegación
            center: 'title', // Título del calendario
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // Vistas disponibles
        },
        height: 'auto', // Altura automática para ajustar al contenido
        navLinks: true, // Permitir clic en los nombres de los días/semanas para navegar entre vistas
        editable: false, // Deshabilitar la edición directa de eventos
        selectable: false, // Deshabilitar la selección de rangos en el calendario
        selectMirror: false,
        weekNumbers: true, // Mostrar números de la semana
        nowIndicator: true, // Mostrar un indicador para la hora actual
        
        // Función para manejar la creación de un nuevo evento
        select: function(arg) {
            var title = prompt('Event Title:'); // Pedir al usuario un título para el evento
            if (title) {
              calendar.addEvent({
                title: title,
                start: arg.start,
                end: arg.end,
                allDay: arg.allDay
              })
            }
            calendar.unselect(); // Desmarcar la selección
        },

        // Función para manejar el clic en un evento existente
        eventClick: function(info) {
            var id = 'id=' + info.event.id; // Obtener el ID del evento
            $('#contenido').html(''); // Limpiar el contenido actual
            $('#load').show(); // Mostrar el indicador de carga
            $('#modal').click(); // Abrir el modal para ver detalles del evento
            
            // Realizar una solicitud AJAX para obtener detalles del evento
            $.ajax({
                url: 'evento.php',
                type: 'POST',
                data: id,
                cache: false,
                success:function(html){
                    $('#contenido').html(html); // Mostrar los detalles en el modal
                    $('#load').hide(); // Ocultar el indicador de carga
                }
            });
        },

        editable: true, // Permitir la edición de eventos arrastrando y soltando (no aplicable en este caso ya que está deshabilitado)
        dayMaxEvents: true, // Limitar la cantidad de eventos visibles por día
        events: [
            <?php
                $cnt = 1;
                // Iterar sobre los resultados de la consulta SQL y agregar cada evento al calendario
                while($row_agenda = mysqli_fetch_array($result_agenda)){
                    extract($row_agenda);
					echo " {    
                          title: '$paciente',
                          id: '$agenda_id',
                          start: '".$f_ini."T".$h_ini."',
                          end: '".$f_fin."T".$h_fin."',
                          color: '#3A87AD',
                          textColor: '#ffffff',
                          description: 'Lorem ipsum 1...'
                        } ";    
                    if ($cnt_agenda <> $cnt) {
                        echo ","; // Añadir una coma para separar los eventos en el array de JavaScript
                    }        
                    $cnt++;
                }
            ?>
        ]
    });

    // Renderizar el calendario en la página
    calendar.render();
});
</script>
