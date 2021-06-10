<?php
require 'database.php';
$id = 0;
if (!empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

if (!empty($_POST)) {
	// keep track post values		
	$id = $_POST['id'];
	// delete data
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "DELETE FROM articulo WHERE idArticulo = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	Database::disconnect();

	//inicio consulta postgres

	$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
		or die('No se ha podido conectar: ' . pg_last_error());
	$query = "DELETE FROM articulo WHERE idArticulo = '" . $id . "'";
	$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
	pg_free_result($result);
	pg_close($dbconn);
	// fin consulta postgres

	header("Location: index.php");
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
				<h3>Eliminar un articulo</h3>
			</div>

			<form class="form-horizontal" action="delete.php" method="post">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<p class="alert alert-error">¿Estás seguro de que quieres eliminar este artículo?</p>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger">Si</button>
					<a class="btn" href="index.php">No</a>
				</div>
			</form>
		</div>
	</div> <!-- /container -->
</body>

</html>