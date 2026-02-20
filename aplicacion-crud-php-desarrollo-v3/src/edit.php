<?php
//Incluye fichero con parámetros de conexión a la base de datos
include_once("config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">    
	<title>Modificaciones</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
	:root{--accent:#00a3ff;--accent2:#7b61ff}
	html,body{height:100%;margin:0;font-family:Inter,system-ui,'Segoe UI',Roboto,Arial;background:linear-gradient(180deg, rgba(3,6,18,0.6), rgba(3,6,18,0.8)), url('/imagenes/ps5-0_ahca.jpg') center/cover fixed no-repeat;color:#eaf6ff}
	.container.app{max-width:1100px;margin:32px auto;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));box-shadow:0 10px 30px rgba(2,6,23,0.7);border-radius:16px;padding:24px;border:1px solid rgba(255,255,255,0.03);backdrop-filter: blur(6px)}
	header h1{color:#fff;font-weight:700;text-transform:uppercase;letter-spacing:1px;text-shadow:0 4px 18px rgba(123,97,255,0.6);display:inline-block;padding:8px 16px;background:linear-gradient(90deg,var(--accent),var(--accent2));border-radius:8px}
	
	.form-control{background:rgba(30,50,90,0.6);border:1.5px solid rgba(0,163,255,0.3);color:#fff;padding:10px 12px;font-size:1rem}
	.form-control:focus{background:rgba(30,50,90,0.9);border-color:var(--accent);box-shadow:0 0 15px rgba(0,163,255,0.4);color:#fff;outline:none}
	.form-control:read-only{background:rgba(30,50,90,0.4);opacity:0.7;border-color:rgba(0,163,255,0.2)}
	
	.btn-accent{background:linear-gradient(90deg,var(--accent),var(--accent2));border:none;color:#fff}
	</style>
</head>
<body>
<div class="container app">
	<header>
		<h1>APLICACION CRUD PHP</h1>
	</header>
	
	<main>				
	<h2>Modificación</h2>

	<?php


	/*Obtiene el id del registro del empleado a modificar, identificador, a partir de su URL. Este tipo de datos se accede utilizando el método: GET*/

	//Recoge el id del empleado a modificar a través de la clave identificador del array asociativo $_GET y lo almacena en la variable identificador
	$identificador = $_GET['identificador'];
	$identificador = intval($identificador);

	// Selecciona videojuego
	$stmt = $mysqli->prepare("SELECT titulo, genero, precio, plataforma, lanzamiento, stock FROM videojuegos WHERE videojuego_id = ? LIMIT 1");
	$stmt->bind_param('i', $identificador);
	$stmt->execute();
	$res = $stmt->get_result();
	if ($res->num_rows === 0) {
		$stmt->close();
		$mysqli->close();
		echo "<div>Videojuego no encontrado.</div>";
		echo "<a href='home.php'>Volver</a>";
		exit;
	}
	$fila = $res->fetch_assoc();
	$titulo = $fila['titulo'];
	$genero = $fila['genero'];
	$precio = $fila['precio'];
	$plataforma = $fila['plataforma'];
	$lanzamiento = $fila['lanzamiento'];
	$stock = $fila['stock'];
	$stmt->close();
	$mysqli->close();
	?>

<!--FORMULARIO DE EDICIÓN. Al hacer click en el botón Guardar, llama a la página (form action="edit_action.php"): edit_action.php-->

	<form action="edit_action.php" method="post" class="w-50">
		<div class="mb-3">
			<label for="titulo" class="form-label">Título (no editable)</label>
			<input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo htmlspecialchars($titulo);?>" readonly>
		</div>
		<div class="mb-3">
			<label for="genero" class="form-label">Género</label>
			<input type="text" name="genero" id="genero" class="form-control" value="<?php echo htmlspecialchars($genero);?>" required>
		</div>
		<div class="mb-3">
			<label for="precio" class="form-label">Precio</label>
			<input type="number" step="0.01" min="0" name="precio" id="precio" class="form-control" value="<?php echo htmlspecialchars($precio);?>" required>
		</div>
		<div class="mb-3">
			<label for="plataforma" class="form-label">Plataforma</label>
			<input type="text" name="plataforma" id="plataforma" class="form-control" value="<?php echo htmlspecialchars($plataforma);?>" required>
		</div>
		<div class="mb-3">
			<label for="lanzamiento" class="form-label">Año de lanzamiento</label>
			<input type="number" name="lanzamiento" id="lanzamiento" class="form-control" value="<?php echo htmlspecialchars($lanzamiento);?>" required>
		</div>
		<div class="mb-3">
			<label for="stock" class="form-label">Stock</label>
			<input type="number" min="0" name="stock" id="stock" class="form-control" value="<?php echo htmlspecialchars($stock);?>" required>
		</div>

		<div >
			<input type="hidden" name="identificador" value="<?php echo $identificador;?>">
			<button type="submit" name="modifica" value="si" class="btn btn-primary">Aceptar</button>
			<button type="button" onclick="location.href='home.php'" class="btn btn-secondary">Cancelar</button>
		</div>
	</form>
	</form>
	</main>	
	<footer>
		<p><a href="home.php">Volver</a></p>	
		<p><a href="logout.php">Cerrar sesión (Sign out) <?php echo $_SESSION['username']; ?></a></p>
		Created by the IES Miguel Herrero team &copy; 2026
  	</footer>
</div>
</body>
</html>

