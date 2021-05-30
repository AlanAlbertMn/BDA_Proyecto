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
					<a href="create.php" class="btn btn-success">Agregar un artículo</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="menuMarca.php" class="btn btn-success">Menú de marcas</a>
					<a href="menuProveedor.php" class="btn btn-success">Menú de proveedores</a>
					<a href="menuCategoria.php" class="btn btn-success">Menú de categoría</a>
				</p>
				<select class="a-spacing-top-mini" name="sort" id="sort" onchange="this.form.submit();">
					<option>Ordenar por:</option>
					<option value="idDeArticulo">ID: alfábeticamente A-Z</option>
					<option value="articulo-nombre">Nombre: alfábeticamente A-Z</option>
					<option value="marca-nombre">Marca: alfábeticamente A-Z</option>
					<option value="marca-nombre-desc">Marca: alfábeticamente Z-A</option>
					<option value="categoria-nombre">Categoría: alfábeticamente A-Z</option>
					<option value="proveedor-nombre">Proveedor: alfábeticamente A-Z</option>
					<option value="proveedor-nombre-desc">Proveedor: alfábeticamente Z-A</option>
					<option value="precio-menor-mayor">Precio: de más bajo a más alto</option>
					<option value="precio-mayor-menor">Precio: de más alto a más bajo</option>
					<option value="cantidad-menor-mayor">Cantidad: de más baja a más alta</option>
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
						$sorting = null;
						$sortMarca = null;
						if (!empty($_GET['sort'])) {
							$sorting = $_REQUEST['sort'];
						}
						if (!empty($_GET['sortMarca'])) {
							$sortMarca = $_REQUEST['sortMarca'];
						}

						$pdo = Database::connect();
						if ($sorting == 'marca-nombre') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY nombreMarca';
						} else if ($sorting == 'precio-mayor-menor') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY precioPorUnidad DESC';
						} else if ($sorting == 'marca-nombre-desc') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY nombreMarca DESC';
						} else if ($sorting == 'articulo-nombre') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY nombre';
						} else if ($sorting == 'precio-menor-mayor') { //ordenar menor a mayor el precio
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY precioPorUnidad';
						} else if ($sorting == 'categoria-nombre') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY nombreCategoria';
						} else if ($sorting == 'cantidad-menor-mayor') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY cantidad';
						} else if ($sorting == 'idDeArticulo') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY idArticulo';
						} else if ($sorting == 'proveedor-nombre') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY nombreProveedor';
						} else if ($sorting == 'proveedor-nombre-desc') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY nombreProveedor DESC';
						} else if ($sortMarca == '1') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Nacobre"';
						} else if ($sortMarca == '2') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Tuboplus"';
						} else if ($sortMarca == '3') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Urrea"';
						} else if ($sortMarca == '4') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Partner projects"';
						} else if ($sortMarca == '5') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Condumex"';
						} else if ($sortMarca == '6') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Retail"';
						} else if ($sortMarca == '7') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Comscope"';
						} else if ($sortMarca == '8') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Tangit"';
						} else if ($sortMarca == '9') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="Charofil"';
						} else if ($sortMarca == '10') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="North System"';
						} else if ($sortMarca == '11') {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							where
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor and
							marca.nombreMarca="3M"';
						} else {
							$sql = 'SELECT idArticulo, nombre, cantidad, precioPorUnidad, marca.nombreMarca, categoria.nombreCategoria, proveedor.nombreProveedor
							FROM 
							articulo, marca, categoria, proveedor
							WHERE 
							articulo.marca=marca.idMarca AND 
							articulo.categoria=categoria.idCategoria AND
							articulo.proveedor=proveedor.idProveedor
							ORDER BY idArticulo';
						}

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
							echo '<a class="btn" href="read.php?id=' . $row['idArticulo'] . '">Detalles</a>';
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