<?php
require_once "dbconnector.php";

$pdo->query("CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    secret VARCHAR(64) NOT NULL UNIQUE,
    balance DECIMAL NOT NULL,
    permission INT NOT NULL DEFAULT 0,
    code VARCHAR(32) NULL,
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT,
    price DECIMAL NOT NULL,
    name VARCHAR(50) NOT NULL UNIQUE,
    amount INT NOT NULL,
    permission INT DEFAULT 0,
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS transaction_log (
    id INT NOT NULL AUTO_INCREMENT,
    uid INT NOT NULL,
    auth_uid INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (uid) REFERENCES users (id),
    FOREIGN KEY (auth_uid) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id),
    PRIMARY KEY (id)
)");

echo "Added tables successfully!\n";
