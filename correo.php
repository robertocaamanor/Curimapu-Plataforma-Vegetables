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
  include 'mensajecorreo.php';

  $self = "correo.php"; //Obtenemos la página en la que nos encontramos

  header("refresh:15; url=$self"); //Refrescamos cada 300 segundos

	$conn = ConnectDB();
	$fechahoy = date( "Y-m-d" );
 	$semana = date( "Y-m-d", strtotime("-7 days",strtotime($fechahoy)));
	$result = listarCorreosVisitas($conn, $semana, $fechahoy);

 ?>

<div class="sitio-principal">
	 <?php 
      $hoy = date( "Y-m-d" );
      $ayer = date( "Y-m-d", strtotime("-1 day",strtotime($hoy)));
      $primero = 1;
       do {
      while($row=mssql_fetch_array($result))
      {
       $date = date_format(new DateTime($row['fecha']), 'Y-m-d');
       if($primero){
        $compare = $date;
        $primero = 0;?>
        <div class="panelsemilllas">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php
            if($date == $hoy)
              echo "Hoy";
            else echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">

       <?php }
       if($compare==$date){?>
          <div class="list-group">
            <a href="modcorreo.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?> <?php if(($row['bandera']=='0') || ($row['bandera']==NULL)) { ?>
                      		<span class="label label-info">No enviado</span>
                      	<?php correo($row['id'], $row['Especie'], $date); } elseif($row['bandera']=='1') { ?>
                      		<span class="label label-success">Enviado</span>
                      	<?php } elseif($row['bandera']=='2') { ?>
                      		<span class="label label-danger">En espera</span>
                      	<?php correo($row['id'], $row['Especie'], $date); } ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['Especie']; ?></b></p>
                      <p class="list-group-item-text"><b>Comuna: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                  </div>
              </div>
            </a>
          </div>
      <?php }
      else{
        $compare = $date?>
        </div>
        </div>
         <div class="panelsemilllas">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">
          <div class="list-group">
            <a href="modcorreo.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?> <?php if(($row['bandera']=='0') || ($row['bandera']==NULL)) { ?>
                      		<span class="label label-info">No enviado</span>
                      	<?php correo($row['id'], $row['Especie'], $date); } elseif($row['bandera']=='1') { ?>
                      		<span class="label label-success">Enviado</span>
                      	<?php } elseif($row['bandera']=='2') { ?>
                      		<span class="label label-danger">En espera</span>
                      	<?php correo($row['id'], $row['Especie'], $date); } ?>
                      		</h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['Especie']; ?></b></p>
                      <p class="list-group-item-text"><b>Comuna: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                  </div>
              </div>
            </a>
          </div>
      <?php } 
      }
      } while(mssql_next_result($result));
      cerrar($conn) ?>
</div>

 <?php 

 	include 'includes/footer.php';

 	}
  ?>