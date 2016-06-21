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
?>

<div class="panel-principal">
    <div class="panelvegetales">
        <div class="panel-titulo">
            <h3 class="panel-title">Nuevo Agricultor</h3>
        </div>
        <div class="panel-cuerpo">
            <form action="agregaragricultor.php" method="POST" id="agricultor_validation">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombreagricultor">Nombre agricultor</label>
                            <input type="text" name="nombreagricultor" id="nombreagricultor" class="form-control"
                                   placeholder="Ingrese nombre" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="text" name="telefono" class="form-control"
                                   placeholder="Ingrese telefono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rut">R.U.T.</label>
                            <input type="text" name="rut" id="rut" class="form-control"
                                   placeholder="Ingrese R.U.T.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                   placeholder="Ingrese email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono2">Comuna</label>
                            <input type="text" name="comuna" id="comuna" class="form-control"
                                   placeholder="Ingrese comuna" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <?php
                                $sql = mssql_query("select * from [gam].[User]");

                                // Verifica que te llegaron datos de respuesta:
                                if (mssql_num_rows($sql) > 0)
                                {
                                  // Recoge los datos recibidos. 
                                  // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

                                  // Yo he elegido mostrarlos directamente en el select:
                                  echo"<select name='usuario' class='form-control'>\n";
                                  
                                  // Aquí recorres los datos recibidos:
                                  while ($temp = mssql_fetch_array($sql))
                                  {
                                    print" <option value='".$temp["UserName"]."'>".$temp["UserName"]."</option>\n";
                                  }

                                  echo"  </select>\n";
                                }
                                else
                                {  echo"No hay datos";  }

                                // Cierras la consulta
                                mssql_free_result($sql);  
                            ?>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-block">Listo!</button>
            </form>
        </div>     
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<?php include 'includes/footer.php'; } ?>