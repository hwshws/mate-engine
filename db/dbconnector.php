<?php
require_once "credentials.php";
$dsn = PROTOCOL . ":host=" . HOST . ";dbname=" . DBNAME . ";charset=" . CHARSET;

try {
    $pdo = new PDO($dsn, USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection to Database failed: " . $e->getMessage();
    die("Database error");
}