<?php
	//session_start();
	if(!isset($_SESSION['idRol']))
	{
		header('location:../index.php');
	}
?>




<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="UTF-8">

	<?php include 'vista/includes/script.php'; ?> 
	
	<title>Sisteme Ventas</title>
	<header>
		<div class="header">
			
			<h1>Sistema de inventarios</h1>
			<div class="optionsBar">
				<p>El Salvador, <?php echo fecha(); ?></p>
				<span>|</span>
				
				<a href="index.php?acc=editar_usuario&id=<?php echo $_SESSION['idRol'] ?>">
					<span class="user">
						<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "" ; ?>
					</span>
				</a>
				
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="index.php?acc=cerrar_sesion"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div> 
		
		<?php include 'nav.php'; ?>

	</header>

	<body>