<?php 
	include 'src/functions/dbfunctions.php';
	include 'includes/header.php';
	$con = connectDB();
	if(!empty($_POST)){
 
		$nombre=$_POST['nombrevendedor'];
		$telefono=$_POST['telefono'];
		$rut=$_POST['rut'];
		$email=$_POST['email'];
		$password=md5($_POST['password']);
		$perfil=$_POST['perfil'];
		$sql= "INSERT into Vendedorr(Vendedor_nombre, Vendedor_fono, Vendedor_rut, Vendedor_email, Vendedor_pass, PerfilId)values('$nombre', '$telefono', '$rut', '$email', '$password', '$perfil')";
		 
		//Te faltaba esta linea
		 
		$recurso=mssql_query($sql, $con);
		 
		//Para mas seguridad usa el valor retornado por sqlsrv_execute
		 
		if($recurso){
		      echo"Agregado correctamente";
		}else{
		      echo"No Agregado";
		}
	}

	include 'includes/footer.php';

 ?>