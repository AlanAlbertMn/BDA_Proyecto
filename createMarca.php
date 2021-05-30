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
		$idMarcaError = null; //error id Articulo
		$nombreError = null; //error de nombre

	if ( !empty($_POST)) {
		
		// keep track post values
		$idMarca = $_POST['idMarca'];
		$nombre = $_POST['nombre'];

		// To SANITIZE Integer value use
		$idSano=(filter_var($idMarca, FILTER_SANITIZE_NUMBER_INT));
		$nombreSanitizado = stringSanitizer($nombre);
		// validate input
		$valid = true;
		
		if (empty($idMarca)) {
			$idError = 'Porfavor escribe un id para la marca';
			$valid = false;
		}
		if (empty($nombre)) {
			$marcError = 'Porfavor proporciona una marca para la marca';
			$valid = false;
		}

		// insert data
		if ($valid) {
			var_dump($_POST);
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO marca (idMarca,nombreMarca) values(?, ?)";			
			$q = $pdo->prepare($sql);
			$q->execute(array($idSano,$nombreSanitizado));
			Database::disconnect();
			header("Location: menuMarca.php");
		}
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
					<h3>Agregar una nueva marca</h3>
				</div>
				
				<form class="form-horizontal" action="createMarca.php" method="post">
				
					<div class="control-group <?php echo !empty($idError)?'error':'';?>">
						<label class="control-label">ID</label>
						<div class="controls">
							<input name="idMarca" type="text"  placeholder="ID de la marca" value="<?php echo !empty($idMarca)?$idMarca:'';?>">
							<?php if (($idMarcaError != null)) ?>
								<span class="help-inline"><?php echo $idMarcaError;?></span>
						</div>
					</div>

					<div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
						<label class="control-label">Nombre</label>
						<div class="controls">
							<input name="nombre" type="text"  placeholder="Nombre de la marca" value="<?php echo !empty($nombre)?$nombre:'';?>">
							<?php if (($nombreError != null)) ?>
								<span class="help-inline"><?php echo $nombreError;?></span>						      	
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-success">Agregar marca</button>
						<a class="btn" href="menuMarca.php">Regresar</a>
					</div>
				</form>
			</div>		
		</div> <!-- /container -->
	</body>
</html>