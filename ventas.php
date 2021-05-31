<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Artículo</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Realizando una consulta SQL
        $dbconn = pg_connect("host=localhost dbname=proyectoBDApostgres user=postgres password=raptor00")
            or die('No se ha podido conectar: ' . pg_last_error());
        $query = 'SELECT * FROM sale';
        $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
        // Imprimiendo los resultados en HTML

        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            echo "\t<tr>\n";
            foreach ($line as $col_value) {
                echo "\t\t<td>$col_value</td>\n";
            }
            echo "\t</tr>\n";
        }
        echo "</table>\n";

        // Liberando el conjunto de resultados
        pg_free_result($result);

        // Cerrando la conexión
        pg_close($dbconn);
        ?>
        </tbody>
</body>

</html>