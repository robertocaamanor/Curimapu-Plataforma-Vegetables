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
                
   $conn = connectDB();
  if(isset($_POST['buscaragricultor'])){
      $agricultor = $_POST['buscaragricultor'];
      $result = buscarAgricultor($conn, $agricultor);
    }else{
      $result = listarAgricultores($conn);
    }
?>
<div class="sitio-principal">
<div class="row">
  <div class="col-lg-6">
    <form method="POST" class="formulario" action="listaragricultores.php">
      <div class="input-group">
        <input type="text" class="form-control" name="buscaragricultor" placeholder="Buscar agricultor...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Buscar</button>
        </span>
      </div><!-- /input-group -->
    </form>
  </div><!-- /.col-lg-6 -->    
</div><!-- /.row -->
        <div class="panelvegetables">
          <div class="panel-titulo">
            <h3 class="panel-title">Agricultores</h3>
          </div>
          <div class="panel-cuerpo">
             <?php 
       do {
      while($row=mssql_fetch_array($result))
      {?>
          <div class="list-group">
            <a href="modagricultores.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading"><?php echo $row['Nombre']; ?></h4>
                  </div>
              </div>
            </a>
          </div>
          <?php
          }
      } while(mssql_next_result($result));
      cerrar($conn) ?>
        </div>  
      
  </div>
</div>
<?php include 'includes/footer.php'; } ?>