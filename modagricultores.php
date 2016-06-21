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
    $id = $_GET['id'];
    $result = detalleAgricultores($id, $conn);
     $row = mssql_fetch_array($result);
    $errors = array();
?>

<div class="panel-principal">
    <div class="panelvegetables">
        <div class="panel-titulo">
            <h3 class="panel-title">Actualizar agricultor</h3>
        </div>
        <div class="panel-cuerpo">
            <form action="updateAgricultor.php" method="POST" id="agricultor_validation">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <input type="hidden" name="agricultorid" class="form-control" value="<?php echo $id; ?>">
                            <label for="nombreagricultor">Nombre agricultor</label>
                            <input type="text" name="nombreagricultor" id="nombreagricultor" class="form-control"
                                   placeholder="Ingrese nombre" value="<?= $row['nombre'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="text" name="telefono" class="form-control"
                                   placeholder="Ingrese telefono" value="<?= $row['telefono'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombrevendedor">Comuna</label>
                            <input type="text" name="comuna" id="comuna" class="form-control"
                                   placeholder="Ingrese comuna" value="<?= $row['ubicacion'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rut">R.U.T.</label>
                            <input type="text" name="rut" id="rut" class="form-control"
                                   placeholder="Ingrese R.U.T." value="<?= $row['rut'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"
                                   placeholder="Ingrese email" value="<?= $row['email'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="perfil">Usuario</label>
                            <select name="perfil" class="form-control" size=0>
                                    <?php
                                    $conn = connectDB();
                                    $sql = "select * from [gam].[User]";
                                    $result = query($conn, $sql);
                                    while ($arreglo = mssql_fetch_array($result)) {
                                        $sel = "";
                                        if ($row['Vendedor'] == $arreglo['UserName']) $sel = "selected";
                                        ?>
                                        <option
                                            value="<?php echo $arreglo['UserName'] ?>"<?= $sel ?>><?php echo $arreglo['UserFirstName']." ".$arreglo['UserLastName']; ?></option>
                                    <?php } ?>
                                </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-block">Listo!</button>
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#myModal">Eliminar agricultor</button>
                 <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                      </div>
                      <div class="modal-body">
                        <h1>¿Está seguro que quiere eliminar este agricultor?</h1>
                        <br>
                        <a class="btn btn-danger" href="eliminaragricultor.php?id=<?php echo $id; ?>">Eliminar agricultor</a>
                      </div>
                      <div class="modal-footer">                        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>

                  </div>
                </div>
            </form>
        </div>     
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<?php include 'includes/footer.php'; } ?>