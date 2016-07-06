<?php
include 'src/functions/dbfunctions.php';
    $conn = ConnectDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Validar E-mail - Curimapu</title>
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

<form action="iniciopassword.php" class="form" method="POST">
    <div class="form-group">
      <label for="email">Indique su e-mail</label>
      <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Ingrese su correo" required>
    </div>
    <div class="form-final">
      <button type="submit" class="btn btn-success btn-block">Siguiente</button>
    </div>
</form>

<div class="footer-form">
    <p>Desarrollado por XHOST</p>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>