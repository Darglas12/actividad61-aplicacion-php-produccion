<?php
include_once("config.php");

// Consulta los videojuegos
$sql = "SELECT * FROM videojuegos ORDER BY titulo";
$resultado = $mysqli->query($sql);
if (!$resultado) {
    http_response_code(500);
    echo "Error en la consulta: " . $mysqli->error;
    exit;
}

// Cierra la conexión cuando termine
// (la cerramos después de generar el HTML)

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Videojuegos</title>
</head>
<body>
<h1>Listado de Videojuegos</h1>
<p><a href="/">Volver</a></p>
<?php
if ($resultado->num_rows > 0) {
    echo "<table border=1>\n<tr><th>Título</th><th>Género</th><th>Precio</th><th>Plataforma</th><th>Lanzamiento</th><th>Stock</th></tr>\n";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['titulo']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['genero']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['precio']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['plataforma']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['lanzamiento']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['stock']) . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
} else {
    echo "<p>No hay videojuegos en la base de datos.</p>";
}

$mysqli->close();
?>
</body>
</html>
