<?php
// Credenciales FTP
$ftp_server = "svgm412.serverneubox.com.mx";
$ftp_user = "neuroadmin-legacy@neuromodulaciongdl.com";
$ftp_pass = "^k+jdYyxBQ2R";
$remote_dir = "/neuromodulaciongdl.com"; // Directorio en el servidor
$local_dir = "/tmp/repositorio"; // Directorio temporal local

// Clona o actualiza el repositorio en el servidor local
if (!is_dir($local_dir)) {
    shell_exec("git clone https://github.com/neuromodulacion/neuroadmin-legacy.git $local_dir");
} else {
    shell_exec("cd $local_dir && git pull origin main");
}

// Conectar al servidor FTP
$conn_id = ftp_connect($ftp_server);

if ($conn_id && ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    // Subir archivos al servidor
    function uploadDir($conn_id, $local, $remote) {
        $dir = opendir($local);
        while ($file = readdir($dir)) {
            if ($file != "." && $file != "..") {
                if (is_dir("$local/$file")) {
                    @ftp_mkdir($conn_id, "$remote/$file");
                    uploadDir($conn_id, "$local/$file", "$remote/$file");
                } else {
                    ftp_put($conn_id, "$remote/$file", "$local/$file", FTP_BINARY);
                }
            }
        }
        closedir($dir);
    }

    uploadDir($conn_id, $local_dir, $remote_dir);
    echo "Archivos actualizados correctamente.";
} else {
    echo "No se pudo conectar al servidor FTP.";
}

ftp_close($conn_id);
