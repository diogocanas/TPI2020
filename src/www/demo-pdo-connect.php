<?php
/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=tpi;host=127.0.0.1';
$user = 'test';
$password = 'root';
$dbh = "";

try {
    $dbh = new PDO($dsn, $user, $password);
    echo "yes";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

try {
    $sql =  'SELECT * FROM CLIENTS';
foreach  ($dbh->query($sql) as $row) {
    var_dump($row);
}

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>