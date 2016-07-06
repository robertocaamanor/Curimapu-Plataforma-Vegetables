<?php 

	include 'src/functions/dbfunctions.php';
	$conn = ConnectDB();
	$password = md5($_POST['password']);
	$email = $_POST['email'];
	$sql = "UPDATE Vendedorr SET Vendedor_pass='".$password."' WHERE Vendedor_email='".$email."' ";
	$actualizar = mssql_query($sql, $conn);
	if ($actualizar) {
        echo "Actualizado correctamente";         
    } else {
        echo "No Agregado";
    }
    echo "<br><br>Sera redirigido en algunos segundos...";
    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=index.php'>"; 
 ?>