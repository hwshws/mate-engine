<?php
require_once "dbconnector.php";

$pdo->query("CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    pre_name VARCHAR(32) NOT NULL,
    last_name VARCHAR(32) NOT NULL,
    secret VARCHAR(64) NOT NULL,
    permission BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS balance (
    id INT NOT NULL AUTO_INCREMENT,
    uid INT NOT NULL,
    FOREIGN KEY (uid) REFERENCES users (id),
    PRIMARY KEY (id),
    balance DECIMAL NOT NULL 
)");

echo "Added tables successfully!";
?>
