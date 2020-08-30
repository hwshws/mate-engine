<?php
require_once "dbconnector.php";

$pdo->query("CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    secret VARCHAR(64) NOT NULL UNIQUE,
    balance DECIMAL(4, 2) NOT NULL,
    permission INT NOT NULL DEFAULT 0,
    code VARCHAR(32) NULL,
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT,
    price DECIMAL(4, 2) NOT NULL,
    name VARCHAR(50) NOT NULL UNIQUE,
    amount DOUBLE NOT NULL,
    bottles_per_crate INT NOT NULL,
    permission INT DEFAULT 0,
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS transaction_log (
    id INT NOT NULL AUTO_INCREMENT,
    uid INT NOT NULL,
    auth_uid INT NOT NULL,
    product_id INT NOT NULL,
    -- timestamp TIMESTAMP DEFAULT UTC_TIMESTAMP, -- TODO: Consider if this is useful
    FOREIGN KEY (uid) REFERENCES users (id),
    FOREIGN KEY (auth_uid) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id),
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS product_amount (
    id INT NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL,
    amount INT NOT NULL,
    timestamp TIMESTAMP DEFAULT UTC_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products (id),
    PRIMARY KEY (id)
)");

$pdo->query("CREATE TABLE IF NOT EXISTS server (
    id INT NOT NULL AUTO_INCREMENT,
    is_setup BOOLEAN NOT NULL DEFAULT FALSE,
    initial_balance DECIMAL(5, 2) NOT NULL,
    # application_fee DECIMAL(4, 2) NULL DEFAULT 20.0, # Do we need this?
    PRIMARY KEY (id)
)");

echo "Added tables successfully!\n";
