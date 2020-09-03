<?php
// TODO: Prevent access
require 'db/dbconnector.php';
require 'db/dbController.php';

dbController::parseProductCSV($pdo, "products.csv");
