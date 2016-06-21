<?php 
include 'src/functions/dbfunctions.php';
$id = $_GET['id'];
if (isset($id)){
   // process form
   $conn = ConnectDB();
   $query = "delete from agricultor where agricultorId = '$id'";  
	$result = query($conn, $query);
	echo " 
<p>El registro ha sido eliminado con exito.</p><br><p><a href='listaragricultores.php'>Lista de agricultores</a></p>"; 

}else{
   echo "Debe especificar un 'id'.\n";
}

?>