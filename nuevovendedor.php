<?php
session_start(); 

    if((!isset($_SESSION['email'])) || ($_SESSION['perfil'] != 2)) 
    { 
        echo "No tienes permiso para entrar a esta pagina";
    } 
    else 
    {   
        include 'src/functions/dbfunctions.php';
    $conn = connectDB();
include 'includes/header.php';
?>

<div class="panel-principal">
    <div class="panelvegetales">
        <div class="panel-titulo">
            <h3 class="panel-title">Nuevo Usuario Web</h3>
        </div>
        <div class="panel-cuerpo">
            <form action="agregarvendedor.php" method="POST" id="vendedor_validation">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombrevendedor">Nombre vendedor</label>
                            <input type="text" name="nombrevendedor" id="nombrevendedor" class="form-control"
                                   placeholder="Ingrese nombre" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control"
                                   placeholder="Ingrese telefono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rut">R.U.T.</label>
                            <input type="text" name="rut" id="rut" class="form-control"
                                   placeholder="Ingrese R.U.T." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="Ingrese email" required email>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Ingrese contraseña" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="repetirpassword">Repetir contraseña</label>
                            <input type="password" id="password_confirm" name="password_confirm" class="form-control"
                                   placeholder="Repita contraseña" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="perfil">Perfil</label>
                            <?php
                                $sql = mssql_query("select * from perfiles order by PerfilNombre");

                                // Verifica que te llegaron datos de respuesta:
                                if (mssql_num_rows($sql) > 0)
                                {
                                  // Recoge los datos recibidos. 
                                  // Puedes mostrarlos o guardarlos en un arreglo para posterior uso...

                                  // Yo he elegido mostrarlos directamente en el select:
                                  echo"<select name='perfil' class='form-control'>\n";
                                  
                                  // Aquí recorres los datos recibidos:
                                  while ($temp = mssql_fetch_array($sql))
                                  {
                                    print" <option value='".$temp["PerfilId"]."'>".$temp["PerfilNombre"]."</option>\n";
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