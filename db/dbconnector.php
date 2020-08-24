<?php
require_once "credentials.php";
$dsn = "$protocol:host=$host;dbname=$databaseName;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection to Database failed: " . $e->getMessage();
    die("Database error");
}