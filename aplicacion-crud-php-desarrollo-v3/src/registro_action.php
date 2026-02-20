<?php

include_once("config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>Registro</title>
</head>
<body>
	<header>
		<h1>APLICACION CRUD PHP</h1>
	</header>
	<main>

<?php

	//echo $_POST['inserta'].'<br>';
	if(isset($_POST['inserta'])) 
	{
		$email = trim($_POST['email']);
		$username = trim($_POST['username']);
		$password = $_POST['password'] ?? '';
		$password2 = $_POST['password2'] ?? '';

		if(empty($email) || empty($username) || empty($password)) {
			if(empty($email)) echo "<div>Campo correo electrónico vacío.</div>";
			if(empty($username)) echo "<div>Campo nombre de usuario vacío.</div>";
			if(empty($password)) echo "<div>Campo contraseña vacío.</div>";
			$mysqli->close();
			echo "<a href='javascript:self.history.back();'>Volver atras</a>";
			exit;
		}

		if ($password !== $password2) {
			$mysqli->close();
			echo "<div>Las contraseñas no coinciden.</div>";
			echo "<a href='javascript:self.history.back();'>Volver atras</a>";
			exit;
		}

		// Comprobar duplicados en tabla usuarios (nombre_usuario o correo)
		$stmt = $mysqli->prepare("SELECT usuario_id FROM usuarios WHERE nombre_usuario = ? OR correo = ? LIMIT 1");
		$stmt->bind_param('ss', $username, $email);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$stmt->close();
			$mysqli->close();
			echo "<div>El usuario o correo ya existe.</div>";
			echo "<a href='javascript:self.history.back();'>Volver atras</a>";
			exit;
		}
		$stmt->close();

		// Hashear la contraseña
		$hash = password_hash($password, PASSWORD_DEFAULT);

		$ins = $mysqli->prepare("INSERT INTO usuarios (nombre_usuario, contrasena, correo) VALUES (?, ?, ?)");
		$ins->bind_param('sss', $username, $hash, $email);
		$ok = $ins->execute();
		$ins->close();
		$mysqli->close();
		if ($ok) {
			header("Location:index.php");
			exit;
		} else {
			echo "<div>Error al registrar usuario.</div>";
			echo "<a href='javascript:self.history.back();'>Volver atras</a>";
			exit;
		}
	}
	?>

		<!--<div>Registro añadido correctamente</div>
		<a href='index.php'>Ver resultado</a>-->
	</main>
</body>
</html>
