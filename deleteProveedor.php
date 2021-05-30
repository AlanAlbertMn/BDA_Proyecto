<?php 
	require 'database.php';
	$id = 0;	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];		
	}
	
	if ( !empty($_POST)) {
		// keep track post values		
		$id = $_POST['id'];		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM proveedor WHERE idProveedor = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));		
		Database::disconnect();
		header("Location: menuProveedor.php");		
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
			    	<h3>Eliminar un proveedor</h3>
			    </div>
			    
			    <form class="form-horizontal" action="deleteProveedor.php" method="post">
		    		<input type="hidden" name="id" value="<?php echo $id;?>"/>
					<p class="alert alert-error">¿Estás seguro de que quieres eliminar este proveedor?</p>
					<div class="form-actions">
						<button type="submit" class="btn btn-danger">Sí</button>
						<a class="btn" href="menuProveedor.php">No</a>
					</div>
				</form>
			</div>					
	    </div> <!-- /container -->
	</body>
</html>