<?php
require_once 'database.php';
$id = null;
if (!empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}
if ($id == null) {
	header("Location: index.php");
} else {
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT idArticulo, cantidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
			FROM 
			articulo, marca, categoria, proveedor
			WHERE
			idArticulo = ? AND
			articulo.marca=marca.idMarca AND 
			articulo.categoria=categoria.idCategoria AND
			articulo.proveedor=proveedor.idProveedor";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);

	//inicio consulta postgres

	$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
		or die('No se ha podido conectar: ' . pg_last_error());
	$query = "SELECT * FROM articulo";
	$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
	$line = pg_fetch_array($result, null);
	// fin consulta postgres
	Database::disconnect();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h3>Detalles de un artículo</h3>
			</div>

			<div class="form-horizontal">

				<div class="control-group">
					<label class="control-label">ID</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['idArticulo']; ?>
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Nombre</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $line['nombre']; ?>
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Cantidad</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['cantidad']; ?>
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Precio unitario</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $line['precioporunidad']; ?>
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Marca</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['nombreMarca']; ?>
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Proveedor</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['nombreProveedor']; ?>
						</label>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">Categoria</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['nombreCategoria']; ?>
						</label>
					</div>
				</div>

				<div class="form-actions">
					<a class="btn" href="index.php">Regresar</a>
				</div>

			</div>
		</div>
	</div> <!-- /container -->
</body>

</html>