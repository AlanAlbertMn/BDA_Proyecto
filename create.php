<?php
require 'database.php';
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
$idError = null; //error id Articulo
$nombreError = null; //error de nombre
$cantError = null; //error de cantidad
$precioError = null; //error de precio
$marcError = null; //error de marca
$provError = null; //error de proveedor
$catError = null; //error de categoria

if (!empty($_POST)) {

	// keep track post values
	$idArt = $_POST['idArt'];
	$nombre = $_POST['nombre'];
	$cant = $_POST['cantidad'];
	$precio = $_POST['precio'];
	$marca = $_POST['marca'];
	$prov = $_POST['prov'];
	$cat = $_POST['cat'];

	$idSano = stringSanitizer($idArt);
	$nombreSanitizado = stringSanitizer($nombre);
	$cantSanitizado = stringSanitizer($cant);
	$precioSanitizado = stringSanitizer($precio);
	$marcaSanitizado = stringSanitizer($marca);
	$provSanitizado = stringSanitizer($prov);
	$catSanitizado = stringSanitizer($cat);

	// validate input
	$valid = true;

	if (empty($idArt)) {
		$idError = 'Porfavor escribe un id para el articulo';
		$valid = false;
	}
	if (empty($nombre)) {
		$nombreError = 'Porfavor escribe un nombre para el articulo';
		$valid = false;
	}
	if (empty($cant)) {
		$cantError = 'Porfavor proporciona una cantidad de este articulo en inventario';
		$valid = false;
	}
	if (empty($precio)) {
		$precioError = 'Porfavor proporciona un precio para el articulo';
		$valid = false;
	}
	if (empty($marca)) {
		$marcError = 'Porfavor proporciona una marca para el articulo';
		$valid = false;
	}
	if (empty($prov)) {
		$provError = 'Porfavor proporciona un proveedor para el articulo';
		$valid = false;
	}
	if (empty($cat)) {
		$catError = 'Porfavor proporciona una categoria para el articulo';
		$valid = false;
	}
	// insert data
	if ($valid) {
		var_dump($_POST);
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO articulo (idArticulo,cantidad,marca,proveedor,categoria) values(?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($idSano, $cantSanitizado, $marcaSanitizado, $provSanitizado, $catSanitizado));
		Database::disconnect();

		//inicio consulta postgres

		$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
			or die('No se ha podido conectar: ' . pg_last_error());
		$query = "INSERT INTO articulo VALUES ('$idSano', '$nombreSanitizado', $precioSanitizado)";
		$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
		$line = pg_fetch_array($result, null);
		pg_free_result($result);
		pg_close($dbconn);
		// fin consulta postgres

		header("Location: index.php");
	}
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
				<h3>Agregar un articulo nuevo</h3>
			</div>

			<form class="form-horizontal" action="create.php" method="post">

				<div class="control-group <?php echo !empty($idError) ? 'error' : ''; ?>">
					<label class="control-label">idArticulo</label>
					<div class="controls">
						<input name="idArt" type="text" placeholder="idArticulo" value="<?php echo !empty($idArticulo) ? $idArticulo : ''; ?>">
						<?php if (($idError != null)) ?>
						<span class="help-inline"><?php echo $idError; ?></span>
					</div>
				</div>

				<div class="control-group <?php echo !empty($nombreError) ? 'error' : ''; ?>">
					<label class="control-label">Nombre</label>
					<div class="controls">
						<input name="nombre" type="text" placeholder="Nombre del articulo" value="<?php echo !empty($nombre) ? $nombre : ''; ?>">
						<?php if (($idError != null)) ?>
						<span class="help-inline"><?php echo $nombreError; ?></span>
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

				<div class="control-group <?php echo !empty($provError) ? 'error' : ''; ?>">
					<label class="control-label">Proveedor</label>
					<div class="controls">
						<select name="prov">
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

				<div class="control-group <?php echo !empty($catError) ? 'error' : ''; ?>">
					<label class="control-label">Categoria</label>
					<div class="controls">
						<select name="cat">
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

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Agregar</button>
					<a class="btn" href="index.php">Regresar</a>
				</div>

			</form>
		</div>
	</div> <!-- /container -->
</body>

</html>