<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Altas</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
	:root{--accent:#00a3ff;--accent2:#7b61ff}
	html,body{height:100%;margin:0;font-family:Inter,system-ui,'Segoe UI',Roboto,Arial;background:linear-gradient(180deg, rgba(3,6,18,0.6), rgba(3,6,18,0.8)), url('/imagenes/ps5-0_ahca.jpg') center/cover fixed no-repeat;color:#eaf6ff}
	.container.app{max-width:1100px;margin:32px auto;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));box-shadow:0 10px 30px rgba(2,6,23,0.7);border-radius:16px;padding:24px;border:1px solid rgba(255,255,255,0.03);backdrop-filter: blur(6px)}
	header h1{color:#fff;font-weight:700;text-transform:uppercase;letter-spacing:1px;text-shadow:0 4px 18px rgba(123,97,255,0.6);display:inline-block;padding:8px 16px;background:linear-gradient(90deg,var(--accent),var(--accent2));border-radius:8px}
	
	.form-control{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);color:#fff}
	.form-control:focus{background:rgba(255,255,255,0.1);border-color:var(--accent);box-shadow:0 0 15px rgba(0,163,255,0.3);color:#fff}
	
	.form-select{background:rgba(30,50,90,0.8);border:1.5px solid rgba(0,163,255,0.4);color:#fff;padding:10px 12px;font-size:1rem}
	.form-select:focus{background:rgba(30,50,90,0.95);border-color:var(--accent);box-shadow:0 0 15px rgba(0,163,255,0.4);color:#fff;outline:none}
	.form-select option{background:#1e325a;color:#fff;padding:8px;border-radius:4px;margin:4px 0}
	.form-select option:hover{background:var(--accent);color:#000}
	.form-select option:checked{background:linear-gradient(90deg,var(--accent),var(--accent2));color:#fff}
	
	.btn-accent{background:linear-gradient(90deg,var(--accent),var(--accent2));border:none;color:#fff}
	</style>
</head>
<body>
<div class="container app py-3">
    <header>
        <h1>APLICACION CRUD PHP</h1>
    </header>
    <main>
    <h2>Alta de videojuego</h2>
<!--FORMULARIO DE ALTA. Al hacer click en el botón Agregar, llama a la página: add.php (form action="add.php")
La página: add.php se encargará de proceder a la inserción del registro en la tabla de empleados
-->

	<form action="add_action.php" method="post" class="w-50">
		<div class="mb-3">
			<label for="titulo" class="form-label">Título</label>
			<input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título del videojuego" required>
		</div>
		<div class="mb-3">
			<label for="genero" class="form-label">Género</label>
			<select name="genero" id="genero" class="form-select" required>
				<option value="">Seleccione género</option>
				<option value="Accion">Accion</option>
				<option value="Aventura">Aventura</option>
				<option value="RPG">RPG</option>
				<option value="Simulacion">Simulacion</option>
				<option value="Terror">Terror</option>
				<option value="Deportes">Deportes</option>
			</select>
		</div>
		<div class="mb-3">
			<label for="precio" class="form-label">Precio</label>
			<input type="number" step="0.01" min="0" name="precio" id="precio" class="form-control" placeholder="Precio" required>
		</div>
		<div class="mb-3">
			<label for="plataforma" class="form-label">Plataforma</label>
			<select name="plataforma" id="plataforma" class="form-select" required>
				<option value="">Seleccione plataforma</option>
				<option value="PS5">PS5</option>
				<option value="PS4">PS4</option>
				<option value="Xbox">Xbox</option>
				<option value="PC">PC</option>
			</select>
		</div>
		<div class="mb-3">
			<label for="lanzamiento" class="form-label">Año de lanzamiento</label>
			<input type="number" name="lanzamiento" id="lanzamiento" class="form-control" placeholder="2023" min="1970" max="2100" required>
		</div>
		<div class="mb-3">
			<label for="stock" class="form-label">Stock</label>
			<input type="number" min="0" name="stock" id="stock" class="form-control" placeholder="Cantidad en stock" required>
		</div>

		<div>
			<button type="submit" name="inserta" value="si" class="btn btn-primary">Aceptar</button>
			<button type="button" onclick="location.href='home.php'" class="btn btn-secondary">Cancelar</button>
		</div>
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