<?php
require 'db/dbconnector.php';
require 'db/dbController.php';

dbController::parseProductCSV($pdo, "products.csv");
