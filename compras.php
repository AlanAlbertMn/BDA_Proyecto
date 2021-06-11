<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container" style="width: 66%">
        <h3>Compras</h3>
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID del Artículo</th>
                        <th>Nombre del Artículo</th>
                        <th>Cantidad comprada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'database.php';
                    // Realizando una consulta SQL
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * FROM purchase";
                    $q = $pdo->prepare($sql);
                    $q->execute(array());
                    $data = $q->fetch(PDO::FETCH_BOTH);
                    Database::disconnect();
                    $dbconn = pg_connect("host=localhost dbname=proyectoBDA user=postgres password=bdapass")
                            or die('No se ha podido conectar: ' . pg_last_error());
                    foreach ($pdo->query($sql) as $row) {
                        //inicio consulta postgres
                        $query = "SELECT nombre FROM articulo WHERE idArticulo = '$row[1]'";
                        $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
                        $line = pg_fetch_array($result, null);
                        // fin consulta postgres
                        echo '<tr>';
                        echo '<td>' . $row['idPurchase'] . '</td>';
                        echo '<td>' . $row['idArticulo'] . '</td>';
                        echo '<td>' . $line['nombre'] . '</td>';
                        echo '<td>' . $row['cantidadComprada'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
        </div>
    </div>
</body>

</html>