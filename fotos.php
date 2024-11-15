

<form id="uploadForm" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
    <input type="button" value="Subir Foto" id="btnUpload">
</form>
<div id="status"></div>
<hr>
<!-- Elemento para la vista previa de la imagen -->
<input type="text" id="inputRutaImagen" name="rutaImagen" value="" readonly>
<hr>
<img width="300px" id="imagePreview" src="#" alt="Tu imagen aparecerá aquí" style="display:none;"/>
<hr>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#btnUpload").click(function() {
        var fileInput = $('#file')[0];
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        
        if(!allowedExtensions.exec(filePath)){
            alert('Por favor sube archivos con las extensiones .jpeg/.jpg/.png/.gif solamente.');
            fileInput.value = '';
            return false;
        }

        var formData = new FormData($("#uploadForm")[0]);

        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#status').html("uploads/"+data);

				$('#inputRutaImagen').val("uploads/"+data); 
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview')
                        .attr('src', e.target.result)
                        .show();

                    // Aquí se asume que data es un objeto con una propiedad rutaImagen
                    // $('#inputRutaImagen').val(nombreArchivo);                        
                };
                reader.readAsDataURL($("#file")[0].files[0]);
            },
            error: function() {
                $('#status').html('Ocurrió un error al subir la foto.');
            }
        });
    });
});
</script>



