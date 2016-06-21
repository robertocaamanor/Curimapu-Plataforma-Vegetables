<?php
session_start();

if (!isset($_SESSION['email'])) {

    echo "No tienes permiso para entrar a esta pagina";
} else {
include 'includes/header.php';
include 'src/clases/Marker.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
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
<div class="row">
<?php $markers = Marker::searchMarkers(); ?>
<?php while (list(, $valor) = each($markers)) { ?>
    <div class="col-md-3">
        <div class="form-group">
            <h5>Fecha</h5>
            <p><?php echo date_format(new DateTime($valor->getFecha()), 'Y-m-d'); ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <h5>Agricultor</h5>
            <p><?php echo $valor->getAgricultor(); ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <h5>Especie</h5>
            <p><?php echo $valor->getEspecie(); ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <h5>Vendedor</h5>
            <p><?php echo $valor->getVendedornombre()." ".$valor->getVendedorapellido(); ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <h5>Comuna</h5>
            <p><?php echo $valor->getComuna(); ?></p>
        </div>
    </div>
    
    
    
</div>
</div>
<?php } ?>
<script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            <?php $markers1 = Marker::searchMarkers(); ?>
            <?php while (list(, $valor) = each($markers1)) {
                echo "zoom: 14,";
                echo "center: {lat: " . $valor->getLat() . ", lng: " . $valor->getLng() . "}";
                echo "});";        
                echo " var marker = new google.maps.Marker({";
                echo "position: {lat:" . $valor->getLat() . ",lng:" . $valor->getLng() . "},";
                echo " title: '" . $valor->getAgricultor() . " / ". $valor->getLat() .",". $valor->getLng() ."',";
                echo "map: map});";
                echo "var infowindow = new google.maps.InfoWindow({";
                echo "content:'". $valor->getComuna() ."' });";
                echo "google.maps.event.addListener(marker, 'click', function() { ";
                echo "infowindow.open(map,marker); ";
                echo "});"; 
            }
        ?>
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMa4pd7uMEU0NRi7dHS7YVBcFQvKG5Ow&signed_in=true&callback=initMap"></script>
<?php include 'includes/footer.php'; } ?>