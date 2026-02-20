<?php
/*Incluye parámetros de conexión a la base de datos: 
DB_HOST: Nombre o dirección del gestor de BD MariaDB
DB_NAME: Nombre de la BD
DB_USER: Usuario de la BD
DB_PASSWORD: Contraseña del usuario de la BD
*/
include_once("config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'] ?? '';
$surname = $_SESSION['surname'] ?? '';
$email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">    
	<title>CRUD PHP</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
	:root{--accent:#00a3ff;--accent2:#7b61ff;--accent3:#ff006e}
	html,body{height:100%;margin:0;font-family:Inter,system-ui,'Segoe UI',Roboto,Arial;background:linear-gradient(180deg, rgba(3,6,18,0.6), rgba(3,6,18,0.8)), url('/imagenes/ps5-0_ahca.jpg') center/cover fixed no-repeat;color:#eaf6ff}
	.container.app{max-width:1200px;margin:32px auto;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));box-shadow:0 10px 30px rgba(2,6,23,0.7);border-radius:16px;padding:24px;border:1px solid rgba(255,255,255,0.03);backdrop-filter: blur(6px)}
	header h1{color:#fff;font-weight:700;text-transform:uppercase;letter-spacing:1px;text-shadow:0 4px 18px rgba(123,97,255,0.6);display:inline-block;padding:8px 16px;background:linear-gradient(90deg,var(--accent),var(--accent2));border-radius:8px}
	
	/* Grid de juegos */
	.games-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;margin:30px 0}
	
	/* Tarjeta de juego */
	.game-card{background:linear-gradient(135deg, rgba(0,163,255,0.08), rgba(123,97,255,0.08));border:1.5px solid rgba(0,163,255,0.3);border-radius:14px;padding:20px;transition:all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);cursor:pointer;position:relative;overflow:hidden;height:100%}
	
	/* Efecto fondo animado */
	.game-card::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:linear-gradient(45deg, transparent 30%, rgba(0,163,255,0.15), transparent 70%);transform:rotate(45deg);transition:all 0.6s;opacity:0}
	
	.game-card:hover::before{transform:rotate(45deg) translate(100px,100px);opacity:1}
	
	.game-card:hover{transform:translateY(-12px) scale(1.02);background:linear-gradient(135deg, rgba(0,163,255,0.15), rgba(123,97,255,0.15));border-color:rgba(0,163,255,0.6);box-shadow:0 0 30px rgba(0,163,255,0.4),0 0 60px rgba(123,97,255,0.2);border-color:rgba(0,163,255,0.8)}
	
	.game-card:hover .game-title{color:#00ffff;text-shadow:0 0 15px rgba(0,255,255,0.6)}
	
	/* Contenido de la tarjeta */
	.game-card > *{position:relative;z-index:2}
	
	.game-title{font-size:1.3rem;font-weight:700;color:#eaf6ff;margin-bottom:12px;transition:all 0.3s;letter-spacing:0.5px}
	
	.game-info{display:flex;flex-direction:column;gap:10px;margin-bottom:15px}
	
	.info-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.08)}
	
	.info-label{font-size:0.85rem;color:#00a3ff;font-weight:600;text-transform:uppercase;letter-spacing:1px}
	
	.info-value{font-size:1rem;color:#eaf6ff;font-weight:500}
	
	.price{font-size:1.4rem;font-weight:700;background:linear-gradient(90deg,var(--accent),var(--accent2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
	
	.genre-badge{display:inline-block;background:linear-gradient(90deg, rgba(0,163,255,0.3), rgba(123,97,255,0.3));border:1px solid rgba(0,163,255,0.5);color:#00ffff;padding:4px 12px;border-radius:20px;font-size:0.8rem;font-weight:600}
	
	.stock-indicator{display:inline-flex;align-items:center;gap:6px;font-weight:600}
	
	.stock-indicator.low{color:#ff006e}
	.stock-indicator.medium{color:#ffa500}
	.stock-indicator.high{color:#00ff88}
	
	/* Botones de acciones */
	.game-actions{display:flex;gap:10px;margin-top:16px;padding-top:12px;border-top:1px solid rgba(255,255,255,0.08)}
	
	.btn-action{flex:1;padding:8px 12px;border:none;border-radius:8px;font-size:0.9rem;font-weight:600;cursor:pointer;transition:all 0.3s;text-align:center;text-decoration:none;display:inline-block}
	
	.btn-edit{background:linear-gradient(90deg, rgba(0,163,255,0.7), rgba(0,200,255,0.7));color:#fff;border:1px solid rgba(0,163,255,0.5)}
	
	.btn-edit:hover{background:linear-gradient(90deg, #00a3ff, #00ffff);box-shadow:0 0 15px rgba(0,163,255,0.6);transform:scale(1.05)}
	
	.btn-delete{background:linear-gradient(90deg, rgba(255,0,110,0.7), rgba(255,100,150,0.7));color:#fff;border:1px solid rgba(255,0,110,0.5)}
	
	.btn-delete:hover{background:linear-gradient(90deg, #ff006e, #ff4d7d);box-shadow:0 0 15px rgba(255,0,110,0.6);transform:scale(1.05)}
	
	.btn-add{background:linear-gradient(90deg, rgba(0,255,136,0.7), rgba(0,200,150,0.7));color:#fff;border:none;border-radius:8px;padding:12px 20px;font-weight:600;cursor:pointer;transition:all 0.3s;text-decoration:none;display:inline-block;margin-bottom:20px}
	
	.btn-add:hover{background:linear-gradient(90deg, #00ff88, #00ffaa);box-shadow:0 0 20px rgba(0,255,136,0.6);transform:translateY(-3px)}
	
	.welcome-section{background:linear-gradient(180deg, rgba(0,163,255,0.1), rgba(123,97,255,0.1));border:1.5px solid rgba(0,163,255,0.3);border-radius:12px;padding:20px;margin-bottom:25px}
	
	.welcome-section h2{color:#00ffff;text-shadow:0 0 15px rgba(0,255,255,0.4);margin-bottom:10px}
	
	.welcome-info{font-size:0.95rem;color:#eaf6ff;line-height:1.6}
	
	footer{margin-top:40px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.1);text-align:center;color:#00a3ff;font-size:0.85rem}
	footer a{color:#00ffff;text-decoration:none;transition:all 0.3s}
	footer a:hover{color:#ff006e;text-shadow:0 0 10px rgba(255,0,110,0.5)}
	
	@media (max-width:768px){
		.games-grid{grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px}
		.game-card{padding:15px}
		.game-title{font-size:1.1rem}
	}
	</style>
</head>
<body>
<div class="container app">
	<header>
		<h1>APLICACION CRUD PHP</h1>
	</header>

	<main>
	<div class="welcome-section">
		<h2>🎮 Bienvenido, <?php echo htmlspecialchars($name . " " . $surname); ?></h2>
		<div class="welcome-info">
			📧 Email: <?php echo htmlspecialchars($email); ?>
		</div>
	</div>
	
	<a href="add.php" class="btn-add">➕ AÑADIR NUEVO JUEGO</a>

	<div class="games-grid">
<?php
/*Se realiza una consulta de selección a la tabla videojuegos y se almacenan los registros en $resultado. */
$sql = "SELECT * FROM videojuegos ORDER BY titulo";
$resultado = $mysqli->query($sql);

//Comprobamos si el nº de fila/registros es mayor que 0. La consulta genera un resultado válido
 if ($resultado->num_rows > 0) {

// Mostramos los videojuegos en tarjetas
	while ($fila = $resultado->fetch_assoc()) {
		$stock = intval($fila['stock']);
		$stock_class = $stock <= 5 ? 'low' : ($stock <= 15 ? 'medium' : 'high');
		$stock_icon = $stock <= 5 ? '⚠️' : ($stock <= 15 ? '📦' : '✅');
		
		echo '<div class="game-card">' . "\n";
		echo '<div class="game-title">' . htmlspecialchars($fila['titulo']) . '</div>' . "\n";
		
		echo '<div class="game-info">' . "\n";
		echo '<div class="info-row">' . "\n";
		echo '<span class="info-label">Género</span>' . "\n";
		echo '<span class="genre-badge">' . htmlspecialchars($fila['genero']) . '</span>' . "\n";
		echo '</div>' . "\n";
		
		echo '<div class="info-row">' . "\n";
		echo '<span class="info-label">Precio</span>' . "\n";
		echo '<span class="price">€' . number_format(floatval($fila['precio']), 2, ',', '.') . '</span>' . "\n";
		echo '</div>' . "\n";
		
		echo '<div class="info-row">' . "\n";
		echo '<span class="info-label">Plataforma</span>' . "\n";
		echo '<span class="info-value">' . htmlspecialchars($fila['plataforma']) . '</span>' . "\n";
		echo '</div>' . "\n";
		
		echo '<div class="info-row">' . "\n";
		echo '<span class="info-label">Lanzamiento</span>' . "\n";
		echo '<span class="info-value">' . intval($fila['lanzamiento']) . '</span>' . "\n";
		echo '</div>' . "\n";
		
		echo '<div class="info-row">' . "\n";
		echo '<span class="info-label">Stock</span>' . "\n";
		echo '<span class="stock-indicator ' . $stock_class . '">' . $stock_icon . ' ' . $stock . ' unidades</span>' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
		
		echo '<div class="game-actions">' . "\n";
		echo '<a href="edit.php?identificador=' . intval($fila['videojuego_id']) . '" class="btn-action btn-edit">✏️ Editar</a>' . "\n";
		echo '<a href="delete.php?identificador=' . intval($fila['videojuego_id']) . '" class="btn-action btn-delete" onclick="return confirm(\'¿Está segur@ que desea eliminar el videojuego?\')">🗑️ Eliminar</a>' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
	}
	// cerramos la conexión
	$mysqli->close();
 }//fin si
?>
	</div>
	</main>
	<footer>
		<p><a href="logout.php">Cerrar sesión (Sign out) <?php echo $_SESSION['username']; ?></a></p>
    	Created by the IES Miguel Herrero team &copy; 2026
  	</footer>
</div>
</body>
</html>
