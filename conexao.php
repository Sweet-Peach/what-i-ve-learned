<?php

//PDO
define('HOST','localhost');
define('USER','root');
define('PASS','root');
define('DBNAME','crudpdo');
define('PORT','3306');

$pdo = new pdo('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME, USER, PASS);

$query = $pdo -> prepare ('SELECT nome FROM pessoa');
$query -> execute();

for ($i = 0; $row = $query -> fetch(); $i++) {
    echo "<br>" . $row['nome'] . "<br>";
}

?>