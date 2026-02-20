<?php
/*Incluye parámetros de conexión a la base de datos: 
DB_HOST: Nombre o dirección del gestor de BD MariaDB
DB_NAME: Nombre de la BD
DB_USER: Usuario de la BD
DB_PASSWORD: Contraseña del usuario de la BD
*/
include_once("config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">    
	<title>CRUD PHP</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
	:root{--accent:#00a3ff;--accent2:#7b61ff}
	html,body{height:100%;margin:0;font-family:Inter,system-ui,'Segoe UI',Roboto,Arial;background:linear-gradient(180deg, rgba(3,6,18,0.6), rgba(3,6,18,0.8)), url('/imagenes/ps5-0_ahca.jpg') center/cover fixed no-repeat;color:#eaf6ff}
	.container.app{max-width:1100px;margin:32px auto;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));box-shadow:0 10px 30px rgba(2,6,23,0.7);border-radius:16px;padding:24px;border:1px solid rgba(255,255,255,0.03);backdrop-filter: blur(6px)}
	header h1{color:#fff;font-weight:700;text-transform:uppercase;letter-spacing:1px;text-shadow:0 4px 18px rgba(123,97,255,0.6);display:inline-block;padding:8px 16px;background:linear-gradient(90deg,var(--accent),var(--accent2));border-radius:8px}
	
	.form-control{background:rgba(30,50,90,0.6);border:1.5px solid rgba(0,163,255,0.3);color:#fff;padding:10px 12px;font-size:1rem}
	.form-control:focus{background:rgba(30,50,90,0.9);border-color:var(--accent);box-shadow:0 0 15px rgba(0,163,255,0.4);color:#fff;outline:none}
	.form-control::placeholder{color:rgba(255,255,255,0.5)}
	
	.btn-accent{background:linear-gradient(90deg,var(--accent),var(--accent2));border:none;color:#fff}
	.alert{background:linear-gradient(90deg, rgba(123,97,255,0.12), rgba(0,163,255,0.08));border:1px solid rgba(123,97,255,0.16);color:#eaf6ff}
	</style>
</head>
<body>
<div class="container app py-4">
	<header>
		<h1>APLICACION CRUD PHP</h1>
	</header>
	<main>
	<?php
	session_start();
	//Asigna a la variable $error:
	//el valor de $_SESSION['login_error'] si existe y no es null
	//o una cadena vacía '' si no existe

	$error = $_SESSION['login_error'] ?? '';
	unset($_SESSION['login_error']);
	?>

	
	<?php 
	//Muestra el mensaje de error si existe
	if ($error !== ""): ?>
		<div class="alert alert-danger"><?php echo htmlspecialchars($error);?></div>
	<?php endif; ?>

	<!--Se solicitan las credenciales de acceso: email y password-->
	<!--FORMULARIO DE LOGIN. Al hacer click en el botón Iniciar sesión, llama a la página: login_action.php (form action="login_action.php")-->
	<form method="post" action="login_action.php" class="w-50">
			<div class="mb-3">
				<label for="email" class="form-label">Email o usuario</label>
				<input type="text" name="email" id="email" class="form-control" placeholder="correo electrónico o usuario" required>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Contraseña</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="contraseña" required>
			</div>
		<button type="submit" name="inicia" value="si" class="btn btn-primary">Iniciar sesión</button>
	</form>
	<p><a href="index.php">Volver</a></p>
	</main>
	<footer>
		Created by the IES Miguel Herrero team &copy; 2026
  	</footer>
</div>
</body>
</html>
