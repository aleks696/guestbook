<?php
session_start();
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBNAME", "guestbook");
define("DBCHARSET", "utf8");
define("SALT", "guestBook");

$dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";charset=".DBCHARSET;
try {
    $dbConn = new PDO($dsn, DBUSER);
} catch (PDOException $e) {
    die("Подключение не удалось: " . $e->getMessage());
}