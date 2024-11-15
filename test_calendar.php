<?php

extract($_GET);

echo base64_decode($foo)."<br>";
echo base64_decode($bar);
// En la página destino, decodificar los datos recibidos

//$datos_recibidos = urldecode($url);
//$datos_recibidos = urldecode($_GET['dato']);

$datos_recibidos = urldecode($_GET['dato']);

echo $datos_recibidos."<hr>";

?>
<!-- <!DOCTYPE html>
<html>
  <head>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        })
        calendar.render()
      })

    </script>
  </head>
  <body>hola
    <div id='calendar'></div>
  </body>
</html> -->
<!-- <!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />

<link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5/main/css/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@5/main/js/main.js'></script>


    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid' ]
        });

        calendar.render();
      });

    </script>
  </head>
  <body>

    <div id='calendar'></div>

  </body>
</html> -->