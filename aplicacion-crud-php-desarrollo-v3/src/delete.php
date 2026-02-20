<?php
//Incluye fichero con parámetros de conexión a la base de datos
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bajas</title>
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
/*Obtiene el id del registro del empleado a eliminar, identificador, a partir de su URL. Se recibe el dato utilizando el método: GET 
Recuerda que   existen dos métodos con los que el navegador puede enviar información al servidor:
1.- Método HTTP GET. Información se envía de forma visible. A través de la URL (header HTTP Request )
En PHP los datos se administran con el array asociativo $_GET. En nuestro caso el dato del empleado se obiene a través de la clave: $_GET['identificador']
2.- Método HTTP POST. Información se envía de forma no visible. A través del cuerpo del HTTP Request 
PHP proporciona el array asociativo $_POST para acceder a la información enviada.
*/

//Recoge el id del empleado a eliminar a través de la clave identificador del array asociativo $_GET y lo almacena en la variable identificador
$identificador = isset($_GET['identificador']) ? intval($_GET['identificador']) : 0;
if ($identificador <= 0) {
	echo "<div>Identificador inválido.</div>";
	echo "<a href='home.php'>Volver</a>";
	exit;
}

// Borra videojuego por id
$stmt = $mysqli->prepare("DELETE FROM videojuegos WHERE videojuego_id = ?");
$stmt->bind_param('i', $identificador);
$stmt->execute();
$stmt->close();
$mysqli->close();
echo '<h3>🗑️ Videojuego eliminado</h3>';
echo '<p>El videojuego se ha eliminado correctamente.</p>';
echo '<a href="home.php" class="btn btn-primary btn-home">Volver a la lista</a>';
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
//Se redirige a la página principal: home.php
//header("Location:home.php");
?>
 
    </main>
</div>
</body>
</html>

