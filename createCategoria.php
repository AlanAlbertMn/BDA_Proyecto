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
		$idCategoriaError = null; //error id Articulo
		$nombreError = null; //error de nombre

	if ( !empty($_POST)) {
		
		// keep track post values
		$idCategoria = $_POST['idCategoria'];
		$nombre = $_POST['nombre'];

		$idSano=(filter_var($idCategoria, FILTER_SANITIZE_NUMBER_INT));
		$nombreSanitizado = stringSanitizer($nombre);
		
		// validate input
		$valid = true;
		
		if (empty($idCategoria)) {
			$idError = 'Porfavor escribe un id para la categoria';
			$valid = false;
		}
		if (empty($nombre)) {
			$marcError = 'Porfavor proporciona un nombre para el categoria';
			$valid = false;
		}

		// insert data
		if ($valid) {
			var_dump($_POST);
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO categoria (idCategoria,nombreCategoria) values(?, ?)";			
			$q = $pdo->prepare($sql);
			$q->execute(array($idSano,$nombreSanitizado));
			Database::disconnect();
			header("Location: menuCategoria.php");
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
					<h3>Agregar una nueva categoria</h3>
				</div>
				
				<form class="form-horizontal" action="createCategoria.php" method="post">
				
					<div class="control-group <?php echo !empty($idError)?'error':'';?>">
						<label class="control-label">ID</label>
						<div class="controls">
							<input name="idCategoria" type="text"  placeholder="ID de la categoria" value="<?php echo !empty($idCategoria)?$idCategoria:'';?>">
							<?php if (($idCategoriaError != null)) ?>
								<span class="help-inline"><?php echo $idCategoriaError;?></span>
						</div>
					</div>

					<div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
						<label class="control-label">Nombre</label>
						<div class="controls">
							<input name="nombre" type="text"  placeholder="Nombre de la categoria" value="<?php echo !empty($nombre)?$nombre:'';?>">
							<?php if (($nombreError != null)) ?>
								<span class="help-inline"><?php echo $nombreError;?></span>						      	
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-success">Agregar categoria</button>
						<a class="btn" href="menuCategoria.php">Regresar</a>
					</div>
				</form>
			</div>		
		</div> <!-- /container -->
	</body>
</html>