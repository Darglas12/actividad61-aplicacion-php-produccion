
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro</title>
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
	</style>
</head>
<body>
<div class="container app">
	<header>
		<h1 class="p-3">APLICACION CRUD PHP</h1>
	</header>
	<main>                
	<h2>Registro</h2>

	<!--FORMULARIO DE REGISTRO. Al hacer click en el botón Aceptar, llama a la página: registro_action.php (form action="registro_action.php")-->
	<form action="registro_action.php" method="post" class="w-50">
		<div class="mb-3">
			<label for="email" class="form-label">Correo</label>
			<input type="email" class="form-control" name="email" id="email" placeholder="correo electrónico" required>
		</div>
		<div class="mb-3">
			<label for="username" class="form-label">Usuario</label>
			<input type="text" class="form-control" name="username" id="username" placeholder="nombre usuario" required>
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Contraseña</label>
			<input type="password" class="form-control" name="password" id="password" placeholder="contraseña" required>
		</div>
		<div class="mb-3">
			<label for="password2" class="form-label">Repetir contraseña</label>
			<input type="password" class="form-control" name="password2" id="password2" placeholder="repita la contraseña" required>
		</div>
		<div>
			<button type="submit" name="inserta" value="si" class="btn btn-primary">Aceptar</button>
			<button type="button" onclick="location.href='index.php'" class="btn btn-secondary">Cancelar</button>
		</div>
	</form>
	
	</main>	
	<footer>
	<p><a href="login.php">Ya tienes una cuenta? Iniciar sesión (Sign in)</a></p>		
	Created by the IES Miguel Herrero team &copy; 2026
  	</footer>
</div>
</body>
</html>