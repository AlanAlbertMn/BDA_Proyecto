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
							<th>Cantidad</th>
							<th>Precio</th>
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

						$pdo = Database::connect();
						$sql = "SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, 
						categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY " . $sorting . "";

						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>' . $row['idArticulo'] . '</td>';
							echo '<td>' . $row['nombre'] . '</td>';
							echo '<td>' . $row['cantidad'] . '</td>';
							echo '<td>' . '$' . $row['precioPorUnidad'] . '</td>';
							echo '<td>' . $row['nombreMarca'] . '</td>';
							echo '<td>' . $row['nombreCategoria'] . '</td>';
							echo '<td>' . $row['nombreProveedor'] . '</td>';
							echo '<div class ="row">';
							echo '<td width=300>';
							echo '<a class="btn btn-info" href="read.php?id=' . $row['idArticulo'] . '">Detalles</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-success" href="update.php?id=' . $row['idArticulo'] . '">Actualizar</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" href="delete.php?id=' . $row['idArticulo'] . '">Eliminar</a>';
							echo '</td>';
							echo '</div>';
							echo '</tr>';
						}
						Database::disconnect();
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