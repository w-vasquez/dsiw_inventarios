<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login | Sistema de inventario</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<section id="container">
		
		<form action="" method="post">
			
			<h3>Iniciar Sesión</h3>
			<img src="img/login.png" alt="login">
			<input type="text" name="usuario" placeholder="usuario" required='required'>
			<input type="password" name="clave" placeholder="contraseña" required='required'>
			<p class="alert"><?php echo(isset($alert) ? $alert : ''); ?></p>
			<input type="submit" value="INGRESAR">
		</form>

	</section>
</body>
</html>