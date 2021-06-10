<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<link href="css/bootstrap.min.css" rel="stylesheet">
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
					$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
						or die('No se ha podido conectar: ' . pg_last_error());
					$query = "SELECT * FROM Proveedor ORDER BY idProveedor";
					$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
					while ($row = pg_fetch_array($result, null)) {
						echo '<tr>';
						echo '<td>' . $row[0] . '</td>';
						echo '<td>' . $row[1] . '</td>';
						echo '<div class ="row">';
						echo '<td width=250>';
						echo '<a class="btn" href="readProveedor.php?id=' . $row[0] . '">Detalles</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" href="updateProveedor.php?id=' . $row[0] . '">Actualizar</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" href="deleteProveedor.php?id=' . $row[0] . '">Eliminar</a>';
						echo '</td>';
						echo '</div>';
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
			<a class="btn" href="index.php">Regresar</a>
		</div>
	</div> <!-- /container -->
</body>

</html>