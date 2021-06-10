<?php

require_once 'database.php';

function stringSanitizer($stringSanitizado)
{
	//remove space bfore and after
	$stringSanitizado = trim($stringSanitizado);
	//remove slashes
	$stringSanitizado = stripslashes($stringSanitizado);
	$stringSanitizado = (filter_var($stringSanitizado, FILTER_SANITIZE_STRING));
	return $stringSanitizado;
}

// keep track validation errors
$idError = null;
$nombreError = null;
$cantError = null;
$precioError = null;
$marcError = null;
$provError = null;
$catError = null;
$id = null;

if (!empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

if (null == $id) {
	header("Location: index.php");
}

if (!empty($_POST)) {
	// keep track post values
	$idArt = $_POST['idArt'];
	$nombre = $_POST['nombre'];
	$cant = $_POST['cantidad'];
	$precio = $_POST['precio'];
	$marca = $_POST['marca'];
	$prov = $_POST['proveedor'];
	$cat = $_POST['categoria'];

	$idSano = (filter_var($idArt, FILTER_SANITIZE_NUMBER_INT));
	$nombreSanitizado = stringSanitizer($nombre);
	$cantSanitizado = stringSanitizer($cant);
	$precioSanitizado = stringSanitizer($precio);
	$marcaSanitizado = stringSanitizer($marca);
	$provSanitizado = stringSanitizer($prov);
	$catSanitizado = stringSanitizer($cat);

	/// validate input
	$valid = true;

	if (empty($nombre)) {
		$nombreError = 'Porfavor escribe el nombre del artículo';
		$valid = false;
	}

	if (empty($cant)) {
		$cantError = 'Porfavor escribe una cantidad';
		$valid = false;
	}

	if (empty($precio)) {
		$precioError = 'Porfavor escribe un precio unitario del artículo';
		$valid = false;
	}

	if (empty($marca)) {
		$marcError = 'Porfavor elige una marca';
		$valid = false;
	}

	if (empty($cat)) {
		$catError = 'Porfavor escribe un id de categoría';
		$valid = false;
	}

	if (empty($prov)) {
		$provError = 'Porfavor escribe un id de proveedor';
		$valid = false;
	}
	// update data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE articulo set idArticulo = ?, cantidad =?, marca=?, proveedor=?, categoria=? WHERE idArticulo = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($idSano, $cantSanitizado, $marcaSanitizado, $provSanitizado, $catSanitizado, $id));
		Database::disconnect();

		//inicio consulta postgres
		$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
			or die('No se ha podido conectar: ' . pg_last_error());
		$query = "UPDATE articulo SET nombre = '$nombreSanitizado', precioporunidad = '$precioSanitizado' WHERE idArticulo = '$id'";
		$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
		$line = pg_fetch_array($result, null);
		// fin consulta postgres

		header("Location: index.php");
	}
} else {
	//inicio consulta postgres
	$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
		or die('No se ha podido conectar: ' . pg_last_error());
	$query = "SELECT * FROM articulo WHERE idArticulo = '$id'";
	$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
	$line = pg_fetch_array($result, null);
	// fin consulta postgres

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM articulo where idArticulo = ?";

	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$idArt = $data['idArticulo'];
	$nombre = $line['nombre'];
	$cant = $data['cantidad'];
	$precio = $line['precioporunidad'];
	$marca = $data['marca'];
	$prov = $data['proveedor'];
	$cat  = $data['categoria'];

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
				<h3>Actualizar datos de un articulo</h3>
			</div>

			<form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post">

				<div class="control-group <?php echo !empty($idError) ? 'error' : ''; ?>">

					<label class="control-label">ID</label>
					<div class="controls">
						<input name="idArt" type="text" readonly placeholder="id" value="<?php echo !empty($idArt) ? $idArt : ''; ?>">
						<?php if (!empty($idArt)) : ?>
							<span class="help-inline"><?php echo $idError; ?></span>
						<?php endif; ?>
					</div>
				</div>

				<div class="control-group <?php echo !empty($nombreError) ? 'error' : ''; ?>">

					<label class="control-label">Nombre</label>
					<div class="controls">
						<input name="nombre" type="text" placeholder="nombre" value="<?php echo !empty($nombre) ? $nombre : ''; ?>">
						<?php if (!empty($nombreError)) : ?>
							<span class="help-inline"><?php echo $nombreError; ?></span>
						<?php endif; ?>
					</div>
				</div>

				<div class="control-group <?php echo !empty($cantError) ? 'error' : ''; ?>">
					<label class="control-label">Cantidad</label>
					<div class="controls">
						<input name="cantidad" type="text" placeholder="Cantidad" value="<?php echo !empty($cant) ? $cant : ''; ?>">
						<?php if (($cantError != null)) ?>
						<span class="help-inline"><?php echo $cantError; ?></span>
					</div>
				</div>

				<div class="control-group <?php echo !empty($precioError) ? 'error' : ''; ?>">
					<label class="control-label">Precio unitario</label>
					<div class="controls">
						<input name="precio" type="text" placeholder="Precio unitario" value="<?php echo !empty($precio) ? $precio : ''; ?>">
						<?php if (($precioError != null)) ?>
						<span class="help-inline"><?php echo $precioError; ?></span>
					</div>
				</div>

				<div class="control-group <?php echo !empty($marcError) ? 'error' : ''; ?>">
					<label class="control-label">Marca</label>
					<div class="controls">
						<select name="marca">
							<option value="">Selecciona una marca</option>
							<?php
							$pdo = Database::connect();
							$query = 'SELECT * FROM marca';
							foreach ($pdo->query($query) as $row) {
								if ($row['idMarca'] == $marca)
									echo "<option selected value='" . $row['idMarca'] . "'>" . $row['nombreMarca'] . "</option>";
								else
									echo "<option value='" . $row['idMarca'] . "'>" . $row['nombreMarca'] . "</option>";
							}
							Database::disconnect();
							?>
						</select>
						<?php if (($marcError) != null) ?>
						<span class="help-inline"><?php echo $marcError; ?></span>
					</div>
				</div>


				<div class="control-group <?php echo !empty($catError) ? 'error' : ''; ?>">
					<label class="control-label">Categoria</label>
					<div class="controls">
						<select name="categoria">
							<option value="">Selecciona una categoria</option>
							<?php
							$pdo = Database::connect();
							$query = 'SELECT * FROM categoria';
							foreach ($pdo->query($query) as $row) {
								if ($row['idCategoria'] == $cat)
									echo "<option selected value='" . $row['idCategoria'] . "'>" . $row['nombreCategoria'] . "</option>";
								else
									echo "<option value='" . $row['idCategoria'] . "'>" . $row['nombreCategoria'] . "</option>";
							}
							Database::disconnect();
							?>
						</select>
						<?php if (($catError) != null) ?>
						<span class="help-inline"><?php echo $catError; ?></span>
					</div>
				</div>

				<div class="control-group <?php echo !empty($provError) ? 'error' : ''; ?>">
					<label class="control-label">Proveedor</label>
					<div class="controls">
						<select name="proveedor">
							<option value="">Selecciona un proveedor</option>
							<?php
							$pdo = Database::connect();
							$query = 'SELECT * FROM proveedor';
							foreach ($pdo->query($query) as $row) {
								if ($row['idProveedor'] == $prov)
									echo "<option selected value='" . $row['idProveedor'] . "'>" . $row['nombreProveedor'] . "</option>";
								else
									echo "<option value='" . $row['idProveedor'] . "'>" . $row['nombreProveedor'] . "</option>";
							}
							Database::disconnect();
							?>
						</select>
						<?php if (($provError) != null) ?>
						<span class="help-inline"><?php echo $provError; ?></span>
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Actualizar</button>
					<a class="btn" href="index.php">Regresar</a>
				</div>
			</form>
		</div>

	</div> <!-- /container -->
</body>

</html>