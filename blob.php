<?php 
    include 'src/functions/dbfunctions.php';
    $conn = connectDB();
    $id = $_GET['id'];

    if ($id > 0){
        //vamos a crear nuestra consulta SQL
        $query = "SELECT * from formulario WHERE formularioId = '$id'"; 
        //con mysql_query la ejecutamos en nuestra base de datos indicada anteriormente
        //de lo contrario mostraremos el error que ocaciono la consulta y detendremos la ejecucion.
        $resultado= query($conn, $query);

        //si el resultado fue exitoso
        //obtendremos el dato que ha devuelto la base de datos
        $datos = mssql_fetch_assoc($resultado);
        header("Content-type: image/jpeg");

        //ruta va a obtener un valor parecido a "imagenes/nombre_imagen.jpg" por ejemplo
        $imagen = $datos['imagen_GXI'];
        //$new_im = imagecreatefromstring($imagen);

        //ahora colocamos la cabeceras correcta segun el tipo de imagen        

        //imagejpeg($new_im);

        echo $imagen;
    }
?>