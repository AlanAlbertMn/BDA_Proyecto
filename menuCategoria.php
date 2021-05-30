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
				<h3>Tabla de categorías</h3>
			</div>
			<div class="row">
				<p>
					<a href="createCategoria.php" class="btn btn-success">Agregar un categoria</a>
				</p>
				
				<table class="table table-striped table-bordered">
					<thead>
						<tr>		                 
							<th>ID</th>
							<th>Nombre del categoria</th>
							<th>Detalles</th>               
						</tr>
					</thead>

					<tbody>
						<?php 
						include 'database.php';
						$pdo = Database::connect();
						$sql = 'SELECT *
						FROM 
						categoria
						ORDER BY idCategoria';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';							   	
							echo '<td>'. $row['idCategoria'] . '</td>';
							echo '<td>'. $row['nombreCategoria'] . '</td>';
							echo '<div class ="row">';
							echo '<td width=250>';
							echo '<a class="btn" href="readCategoria.php?id='.$row['idCategoria'].'">Detalles</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="updateCategoria.php?id='.$row['idCategoria'].'">Actualizar</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteCategoria.php?id='.$row['idCategoria'].'">Eliminar</a>';
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