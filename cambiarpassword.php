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
	$conn = ConnectDB();
	$email = $_SESSION['email'];
 ?>

<div class="panel-principal">
	<div class="panelvegetales">
		<div class="panel-titulo">
			<h3 class="panel-title">Cambiar contraseña</h3>
		</div>
	</div>
	<div class="panel-cuerpo">
		<form action="changepassword.php" method="POST" id="pass_validation">
			<div class="form-group">
				<label for="password">Nueva contraseña</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="Ingrese contraseña" required>
			</div>
			<div class="form-group">
				<label for="password_confirm">Confirmar contraseña</label>
				<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirme contraseña" required>
			</div>
			<input type="hidden" class="form-control" name="email" value="<?php echo $email; ?>">
			<button class="btn btn-success btn-block">Listo!</button>
		</form>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<?php include 'includes/footer.php'; } ?>