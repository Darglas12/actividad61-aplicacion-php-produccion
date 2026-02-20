<?php
//Incluye fichero con parámetros de conexión a la base de datos
include_once("config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Altas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
	:root{--accent:#00a3ff;--accent2:#7b61ff}
	html,body{height:100%;margin:0;font-family:Inter,system-ui,'Segoe UI',Roboto,Arial;background:linear-gradient(180deg, rgba(3,6,18,0.6), rgba(3,6,18,0.8)), url('/imagenes/ps5-0_ahca.jpg') center/cover fixed no-repeat;color:#eaf6ff}
	.container.app{max-width:900px;margin:40px auto;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));box-shadow:0 10px 30px rgba(2,6,23,0.7);border-radius:12px;padding:28px;border:1px solid rgba(255,255,255,0.03);backdrop-filter: blur(6px)}
	.card-glass{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));padding:20px;border-radius:10px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 8px 30px rgba(2,6,23,0.6);color:#fff}
	.btn-primary, .btn-secondary{border-radius:8px}
	a.btn-home{display:inline-block;margin-top:16px}
	</style>
</head>
<body>
<div class="container app">
	<header>
		<h1>APLICACION CRUD PHP</h1>
	</header>
	<main>
	<div class="card-glass">
<?php
/* Se Comprueba si se ha llegado a esta página PHP a través del formulario de altas. 
Para ello se comprueba la variable de formulario: "inserta" enviada al pulsar el botón Agregar.
Los datos del formulario se acceden por el método: POST
*/

//echo $_POST['inserta'].'<br>';
if(isset($_POST['inserta'])) 
{
/*Se obtienen los datos del usuario/empleado (nombre_usuario, correo, contraseña, nombre, apellido, edad y puesto) a partir del formulario de alta (username, email, password, name, surname, age y job)  por el método POST.

Se envía a través del body del mensaje HTTP Request. No aparecen en la URL como era el caso del otro método de envío de datos: GET

Recuerda que   existen dos métodos con los que el navegador puede enviar información al servidor:

1.- Método HTTP GET. Información se envía de forma visible. A través de la URL (header HTTP Request )
En PHP los datos se administran con el array asociativo $_GET. En nuestro caso el dato del empleado se obiene a través de la clave: $_GET['identificador']
2.- Método HTTP POST. Información se envía de forma no visible. A través del cuerpo del HTTP Request 
PHP proporciona el array asociativo $_POST para acceder a la información enviada.
*/

	// datos del formulario de videojuegos
	$titulo = trim($_POST['titulo'] ?? '');
	$genero = trim($_POST['genero'] ?? '');
	$precio = $_POST['precio'] ?? '';
	$plataforma = trim($_POST['plataforma'] ?? '');
	$lanzamiento = $_POST['lanzamiento'] ?? '';
	$stock = $_POST['stock'] ?? '';

	if ($precio === '') $precio = null; else $precio = floatval($precio);
	if ($lanzamiento === '') $lanzamiento = null; else $lanzamiento = intval($lanzamiento);
	if ($stock === '') $stock = null; else $stock = intval($stock);
	
/*Con mysqli_real_scape_string protege caracteres especiales en una cadena para ser usada en una sentencia SQL.
Esta función es usada para crear una cadena SQL legal que se puede usar en una sentencia SQL. 
Los caracteres codificados son NUL (ASCII 0), \n, \r, \, ', ", y Control-Z.
Ejemplo: Entrada sin escapar: "O'Reilly" contiene una comilla simple (').
Escapado con mysqli_real_escape_string(): Se convierte en "O\'Reilly", evitando que la comilla se interprete como el fin de una cadena en SQL.
*/

//Se comprueba si algunos campos del formulario están vacíos. Es decir no tienen ningún valor útil
	if (empty($titulo) || empty($genero) || $precio === null || empty($plataforma) || $lanzamiento === null || $stock === null) {
		echo "<div>Faltan datos obligatorios.</div>";
		$mysqli->close();
		echo "<a href='javascript:self.history.back();'>Volver atras</a>";
		exit;
	}

	// Validaciones servidor: precio y stock no negativos
	if ($precio < 0) {
		echo "<div>El precio no puede ser negativo.</div>";
		$mysqli->close();
		echo "<a href='javascript:self.history.back();'>Volver atras</a>";
		exit;
	}
	if ($stock < 0) {
		echo "<div>El stock no puede ser negativo.</div>";
		$mysqli->close();
		echo "<a href='javascript:self.history.back();'>Volver atras</a>";
		exit;
	}

	// Comprobar duplicado por titulo (campo UNIQUE)
	$chk = $mysqli->prepare("SELECT videojuego_id FROM videojuegos WHERE titulo = ? LIMIT 1");
	$chk->bind_param('s', $titulo);
	$chk->execute();
	$chk->store_result();
	if ($chk->num_rows > 0) {
		$chk->close();
		$mysqli->close();
		echo "<div>Ya existe un videojuego con ese título.</div>";
		echo "<a href='javascript:self.history.back();'>Volver atras</a>";
		exit;
	}
	$chk->close();

	// Insertar usando prepared statement
	$stmt = $mysqli->prepare("INSERT INTO videojuegos (titulo, genero, precio, plataforma, lanzamiento, stock) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ssdsii', $titulo, $genero, $precio, $plataforma, $lanzamiento, $stock);
	$ok = $stmt->execute();
	$stmt->close();
	$mysqli->close();
	if ($ok) {
		echo '<h3>✅ Videojuego añadido correctamente</h3>';
		echo '<p>El videojuego se ha guardado en la base de datos.</p>';
		echo '<a href="home.php" class="btn btn-primary btn-home">Volver a la lista</a>';
	} else {
		echo '<h3>❌ Error al añadir videojuego</h3>';
		echo '<p>No se pudo guardar el registro. Verifica los datos e inténtalo de nuevo.</p>';
		echo '<a href="javascript:self.history.back();" class="btn btn-secondary btn-home">Volver</a>';
    }
}
?>

<div id="redirect-info" style="margin-top:12px;color:#cfeeff">Serás redirigido en <span id="countdown">3</span> segundos...</div>
<script>
    (function(){
        var t = 3;
        var el = document.getElementById('countdown');
        var iv = setInterval(function(){
            t--; if(el) el.textContent = t;
            if (t <= 0) { clearInterval(iv); window.location.href = 'home.php'; }
        }, 1000);
    })();
</script>
	</div>
	</main>
	</div>
	</body>
	</html>
