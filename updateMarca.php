<?php 

	require 'database.php';

	function stringSanitizer($stringSanitizado)
	{
		//remove space bfore and after
		$stringSanitizado = trim($stringSanitizado); 
		//remove slashes
		$stringSanitizado = stripslashes($stringSanitizado); 
		$stringSanitizado=(filter_var($stringSanitizado, FILTER_SANITIZE_STRING));
		return $stringSanitizado;
	}

	// keep track validation errors
		$idMarcaError = null;
		$nombreError = null;
		$id = null;

	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$idMarca = $_POST['idMarca'];
		$nombre = $_POST['nombre'];

		$idSano=(filter_var($idMarca, FILTER_SANITIZE_NUMBER_INT));
		$nombreSanitizado = stringSanitizer($nombre);

		/// validate input
		$valid = true;

		if (empty($nombre)) {
			$nombreError = 'Porfavor escribe el nombre de la marca';
			$valid = false;
		}

		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE marca set idMarca = ?, nombreMarca = ? WHERE idMarca = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($idSano,$nombreSanitizado,$id));
			Database::disconnect();	
			header("Location: menuMarca.php");
		}
		} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM marca where idMarca = ?";

		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$idMarca = $data['idMarca'];
		$nombre = $data['nombreMarca'];

		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta 	charset="utf-8">
		<link   href=	"css/bootstrap.min.css" rel="stylesheet">
		<script src=	"js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="span10 offset1">
				<div class="row">
					<h3>Actualizar datos de una marca</h3>
				</div>
			
					<form class="form-horizontal" action="updateMarca.php?id=<?php echo $id?>" method="post">
					  
					  <div class="control-group <?php echo !empty($idMarcaError)?'error':'';?>">

						<label class="control-label">ID</label>
						<div class="controls">
							<input name="idMarca" type="text" readonly placeholder="id" value="<?php echo !empty($idMarca)?$idMarca:''; ?>">
							<?php if (!empty($idMarca)): ?>
								<span class="help-inline"><?php echo $idMarcaError;?></span>
							<?php endif; ?>
						</div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
					  
						<label class="control-label">Nombre</label>
						<div class="controls">
							<input name="nombre" type="text" placeholder="nombre" value="<?php echo !empty($nombre)?$nombre:'';?>">
							<?php if (!empty($nombreError)): ?>
								<span class="help-inline"><?php echo $nombreError;?></span>
							<?php endif;?>
						</div>
					  </div>

					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Actualizar marca</button>
						  <a class="btn" href="menuMarca.php">Regresar</a>
						</div>
					</form>
				</div>
	</div> <!-- /container -->
  </body>
</html>