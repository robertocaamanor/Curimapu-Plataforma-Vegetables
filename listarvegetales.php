<?php 
session_start(); 

  if((!isset($_SESSION['email'])) || ($_SESSION['perfil'] != 2)) 
  { 

    echo "No tienes permiso para entrar a esta pagina"; 
  } 
  else 
  {   
    include 'includes/header.php'; 
    include 'src/functions/dbfunctions.php';
                
    $conn = connectDB();
    $fechahoy = date( "Y-m-d" );
    $semana = date( "Y-m-d", strtotime("-7 days",strtotime($fechahoy)));
if(isset($_POST['inicio'],$_POST['final'], $_POST['busquedaagricultor'])){
    $inicio = $_POST['inicio'];
    $final = $_POST['final'];
    $agricultor = $_POST['busquedaagricultor'];
    $result = listarvegetalesagricultormixto($conn, $agricultor, $inicio, $final );
} elseif(isset($_POST['inicio'],$_POST['final'], $_POST['busquedavendedor'])){
    $inicio = $_POST['inicio'];
    $final = $_POST['final'];
    $vendedor = $_POST['busquedavendedor'];
    $result = listarvegetalesmixto($conn, $vendedor, $inicio, $final );
}
else{
    $result = listarVegetales($conn, $semana, $fechahoy);
}
?>
<div class="sitio-principal">
<h4>Informes Visita Cultivo</h4><hr/>
<div class="row">
  <div class="col-lg-6">
    <a href="listadovegetalesexcel.php" class="btn btn-success">Descargar Excel</a><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><hr/>
<ul class="nav nav-tabs">
    <li class="active"><a class="tablas" data-toggle="tab" href="#home">Fecha y agricultor</a></li>
    <li><a class="tablas" data-toggle="tab" href="#menu1">Fecha y vendedor</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <form class="formulario form-inline" action="listarvegetales.php" method="POST">
        <div class="form-group">
          <label for="exampleInputName2">Desde</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange1" name="inicio" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Hasta</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange2" name="final" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Agricultor</label>
          <div class="input-group">    
         <?php
            $sql = "select agricultorNom, UserID from agricultor order by agricultorNom";
            $res = mssql_query($sql);
            $arreglo_php = array();
            if(mssql_num_rows($res)==0)
               array_push($arreglo_php, "No hay datos");
            else{
              while($listaagricultores = mssql_fetch_array($res)){
                $agricultores = $listaagricultores["agricultorNom"];
                array_push($arreglo_php, $agricultores);
              }
            }
          ?>  
          <input type="text" id="buscaragricultor" name="busquedaagricultor" class="form-control" />
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
        </div>        
      </form>
    </div>
    <div id="menu1" class="tab-pane fade">
      <form class="formulario form-inline" action="listarvegetales.php" method="POST">
        <div class="form-group">
          <label for="exampleInputName2">Desde</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange3" name="inicio" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Hasta</label>
          <div class="input-group">    
          <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" class="form-control" id="daterange4" name="final" placeholder="Buscar fecha..."></div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail2">Vendedor</label>
          <div class="input-group">    
         <?php
            $sql = "select UserFirstName, UserLastName from [gam].[User] order by UserFirstName";
            $res = mssql_query($sql);
            $arreglo_php1 = array();
            if(mssql_num_rows($res)==0)
               array_push($arreglo_php1, "No hay datos");
            else{
              while($vendedores = mssql_fetch_array($res)){
                $nombre = $vendedores["UserFirstName"];
                $apellido = $vendedores["UserLastName"];
                $nombrecompleto = $nombre . " " . $apellido;
                array_push($arreglo_php1, $nombrecompleto);
              }
            }
          ?>  
          <input type="text" id="buscarvendedor" name="busquedavendedor" class="form-control" />
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
        </div>        
      </form>
    </div>
  </div>
<hr/>
   <?php 
      $hoy = date( "Y-m-d" );
      $ayer = date( "Y-m-d", strtotime("-1 day",strtotime($hoy)));
      $semana = date( "Y-m-d", strtotime("-7 days",strtotime($hoy)));
      $primero = 1;
       do {
      while($row=mssql_fetch_array($result))
      {
       $date = date_format(new DateTime($row['fecha']), 'Y-m-d');
       if($primero){
        $compare = $date;
        $primero = 0;?>
        <div class="panelvegetales">
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
            <a href="modvegetales.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Comuna: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['Especie']; ?></b></p>
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
         <div class="panelvegetales">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">
          <div class="list-group">
            <a href="modvegetales.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Comuna: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['Especie']; ?></b></p>
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
<script>
  $(function(){
    var autocompletar = new Array();
    <?php //Esto es un poco de php para obtener lo que necesitamos
     for($p = 0;$p < count($arreglo_php); $p++){ //usamos count para saber cuantos elementos hay ?>
       autocompletar.push('<?php echo $arreglo_php[$p]; ?>');
     <?php } ?>
     $("#buscaragricultor").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
       source: autocompletar //Le decimos que nuestra fuente es el arreglo
     });
     var autocompletar1 = new Array();
     <?php //Esto es un poco de php para obtener lo que necesitamos
     for($p = 0;$p < count($arreglo_php1); $p++){ //usamos count para saber cuantos elementos hay ?>
       autocompletar1.push('<?php echo $arreglo_php1[$p]; ?>');
     <?php } ?>
     $("#buscarvendedor").autocomplete({ //Usamos el ID de la caja de texto donde lo queremos
       source: autocompletar1 //Le decimos que nuestra fuente es el arreglo
     });
  });
</script>
<?php include 'includes/footer.php'; } ?>