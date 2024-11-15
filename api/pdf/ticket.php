<!-- <!DOCTYPE html>
<html>
<head>
    <title>Imprimir Ticket</title>
    <script>
        function printPDF() {
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = '20240708025902.pdf';
            document.body.appendChild(iframe);
            iframe.onload = function() {
                iframe.contentWindow.print();
            };
        }
    </script>
</head>
<body>
    <button onclick="printPDF()">Imprimir Ticket</button>
</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
    <title>Imprimir Ticket</title>
    <script>
        function printPDF() {
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = '20240709203847.pdf';
            document.body.appendChild(iframe);
            iframe.onload = function() {
                iframe.contentWindow.print();
            };
        }

        window.onload = function() {
            printPDF();
        }
    </script>
</head>
<body>
    <p>Generando y enviando el ticket a la impresora...</p>
</body>
</html>
