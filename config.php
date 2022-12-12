<?php
define('SERVERNAME', '127.0.0.1');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'Forum');

$link = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>