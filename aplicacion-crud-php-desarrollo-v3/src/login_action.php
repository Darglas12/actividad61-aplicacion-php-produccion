<?php
//Incluye fichero con parámetros de conexión a la base de datos
include_once("config.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>Inicio</title>
</head>
<body>
<div>
	<header>
		<h1>APLICACION CRUD PHP</h1>
	</header>
	<main>				
	<?php
	/* Se Comprueba si se ha llegado a esta página PHP a través del formulario de login. 
	Para ello se comprueba la variable de formulario: "inicia" enviada al pulsar el botón Iniciar sesión.
	Los datos del formulario se acceden por el método: POST
	*/
	//echo $_POST['inicia'].'<br>';
	if (isset($_POST['inicia'])) {
		// permitir login por usuario o por correo
		$identity = trim($_POST['email']);
		$password = $_POST['password'];

		//Se comprueba si existen campos del formulario vacíos (email o password).
		if (empty($identity) || empty($password)) {
			$_SESSION['login_error'] = 'Completa email y contraseña';
			//echo 'Completa email y contraseña<br>';
			header("Location: login.php");
			exit();
		} //fin si
		else 
		{
			//Se comprueba si los datos son correctos. Se busca el usuario en la base de datos por su email y se compara su contraseña
			//Se ejecuta una sentencia SQL. Selecciona (busca) el registro
			// Buscar en tabla usuarios por nombre_usuario o correo
			$stmt = $mysqli->prepare("SELECT nombre_usuario, contrasena, correo FROM usuarios WHERE nombre_usuario = ? OR correo = ? LIMIT 1");
			$stmt->bind_param('ss', $identity, $identity);
			$stmt->execute();
			$res = $stmt->get_result();
			if ($res->num_rows === 0) {
				$_SESSION['login_error'] = 'Usuario incorrecto';
				header("Location: login.php");
				exit();
			}
			$fila = $res->fetch_assoc();
			// Verificar hash. Si por compatibilidad el valor en BD no es un hash, permitir comparación directa.
			$stored = $fila['contrasena'];
			$ok = false;
			if (password_verify($password, $stored)) {
				$ok = true;
			} elseif ($password === $stored) {
				// compatibilidad con contraseñas en texto plano (migrar a hashed en registro)
				$ok = true;
			}
			if (!$ok) {
				$_SESSION['login_error'] = 'Contraseña incorrecta';
				header("Location: login.php");
				exit();
			}
			// Datos correctos -> crear variables de sesión
			$_SESSION['username'] = $fila['nombre_usuario'];
			// no hay nombre/apellido en tabla usuarios; usar nombre_usuario como display
			$_SESSION['name'] = $fila['nombre_usuario'];
			$_SESSION['surname'] = '';
			$_SESSION['email'] = $fila['correo'];
			header("Location: home.php");
			exit();
		}
		//Se cierra la conexión de base de datos
		$mysqli->close();
	} //fin si
	?>
	</main>	
</div>
</body>
</html>
