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
            $sql = "select agricultorNom from agricultor order by agricultorNom";
            $res = mssql_query($sql);
            $arreglo_php = array();
            if(mssql_num_rows($res)==0)
               array_push($arreglo_php, "No hay datos");
            else{
              while($listaagricultores = mssql_fetch_array($res)){
                array_push($arreglo_php, $listaagricultores["agricultorNom"]);
              }
            }
          ?>  
          <input type="text" id="buscaragricultor" name="buscaragricultor" class="form-control" />
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