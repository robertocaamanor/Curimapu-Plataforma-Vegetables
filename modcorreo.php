<?php 
	
session_start(); 

  if(!isset($_SESSION['email'])) 
  { 
    echo "No tienes permiso para entrar a esta pagina"; 
  } 
  else 
  {   
	include 'includes/header.php';
	include 'src/functions/dbfunctions.php';

	$conn = ConnectDB();
	$fechahoy = date( "Y-m-d" );
 	$semana = date( "Y-m-d", strtotime("-7 days",strtotime($fechahoy)));
  $id = $_GET['id'];
 ?>

<div class="sitio-principal">
  <div class="panelsemilllas">
    <div class="panel-titulo">
      <h3 class="panel-title">Enviar E-mail</h3>
    </div>
    <div class="panel-cuerpo">
      <form id="venta" action="mensajecorreo.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="emailagricultor">E-mail del agricultor</label>
        <?php
          $consulta_mysql='select * from Agricultor ORDER BY agricultorNom ASC';
          $resultado_consulta_mysql=query($conn, $consulta_mysql);
            
          echo "<select name='emailagricultor' class='form-control'>";
          while($fila=mssql_fetch_array($resultado_consulta_mysql)){
              echo "<option value='".$fila['agricultorEmail']."'>".$fila['agricultorNom']." - ".$fila['agricultorEmail']."</option>";
          }
          echo "</select>";
        ?>
        <input type="hidden" class="form-control" name="id" value="<?php echo $id ?>">
      </div>
      <div class="form-group">
        <label for="informepdf">Informe Venta PDF</label>
        <input type="file" name="informepdf" id="informepdf"/>
      </div>
      <button type="submit" class="btn btn-success">Enviar informe</button>
      </form>
    </div>
  </div>
</div>

 <?php 

 	include 'includes/footer.php';

 	}
  ?>