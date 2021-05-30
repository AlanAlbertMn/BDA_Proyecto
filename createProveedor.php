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
		$idProveedorError = null; //error id Articulo
		$nombreError = null; //error de nombre

	if ( !empty($_POST)) {
		
		// keep track post values
		$idProveedor = $_POST['idProveedor'];
		$nombre = $_POST['nombre'];
		
		$idSano=(filter_var($idProveedor, FILTER_SANITIZE_NUMBER_INT));
		$nombreSanitizado = stringSanitizer($nombre);
		// validate input
		$valid = true;
		
		if (empty($idProveedor)) {
			$idError = 'Porfavor escribe un id para la proveedor';
			$valid = false;
		}
		if (empty($nombre)) {
			$provError = 'Porfavor proporciona una proveedor para la proveedor';
			$valid = false;
		}

		// insert data
		if ($valid) {
			var_dump($_POST);
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO proveedor (idProveedor,nombreProveedor) values(?, ?)";			
			$q = $pdo->prepare($sql);
			$q->execute(array($idSano,$nombreSanitizado));
			Database::disconnect();
			header("Location: menuProveedor.php");
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
					<h3>Agregar un nuevo proveedor</h3>
				</div>
				
				<form class="form-horizontal" action="createProveedor.php" method="post">
				
					<div class="control-group <?php echo !empty($idError)?'error':'';?>">
						<label class="control-label">ID</label>
						<div class="controls">
							<input name="idProveedor" type="text"  placeholder="ID del proveedor" value="<?php echo !empty($idProveedor)?$idProveedor:'';?>">
							<?php if (($idProveedorError != null)) ?>
								<span class="help-inline"><?php echo $idProveedorError;?></span>
						</div>
					</div>

					<div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
						<label class="control-label">Nombre</label>
						<div class="controls">
							<input name="nombre" type="text"  placeholder="Nombre del proveedor" value="<?php echo !empty($nombre)?$nombre:'';?>">
							<?php if (($nombreError != null)) ?>
								<span class="help-inline"><?php echo $nombreError;?></span>						      	
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="btn btn-success">Agregar proveedor</button>
						<a class="btn" href="menuProveedor.php">Regresar</a>
					</div>
				</form>
			</div>		
		</div> <!-- /container -->
	</body>
</html>