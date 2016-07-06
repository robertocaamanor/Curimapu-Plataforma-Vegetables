<?php
include 'src/functions/dbfunctions.php';
    $conn = ConnectDB();
    $email = $_POST['email'];

    $sql = "SELECT * FROM Vendedorr WHERE Vendedor_email = '".$email."'";
    $res = mssql_query($sql, $conn);    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cambio de contraseña - Curimapu</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="http://i.imgur.com/akQX3eo.png">
</head>
<body>
<?php 
    while($row = mssql_fetch_array($res)) {
    if($row['Vendedor_email']!=$email) {
?>
    <p>No se encuentra este correo en la base de datos</p>
    <META HTTP-EQUIV='refresh' CONTENT='5; URL=validaremail.php'>
<?php
        } else {    
?>
<div class="header-form">
</div>

<form action="nuevopassword.php" class="form" id="form_password" method="POST">
    <div class="form-group">
      <label for="email">Ingrese nueva contraseña</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese su contraseña" required>
    </div>
    <div class="form-group">
      <label for="email">Confirmar nueva contraseña</label>
      <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Confirme su contraseña" required>
    </div>
    <input type="hidden" name="email" class="form-control" value="<?php echo $email; ?>">
    <div class="form-final">
      <button type="submit" class="btn btn-success btn-block">Listo!</button>
    </div>
</form>

<div class="footer-form">
    <p>Desarrollado por XHOST</p>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $.validator.setDefaults({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
        jQuery('#form_password').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                password_confirm: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }
            }
        });
        jQuery.extend(jQuery.validator.messages, {
          required: "Este campo es obligatorio.",
              remote: "Por favor, rellena este campo.",
              email: "Por favor, escribe una dirección de correo válida",
              url: "Por favor, escribe una URL válida.",
              date: "Por favor, escribe una fecha válida.",
              dateISO: "Por favor, escribe una fecha (ISO) válida.",
              number: "Por favor, escribe un número entero válido.",
              digits: "Por favor, escribe sólo dígitos.",
              creditcard: "Por favor, escribe un número de tarjeta válido.",
              equalTo: "Por favor, escribe el mismo valor de nuevo.",
              accept: "Por favor, escribe un valor con una extensión aceptada.",
              maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
              minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
              rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
              range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
              max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
              min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
        });
    });
</script>
<?php
        } 
    }
    mssql_free_result($res);
    mssql_close();
?>
</body>
</html>