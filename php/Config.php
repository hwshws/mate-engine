<?php


class Config
{
    //Database Configuration
    private static $pdoDNS = "mysql:host=localhost;port=3306;dbname=mate";
    private static $pdoUser = "root";
    private static $pdoPW = "";

    //Handels and returns a PDO database object
    public static function dbCon()
    {
        try {
            $dbh = new PDO(self::$pdoDNS, self::$pdoUser, self::$pdoPW);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;
        } catch (PDOException $e) {
            echo "<b><div class='red'>Connection failed: " . $e->getMessage() . "</div></b>";
            exit();
        }
    }
}