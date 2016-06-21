<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {
    if (is_array($_POST['hongosbacterias'])) {
        $hongos = '';
        $num_hongos = count($_POST['hongosbacterias']);
        $current = 0;
        foreach ($_POST['hongosbacterias'] as $key => $value) {
            if ($current != $num_hongos-1)
                $hongos .= $value.', ';
            else
                $hongos .= $value;
            $current++;
        }
    }

    if (is_array($_POST['insectos'])) {
        $insectos = '';
        $num_insectos = count($_POST['insectos']);
        $current = 0;
        foreach ($_POST['insectos'] as $key => $value) {
            if ($current != $num_insectos-1)
                $insectos .= $value.', ';
            else
                $insectos .= $value;
            $current++;
        }
    }

    $sql = "UPDATE formulario SET estaFenologico='". $_POST['estadofenologico'] ."', estaCrecimiento='". $_POST['estadocrecimiento'] ."', estaMalezas='". $_POST['malezas'] ."',  estaFitosanitario='". $_POST['fitosanitario'] ."', poblacion='". $_POST['poblacion'] ."', cosecha='". $_POST['cosecha'] ."', malePrincipales='". $_POST['malezasprincipales'] ."', honBacVir='". $hongos ."', insectos='". $insectos ."', estadoGene='". $_POST['estadogeneral'] ."', Observaciones='". $_POST['observaciones'] ."', Recomendacioness='". $_POST['recomendaciones'] ."', fechaModificacion=GETDATE()  WHERE formularioId='". $_POST['formularioId'] ."'";
    $recurso = mssql_query($sql, $con);
    if (!$recurso) {
        echo "No Agregado";
    } else {
        echo "Agregado correctamente";
    }
    echo "<br><br>Sera redirigido en algunos segundos...";
    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=modvegetales.php?id=".$_POST['formularioId']."'>"; 
}else
    echo "vacio";

//include 'includes/footer.php';

?>