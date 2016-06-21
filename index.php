<?php
include 'src/functions/dbfunctions.php';
    $conn = connectDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Curimapu</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="http://i.imgur.com/XyMZ0m9.png">
</head>
<body>

<div class="header-form">
</div>

<form action="log_action.php" class="form" method="POST">
    <div class="avatar-form">
        <img src="http://i.imgur.com/dPc6Jlj.png" alt="...">
    </div>
    <div class="form-group">
        <input type="email" name="email" class="form-control" id="user" placeholder="Ingrese su usuario" required>
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese su contraseña"
               required>
    </div>
    <div class="form-group">
        <?php
            $sql = mssql_query("select * from perfiles order by PerfilNombre");

            // Verifica que te llegaron datos de respuesta:
            if (mssql_num_rows($sql) > 0)
            {
              // Recoge los datos recibidos. 
              // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

              // Yo he elegido mostrarlos directamente en el select:
              echo"<select name='perfil' class='form-control'>\n";
              
              // Aquí recorres los datos recibidos:
              while ($temp = mssql_fetch_array($sql))
              {
                print" <option value='".$temp["PerfilId"]."'>".$temp["PerfilNombre"]."</option>\n";
              }

              echo"  </select>\n";
            }
            else
            {  echo"No hay datos";  }

            // Cierras la consulta
            mssql_free_result($sql);  
        ?>
    </div>
    <div class="form-final">
        <button type="submit" class="btn btn-success btn-block">Iniciar sesion</button>
    </div>
</form>

<div class="footer-form">
    <p>Desarrollado por XHOST</p>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>