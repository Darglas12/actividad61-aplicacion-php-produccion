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
	a{color:#bfe7ff}
	.btn-accent{background:linear-gradient(90deg,var(--accent),var(--accent2));border:none;color:#fff}
	.card-glass{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));padding:18px;border-radius:12px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 8px 30px rgba(2,6,23,0.6);color:#fff}
	.footer{color:#9fb7d9;margin-top:18px}
	</style>
</head>
<body>
<div class="container app">
	<header>
		<h1>APLICACION CRUD VANILLA PHP</h1>
	</header>

	<main>
	
	<?php
	session_start();
	//Si el usuario ya ha iniciado sesión se le redirige a la página home.php
	if (isset($_SESSION['username'])) {
		header("Location: home.php");
		exit();
	}
	?>
	<p><a href="login.php">Iniciar sesión (Sign in)</a></p>
	<p><a href="registro.php">Registrarse (Sign up)</a></p>

	</main>
	<footer>
    	Created by the IES Miguel Herrero team &copy; 2026
  	</footer>
</div>
</body>
</html>
