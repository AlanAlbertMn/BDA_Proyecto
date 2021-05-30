<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta 	charset="utf-8">
		<link   href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="container" style="width: 66%">
			<div class="row">
				<h3>Tabla de proveedores</h3>
			</div>
			<div class="row">
				<p>
					<a href="createProveedor.php" class="btn btn-success">Agregar un proveedor</a>
				</p>
				
				<table class="table table-striped table-bordered">
					<thead>
						<tr>		                 
							<th>ID</th>
							<th>Nombre del proveedor</th>
							<th>Detalles</th>               
						</tr>
					</thead>

					<tbody>
						<?php 
						include 'database.php';
						$pdo = Database::connect();
						$sql = 'SELECT *
						FROM 
						proveedor
						ORDER BY idProveedor';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';							   	
							echo '<td>'. $row['idProveedor'] . '</td>';
							echo '<td>'. $row['nombreProveedor'] . '</td>';
							echo '<div class ="row">';
							echo '<td width=250>';
							echo '<a class="btn" href="readProveedor.php?id='.$row['idProveedor'].'">Detalles</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="updateProveedor.php?id='.$row['idProveedor'].'">Actualizar</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteProveedor.php?id='.$row['idProveedor'].'">Eliminar</a>';
							echo '</td>';
							echo '</div>';
							echo '</tr>';
						}
						Database::disconnect();
						?>
					</tbody>
				</table>
				<a class="btn" href="index.php">Regresar</a>
			</div>
		</div> <!-- /container -->
	</body>
</html>