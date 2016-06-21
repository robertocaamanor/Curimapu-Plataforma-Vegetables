<?php
session_start();

if (!isset($_SESSION['email'])) {

    echo "No tienes permiso para entrar a esta pagina";
} else {
include 'includes/header.php';
include 'src/clases/Marker.php';
$conn = connectDB();
$fechahoy = date( "Y-m-d" );
  $semana = date( "Y-m-d", strtotime("-7 days",strtotime($fechahoy)));
if(isset($_POST['inicio'],$_POST['final'])){
  $inicio = $_POST['inicio'];
  $final = $_POST['final'];
  $result = listarvegetalesfecha($conn, $inicio, $final);
} elseif(isset($_POST['busquedaagricultor'])){
  $buscaragricultor = $_POST['busquedaagricultor'];
  $result = listarvegetalesagricultor($conn, $buscaragricultor);
} elseif(isset($_POST['busquedanombre'])){
  $buscarnombre = $_POST['busquedanombre'];
  $result = listarvegetalesnombre($conn, $buscarnombre);
}else{
  $result = listarVegetales($conn, $semana, $fechahoy);
}
?>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 100%;
        padding-top: 10px;
        width: 80%;
        margin: 0 auto;
    }
</style>

<div id="map"></div>
<br>
<div class="sitio-principal">
 <ul class="nav nav-tabs">
    <li class="active"><a class="tablas" data-toggle="tab" href="#home">Fecha y agricultor</a></li>
    <li><a class="tablas" data-toggle="tab" href="#menu1">Fecha y vendedor</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <form class="formulario form-inline" action="mapabusquedanombre.php" method="POST">
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
                $sql = mssql_query("select * from agricultor order by agricultorNom");

                // Verifica que te llegaron datos de respuesta:
                if (mssql_num_rows($sql) > 0)
                {
                  // Recoge los datos recibidos. 
                  // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

                  // Yo he elegido mostrarlos directamente en el select:
                  echo"<select name='buscaragricultor' class='form-control'>\n";
                  
                  // Aquí recorres los datos recibidos:
                  while ($temp = mssql_fetch_array($sql))
                  {
                    print" <option value='".$temp["agricultorNom"]."'>".$temp["agricultorNom"]."</option>\n";
                  }

                  echo"  </select>\n";
                }
                else
                {  echo"No hay datos";  }

                // Cierras la consulta
                mssql_free_result($sql);  
            ?>
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
        </div>        
      </form>
    </div>
    <div id="menu1" class="tab-pane fade">
      <form class="formulario form-inline" action="mapabusqueda.php" method="POST">
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
                $sql = mssql_query("select * from [gam].[User]");

                // Verifica que te llegaron datos de respuesta:
                if (mssql_num_rows($sql) > 0)
                {
                  // Recoge los datos recibidos. 
                  // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

                  // Yo he elegido mostrarlos directamente en el select:
                  echo"<select name='busquedavendedor' class='form-control'>\n";
                  
                  // Aquí recorres los datos recibidos:
                  while ($temp = mssql_fetch_array($sql))
                  {
                    print" <option value='".$temp["UserNameSpace"]."'>".$temp["UserFirstName"]." ".$temp["UserLastName"]."</option>\n";
                  }

                  echo"  </select>\n";
                }
                else
                {  echo"No hay datos";  }

                // Cierras la consulta
                mssql_free_result($sql);  
            ?>
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
            <a href="mapasearch.php?id=<?php echo $row['id']; ?>" class="list-group-item">
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
            <a href="mapasearch.php?id=<?php echo $row['id']; ?>" class="list-group-item">
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
<script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: {lat: -36.8308521, lng: -73.0582368}
        });
        <?php $markers1 = Marker::listMarkers(); ?>
        <?php while (list(, $valor) = each($markers1)) {
        echo " var marker = new google.maps.Marker({";
        echo "map: map});";
    }
        ?>
    }
    $(document).ready(function () {
        $.extend($.fn.dataTable.defaults, {
            searching: true,
            ordering: false
        });
        $('#markers_table').DataTable({
            ordering: true,
            paging: true,
            "processing": true
        });
    });
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMa4pd7uMEU0NRi7dHS7YVBcFQvKG5Ow&signed_in=true&callback=initMap"></script>


<?php include 'includes/footer.php'; } ?>