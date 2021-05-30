<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}	
	if ( $id==null) {
		header("Location: menuCategoria.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT *
			FROM 
			categoria
			WHERE
			idCategoria = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		    		<h3>Detalles de la categoria</h3>
		    	</div>
		    
	    		<div class="form-horizontal" >
	    		
					<div class="control-group">
						<label class="control-label">ID</label>
					    <div class="controls">
							<label class="checkbox">
								<?php echo $data['idCategoria'];?>
							</label>
					    </div>
					</div>

					<div class="control-group">
					    <label class="control-label">Nombre</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['nombreCategoria'];?>
						    </label>
					    </div>
					</div>
					
				    <div class="form-actions">
						<a class="btn" href="menuCategoria.php">Regresar</a>
					</div>					
					 
				</div>
			</div>
		</div> <!-- /container -->
  	</body>
</html>