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
				<h3>Tabla de marcas</h3>
			</div>
			<div class="row">
				<p>
					<a href="createMarca.php" class="btn btn-success">Agregar una marca</a>
				</p>

				<table class="table table-striped table-bordered">
					<thead>
						<tr>		                 
							<th>ID</th>
							<th>Nombre de la marca</th>
							<th>Detalles</th>               
						</tr>
					</thead>

					<tbody>
						<?php 
						include 'database.php';
						$pdo = Database::connect();
						$sql = 'SELECT *
						FROM 
						marca
						ORDER BY idMarca';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';							   	
							echo '<td>'. $row['idMarca'] . '</td>';
							echo '<td>'. $row['nombreMarca'] . '</td>';
							echo '<div class ="row">';
							echo '<td width=250>';
							echo '<a class="btn" href="readMarca.php?id='.$row['idMarca'].'">Detalles</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="updateMarca.php?id='.$row['idMarca'].'">Actualizar</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="deleteMarca.php?id='.$row['idMarca'].'">Eliminar</a>';
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