<?php

// TODO: Better pdo

class dbController
{
    /**
     * Add a new user to the system
     * @param PDO $pdo
     * @param string $secret
     * @param int $code
     * @param float $initBalance
     * @param int $permission
     */
    public static function createUser(PDO $pdo, string $secret, int $code, float $initBalance, int $permission)
    {
        $stmt = $pdo->prepare("INSERT INTO users (secret, balance, permission, code) VALUE (?,?,?,?)");
        $stmt->execute([$secret, $initBalance, $permission, md5($code)]);
    }

    /**
     * Get user balance by the uid
     * @param PDO $pdo
     * @param int $uid
     * @return mixed
     */
    public static function getUserBalance(PDO $pdo, int $uid)
    {
        $user = dbController::getUserById($pdo, $uid);
        return $user["balance"];
    }

    /**
     * Get user balance by the secret
     * @param PDO $pdo
     * @param string $secret
     * @return mixed
     */
    public static function getUserBalanceBySecret(PDO $pdo, string $secret)
    {
        $user = dbController::getUserBySecret($pdo, $secret);
        return $user["balance"];
    }

    /**
     * @param PDO $pdo
     * @param string $secret
     */
    public static function emptyUserAccount(PDO $pdo, string $secret)
    {
        $stmt = $pdo->prepare("UPDATE users SET balance = 0 WHERE secret = ?");
        $stmt->execute([$secret]);
    }

    public static function addUserBalance(PDO $pdo, string $secret, float $amount)
    {
        $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE secret = ?");
        $stmt->execute([$amount, $secret]);
    }

    /**
     * Adds a new product
     * @param PDO $pdo
     * @param float $price
     * @param string $name
     * @param float $crate_amount
     * @param int $bpc
     * @param int $permission
     */
    public static function addProduct(PDO $pdo, string $name, float $price, float $crate_amount, int $bpc, int $permission = 0)
    {
        $stmt = $pdo->prepare("INSERT INTO products (price, name, amount, bottles_per_crate, permission) VALUE (?,?,?,?,?)");
        $stmt->execute([$price, $name, $crate_amount, $bpc, $permission]);
    }

    /**
     * Make a transaction
     * @param PDO $pdo
     * @param int $pid
     * @param int $product_amount
     * @param string $userSecret
     * @param string $authSecret
     * @return array
     */
    public static function transaction(PDO $pdo, int $pid, int $product_amount, string $userSecret, string $authSecret)
    {
        $auth = dbController::getUserBySecret($pdo, $authSecret);
        $user = dbController::getUserBySecret($pdo, $userSecret);
        $product = dbController::getProductById($pdo, $pid);
        $resp = array("success" => false, "data" => array("title" => "Getränk" . ((int)$product_amount > 1 ? "e" : "") . " konnte" . ((int)$product_amount > 1 ? "n" : "") . " nicht gekauft werden!"));  // Extra für Heinz!!
        if (isset($product)) {
            if ($product["amount"] * $product["bottles_per_crate"] >= $product_amount) {
                if ($auth["permission"] >= $product["permission"]) {
                    if ($user["balance"] > $product["price"] * $product_amount) {
                        dbController::changeUserBalance($pdo, $user["id"], -$product["price"] * $product_amount);
                        dbController::updateProduct($pdo, $pid, $product_amount);
                        for ($i = 0; $i < $product_amount; $i++) dbController::updateLog($pdo, $user["id"], $auth["id"], $pid); // TODO: Better logging
                        $resp["success"] = true;
                        $resp["data"]["title"] = "Getränk" . ($product_amount > 1 ? "e" : "") . " gekauft!";
                    } else {
                        http_response_code(402);
                        $resp["data"]["text"] = "Nicht genug Geld!";
                    }
                } else {
                    http_response_code(401);
                    $resp["data"]["text"] = "Fehlende Adminberechtigungen!";
                }
            } else {
                http_response_code(400);
                $resp["data"]["text"] = "Nicht genug Getränke vorhanden!";
            }
        } else {
            http_response_code(400);
            $resp["data"]["text"] = "Produkt nicht vorhanden!";
        }
        return $resp;
    }

    /**
     * Updates transaction log
     * @param PDO $pdo
     * @param int $uid
     * @param int $aid
     * @param int $pid
     */
    private static function updateLog(PDO $pdo, int $uid, int $aid, int $pid)
    {
        $stmt = $pdo->prepare("INSERT INTO transaction_log (uid, auth_uid, product_id) VALUE (?,?,?)");
        $stmt->execute([$uid, $aid, $pid]);
    }

    /**
     * Adds/Removes product amount
     * @param PDO $pdo
     * @param int $pid
     * @param int $amount
     */
    private static function updateProduct(PDO $pdo, int $pid, int $amount)
    {
        $stmt = $pdo->prepare("UPDATE products SET amount = amount - (? / bottles_per_crate) WHERE id = ?");
        $stmt->execute([$amount, $pid]);
    }

    /**
     * Updates user balance
     * @param PDO $pdo
     * @param int $uid
     * @param float $amount
     */
    private static function changeUserBalance(PDO $pdo, int $uid, float $amount)
    {
        $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$amount, $uid]);
    }

    /**
     * Get the user by his secret
     * @param PDO $pdo
     * @param string $secret
     * @return mixed
     */
    private static function getUserBySecret(PDO $pdo, string $secret)
    {
        $stmt = $pdo->prepare("SELECT id, secret, balance, permission, code FROM users WHERE secret = ?");
        $stmt->execute([$secret]);
        return $stmt->fetch();
    }

    /**
     * Get the user by his id
     * @param PDO $pdo
     * @param int $uid
     * @return mixed
     */
    private static function getUserById(PDO $pdo, int $uid)
    {
        $stmt = $pdo->prepare("SELECT id, secret, balance, permission, code FROM users WHERE id = ?");
        $stmt->execute([$uid]);
        return $stmt->fetch();
    }

    /**
     * Get the product by its id
     * @param PDO $pdo
     * @param int $pid
     * @return mixed
     */
    private static function getProductById(PDO $pdo, int $pid)
    {
        $stmt = $pdo->prepare("SELECT id, price, name, amount, permission, bottles_per_crate FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        return $stmt->fetch();
    }

    /**
     * User login
     * @param PDO $pdo
     * @param string $secret
     * @param int $code
     * @return array
     */
    public static function login(PDO $pdo, string $secret, int $code)
    {
        $stmt = $pdo->prepare("SELECT id, permission FROM users WHERE secret = ? AND code = ?");
        $stmt->execute([$secret, md5($code)]);
        $res = $stmt->fetch();
        return ["success" => !empty($res), "user" => $res];
    }

    /**
     * Returns all products
     * @param PDO $pdo
     * @return array
     */
    public static function getProducts(PDO $pdo)
    {
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    /**
     * Parses csv and adds all products to db
     * @param PDO $pdo
     * @param string $fn
     */
    public static function parseProductCSV(PDO $pdo, string $fn)
    {
        $hndl = fopen($fn, "r");
        $flag = true;
        while ($data = fgetcsv($hndl, 1000, ",")) {
            if ($flag) {
                $flag = false;
                continue;
            }
            dbController::addProduct($pdo, $data[0], $data[1], $data[2], $data[3], $data[4]);
        }
        fclose($hndl);
    }

    /**
     * Validates user secret and code against the db
     * @param PDO $pdo
     * @param string $userSecret
     * @param string $userCode
     * @return bool
     */
    public static function validateUser(PDO $pdo, string $userSecret, string $userCode)
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE secret = ? AND code = ?");
        $stmt->execute([$userSecret, md5($userCode)]);
        return !empty($stmt->fetch());
    }

    /**
     * @param PDO $pdo
     * @param string $secret
     * @param int $code
     * @return bool
     */
    public static function isAdmin(PDO $pdo, string $secret, int $code)
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE secret = ? AND code = ?");
        $stmt->execute([$secret, md5($code)]);
        $res = $stmt->fetch();
        return !empty($res) && $res["permission"] > 0;
    }

    /**
     * TODO: Split setup and is_setup
     * @param PDO $pdo
     * @return bool
     */
    public static function isSetup(PDO $pdo)
    {
        $stmt = $pdo->query("SELECT * FROM server");
        $res = $stmt->fetch();
        if (empty($res)) return false;
        return $res["is_setup"] === 1;
    }

    /**
     * @param PDO $pdo
     * @param float $initBalance
     * @param string $adminQR
     * @param int $adminPin
     */
    public static function setup(PDO $pdo, float $initBalance, string $adminQR, int $adminPin/*, float $ticketPrice*/)
    {
        $stmt = $pdo->query("SELECT id, is_setup FROM server");
        $res = $stmt->fetch();
        if (empty($res)) return;
        if ($res["is_setup"] === 1) {
            dbController::createUser($pdo, $adminQR, $adminPin, 0, 3);
            $stmt = $pdo->prepare("INSERT INTO server (is_setup, initial_balance) VALUE (TRUE, ?)");
            $stmt->execute([$initBalance]);
        } else if ($res["is_setup"] === 0) {
            $stmt = $pdo->prepare("UPDATE server SET is_setup = TRUE AND initial_balance = ? WHERE id = ?");
            $stmt->execute([$initBalance, $res["id"]]);
        }
    }
}