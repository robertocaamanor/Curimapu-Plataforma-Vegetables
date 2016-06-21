<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {

    $sql = "update agricultor set 
           agricultorNom='".$_POST['nombreagricultor']."',
            agricultorFono='".$_POST['telefono']."',
           agricultorEmail='".$_POST['email']."',
            agricultorRut='".$_POST['rut']."',
            agricultorUbicacion='".$_POST['comuna']."',
            UserID='".$_POST['perfil']."'
            where agricultorId='".$_POST['agricultorid']."'";


    $recurso = mssql_query($sql, $con);

    if ($recurso) {
        echo "Agregado correctamente";
    } else {
        echo "No Agregado";
    }
    echo "<br><br>Sera redirigido en algunos segundos...";
    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=modagricultores.php?id=".$_POST['agricultorid']."'>"; 
}else
    echo "vacio";

//include 'includes/footer.php';

?>