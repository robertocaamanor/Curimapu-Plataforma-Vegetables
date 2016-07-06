<?php 
	include 'src/functions/dbfunctions.php';
	include 'includes/header.php';
	$con = connectDB();
	if(!empty($_POST)){
 
		$nombre=$_POST['nombreagricultor'];
		$telefono=$_POST['telefono'];
		$rut=$_POST['rut'];
		$email=$_POST['email'];
		$comuna=$_POST['comuna'];
		$usuario=$_POST['usuario'];
		$sql= "INSERT into agricultor(agricultorNom, agricultorFono, agricultorRut, agricultorEmail, agricultorUbicacion, UserId)values('$nombre', '$telefono', '$rut', '$email', '$comuna', '$usuario')";
		 
		//Te faltaba esta linea
		 
		$recurso=mssql_query($sql, $con);
		 
		//Para mas seguridad usa el valor retornado por sqlsrv_execute
		 
		if($recurso){
		      echo"Agregado correctamente";
		}else{
		      echo"No Agregado";
		}
		echo "<br><br>Sera redirigido en algunos segundos...";
    	echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=nuevoagricultors.php'>";
	}

	include 'includes/footer.php';

 ?>