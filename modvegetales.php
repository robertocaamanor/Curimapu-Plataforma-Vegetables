<?php
session_start();

if (!isset($_SESSION['email'])) {

    echo "No tienes permiso para entrar a esta pagina";
} else {
    include 'includes/header.php';
    include 'src/functions/dbfunctions.php';
    ini_set("display_errors", 1);
    $id = $_GET['id'];
//$id = '1';
    $conn = connectDB();
    $result = detalleVegetales($id, $conn);
    $row = mssql_fetch_array($result);
    $errors = array();

    ?>
    <div class="sitio-principal">
    <div class="panelvegetales">
        <div class="panel-titulo">
            <h3 class="panel-title">Informe Visita Cultivo</h3>
        </div>
        <div class="panel-cuerpo">
            <form action="updateVegetales.php" method="POST">
                <div id="agricultor">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="agricultor">Razón Social / Agricultor: </label>
                            <input type="text" name="agricultor" class="form-control" value="<?= $row['Agricultor'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">                        
                            <label for="fecha">Fecha: </label>
                            <input type="text" name="fecha" class="form-control"
                                   value="<?php $date = new DateTime($row['Fecha']);
                                   echo date_format($date, "Y-m-d"); ?>"
                                   placeholder="Ingrese fecha">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="especies">Especies: </label>
                            <input type="text" name="especies" class="form-control" value="<?= $row['especie'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ubicacion">Comuna: </label>
                            <input type="text" name="ubicacion" class="form-control" value="<?= $row['Ubicacion'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="variedad">Variedad: </label>
                            <input type="text" name="variedad" class="form-control" value="<?= $row['nombreVariedad'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">E-mail: </label>
                            <input type="text" name="email" class="form-control" value="<?= $row['email'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telefono">Telefono: </label>
                            <input type="text" name="telefono" class="form-control" value="<?= $row['telefono'] ?>"
                                   placeholder="Ingrese el nombre del agricultor">
                        </div>
                    </div>
                </div>
                </div><!--div agricultor -->
                <div id="formularioVenta">
                <div class="row">
                <input type="hidden" name="visitaid" class="form-control" value="<?php echo $id; ?>">                    
                    
                    <div class="col-md-3">
                        <div class="form-group">
                        <input type="hidden" name="formularioId" value="<?= $id; ?>">
                            <label for="estadofenologico">1. Estado Fenológico: </label>
                            <select name="estadofenologico" class="form-control">

                            <?php
                                $conn = connectDB();
                                $sql = "select estaFenologico from formulario where formularioId='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['estaFenologico'] == $arreglo['estaFenologico']) $sel = "selected";
                                    ?>
                                    <option
                                        value="<?php echo $arreglo['estaFenologico'] ?>"<?= $sel ?>><?php echo $arreglo['estaFenologico']; ?></option>
                                <?php } ?>
                              <option value="Siembra">Siembra</option>
                              <option value="Transplante">Transplante</option>
                              <option value="Vegetativo">Vegetativo</option>
                              <option value="Pre-Floraci&oacute;n">Pre-floraci&oacute;n</option>
                              <option value="Floraci&oacute;n">Floraci&oacute;n</option>
                              <option value="Llenado">Llenado</option>
                              <option value="Pre-cosecha">Pre-cosecha</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estadocrecimiento">2.Estado de Crecimiento: </label>
                            <select name="estadocrecimiento" class='form-control'>

                                <?php

                                for ($i = 1; $i <= 10; $i++) {
                                    $sel = "";
                                    if ($i == $row['estadocrecimiento']) $sel = " selected";
                                    echo '<option value=' . $i . ' ' . $sel . '>' . $i . '</option>';

                                }

                                ?>
                            </select>
                        </div>
                        </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="malezas">3. Estado de Malezas: </label>
                            <select name="malezas" class="form-control">
                            <?php
                                $conn = connectDB();
                                $sql = "select estaMalezas from formulario where formularioId='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['estaMalezas'] == $arreglo['estaMalezas']) $sel = "selected";
                                    ?>
                                    <option
                                        value="<?php echo $arreglo['estaMalezas']; ?>"<?= $sel ?>><?php echo $arreglo['estaMalezas']; ?></option>
                                <?php } ?>
                              <option value="Nula">Nula</option>
                              <option value="Regular">Regular</option>
                              <option value="Alta">Alta</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fitosanitario">4. Estado de Fitosantiario: </label>
                            <select name="fitosanitario" class='form-control'>

                                <?php

                                for ($i = 1; $i <= 10; $i++) {
                                    $sel = "";
                                    if ($i == $row['fitosanitario']) $sel = " selected";
                                    echo '<option value=' . $i . ' ' . $sel . '>' . $i . '</option>';

                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="poblacion">5.Poblacion (Plantas por Metro): </label>
                            <input type="text" name="poblacion" class="form-control"
                                   value="<?= $row['poblacion'] ?>"
                                   placeholder="Ingrese enfermedades bacteriales">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cosecha">6.Cosecha: </label>
                            <select name="cosecha" class="form-control">
                            <?php
                                $conn = connectDB();
                                $sql = "select cosecha from formulario where formularioId='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['cosecha'] == $arreglo['cosecha']) $sel = "selected";
                                    ?>
                                    <option
                                        value="<?php echo $arreglo['cosecha']; ?>"<?= $sel ?>><?php echo $arreglo['cosecha']; ?></option>
                                <?php } ?>
                              <option value="Aprobada">Aprobada</option>
                              <option value="Rechazada">Rechazada</option>
                              <option value="No aplica">No aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="malezasprincipales">7. Malezas Principales: </label>
                            <input type="text" name="malezasprincipales" class="form-control"
                                   value="<?= $row['malezasprincipales'] ?>"
                                   placeholder="Ingrese malezas principales">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="hongosbacterias">8. Hongos/Bacterias/Virus: </label>
                            <div class="checkbox">
                            <?php
                                $conn = connectDB();
                                $sql = "select honBacVir from formulario where formularioId='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($row['honBacVir'] == $arreglo['honBacVir']) $sel = "checked";
                                    ?>
                                   <label>
                                        <b><?php echo $arreglo['honBacVir']; }
                                 ?></b><br/>
                              </label>
                              <label>
                                        <input type="checkbox" name="hongosbacterias[]" value="Esclerotinia" <?= $sel ?>>
                                        Esclerotinia
                                      </label>
                                      <label>
                                        <input type="checkbox" name="hongosbacterias[]" value="Fusarium" <?= $sel ?>>
                                        Fusarium
                                      </label>
                                      <label>
                                        <input type="checkbox" name="hongosbacterias[]" value="Mildiu" <?= $sel ?>>
                                        Mildiu
                                      </label>
                                      <label>
                                        <input type="checkbox" name="hongosbacterias[]" value="Botritis" <?= $sel ?>>
                                        Botritis
                                      </label>
                                      <label>
                                        <input type="checkbox" name="hongosbacterias[]" value="otros" <?= $sel ?>>
                                        Otros
                                      </label>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="insectos">9. Insectos/Plagas: </label>
                            <div class="checkbox">
                             <?php
                                $conn = connectDB();
                                $sql = "select insectos from formulario where formularioId='".$id."'";
                                $result = query($conn, $sql);
                                while ($arreglo = mssql_fetch_array($result)) {
                                    $sel = "";
                                    if ($_row['insectos'] == $arreglo['insectos']) $sel = "checked";
                                    ?>
                                   <label>
                                        <b><?php echo $arreglo['insectos'];  }
                                 ?></b><br/>
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="Pulgones">
                                Pulgones
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="Gusanos">
                                Gusanos
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="Polilla">
                                Polilla
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="Acaros">
                                Acaros
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="Pajaros">
                                Pajaros
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="Liebres">
                                Liebres
                              </label>
                              <label>
                                <input type="checkbox" name="insectos[]" value="otros">
                                Otros
                              </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estadogeneral">10. Estado General del Cultivo: </label>
                            <select name="estadogeneral" class='form-control'>

                                <?php

                                for ($i = 1; $i <= 10; $i++) {
                                    $sel = "";
                                    if ($i == $row['estadogeneral']) $sel = " selected";
                                    echo '<option value=' . $i . ' ' . $sel . '>' . $i . '</option>';

                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">11. Observaciones generales del vegetal:</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" cols="30" rows="10"
                            ><?= $row['observaciones'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recomendaciones">12. Recomendaciones:</label>
                            <textarea name="recomendaciones" id="recomendaciones" class="form-control" cols="30"
                                      rows="10"><?= $row['recomendaciones'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php
                            $imagen = $row['imagen'];
                            $imagenes = explode(':', $imagen);
                        ?>
                            </div>
                        </div>
                    </div>
                </div><!--div formularioVenta -->
                 <a class="btn btn-info" href="http://xcom.ddns.net/vegetales/PublicTempStorage/multimedia/<?php echo trim($imagenes[1]); ?>">Ver imagen</a>
                <?php if($_SESSION['perfil'] == 2) { ?>
                <button id="modificar" class="btn btn-success">Modificar</button>
                <?php } ?>
                <a href="informevegetalespdf.php?id=<?php echo $id; ?>" class="btn btn-danger">Exportar PDF</a>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#agricultor").find("*").attr('disabled', 'disabled');
            $("#formularioVenta").find("*").attr('disabled', 'disabled');

            $('#modificar').click(function () {
                if ($('#modificar').html() == 'Modificar') {
                    $("#formularioVenta").find("*").removeAttr('disabled');
                    $('#modificar').html("Guardar");
                    return false;
                }
            });
        });
    </script>
    <?php
    cerrar($conn);

    include 'includes/footer.php';
}
?>