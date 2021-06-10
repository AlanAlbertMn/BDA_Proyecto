<?php
require 'database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<form>
		<div class="container" style="width: 66%">
			<div class="row">
				<h3>Proyecto de inventario</h3>
			</div>
			<div class="row">
				<p>
				<div>
					<a href="create.php" class="btn btn-success">Agregar un artículo</a>
					<a style="position: relative; left:30em" href="menuMarca.php" class="btn btn-success">Menú de marcas</a>
					<a style="position: relative; left:30em" href="menuProveedor.php" class="btn btn-success">Menú de proveedores</a>
					<a style="position: relative; left:30em" href="menuCategoria.php" class="btn btn-success">Menú de categoría</a>
				</div>
				</p>
				<select class="a-spacing-top-mini" name="sort" id="sort" onchange="this.form.submit();">
					<option>Ordenar por:</option>
					<option value="idArticulo">ID: alfábeticamente A-Z</option>
					<option value="nombre">Nombre: alfábeticamente A-Z</option>
					<option value="marca asc">Marca: alfábeticamente A-Z</option>
					<option value="marca desc">Marca: alfábeticamente Z-A</option>
					<option value="categoria asc">Categoría: alfábeticamente A-Z</option>
					<option value="categoria desc">Categoría: alfábeticamente Z-A</option>
					<option value="proveedor asc">Proveedor: alfábeticamente A-Z</option>
					<option value="proveedor desc">Proveedor: alfábeticamente Z-A</option>
					<option value="precioPorUnidad">Precio: de más bajo a más alto</option>
					<option value="precioPorUnidad desc">Precio: de más alto a más bajo</option>
					<option value="cantidad">Cantidad: de más baja a más alta</option>
				</select>
				<select name="sortMarca" id="sortMarca" onchange="this.form.submit();">
					<option value="">Seleccione filtro de marca</option>
					<?php
					$pdo = Database::connect();
					$query = 'SELECT * FROM marca';
					foreach ($pdo->query($query) as $row) {
						if ($row['idMarca'] == $marca)
							echo "<option selected value='" . $row['idMarca'] . "'>" . $row['nombreMarca'] . "</option>";
						else
							echo "<option value='" . $row['idMarca'] . "'>" . $row['nombreMarca'] . "</option>";
					}
					Database::disconnect();
					?>
				</select>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre del Artículo</th>
							<th>Precio</th>
							<th>Cantidad</th>
							<th>Marca</th>
							<th>Categoria</th>
							<th>Proveedor</th>
							<th>Detalles</th>
						</tr>
					</thead>

					<tbody>
						<?php
						//include 'database.php';
						$sorting = "idArticulo";
						$sortMarca = null;
						if (!empty($_GET['sort'])) {
							$sorting = $_REQUEST['sort'];
						}
						if (!empty($_GET['sortMarca'])) {
							$sortMarca = $_REQUEST['sortMarca'];
						}
						// inicio consulta postgres
						$dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
							or die('No se ha podido conectar: ' . pg_last_error());
						$query = "SELECT * FROM articulo";
						$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

						// fin consulta postgres e inicio consulta mysql

						$pdo = Database::connect();
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "SELECT idArticulo, nombre, precioPorUnidad FROM articulo";
						$q = $pdo->prepare($sql);
						$q->execute(array());
						$data = $q->fetch(PDO::FETCH_BOTH);
						Database::disconnect();

						// ORDER BY " . $sorting . "";
						// fin consulta mysql
						while ($line = pg_fetch_array($result, null)) {
							echo '<tr>';
							echo '<td>' . $line[0] . '</td>';
							echo '<td>' . $data['nombre'] . '</td>';
							echo '<td>' . $data['precioPorUnidad'] . '</td>';
							echo '<td>' . $line[1] . '</td>';
							echo '<td>' . $line[2] . '</td>';
							echo '<td>' . $line[3] . '</td>';
							echo '<td>' . $line[4] . '</td>';
							// echo '<td>' . $line['nombreCategoria'] . '</td>';
							// echo '<td>' . $line['nombreProveedor'] . '</td>';
							echo '<div class ="row">';
							echo '<td width=300>';
							echo '<a class="btn btn-info" href="read.php?id=' . $line[0] . '">Detalles</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="update.php?id=' . $line[0] . '">Actualizar</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="delete.php?id=' . $line[0] . '">Eliminar</a>';
							echo '</td>';
							echo '</div>';
							echo '</tr>';
							$data = $q->fetch(PDO::FETCH_BOTH);
						}
						?>
					</tbody>
				</table>
			</div>
			<a class="btn btn-primary" href="ventas.php">Ir a ventas</a>
			<h4>
				Alan Rodrigo Albert Morán
			</h4>
			<h4>
				Jorge Crespo Capiterucho
			</h4>
		</div> <!-- /container -->
	</form>
</body>

</html>