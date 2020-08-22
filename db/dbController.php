<?php

class dbController
{
    /**
     * Add a new user to the system
     * @param PDO $pdo
     * @param string $secret
     * @param int $code
     * @param float $initBalance
     */
    public static function createUser(PDO $pdo, string $secret, int $code, float $initBalance)
    {
        $stmt = $pdo->prepare("INSERT INTO users (secret, balance, permission, code) VALUE (?,?,?,?)");
        $stmt->execute([$secret, $initBalance, 0, md5($code)]);
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
     * @return bool
     */
    public static function transaction(PDO $pdo, int $pid, int $product_amount, string $userSecret, string $authSecret)
    {
        $auth = dbController::getUserBySecret($pdo, $authSecret);
        $user = dbController::getUserBySecret($pdo, $userSecret);
        $product = dbController::getProductById($pdo, $pid);
        if (isset($product)) {
            if (isset($auth) && isset($user)) {
                if ($auth["permission"] > 0) {
                    if ($user["balance"] > $product["price"] * $product_amount) {
                        dbController::changeUserBalance($pdo, $user["id"], $product["price"] * $product_amount);
                        dbController::updateProduct($pdo, $pid, $product_amount);
                        for ($i = 0; $i < $product_amount; $i++) dbController::updateLog($pdo, $user["id"], $auth["id"], $pid);
                        return true;
                    }
                    echo "Not enough money";
                    return false;
                } else {
                    echo "Not authorized!";
                    return false;
                }
            }
            echo "User error";
            return false;
        }
        echo "Product not found";
        return false;


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
        $stmt = $pdo->prepare("SELECT id, price, name, amount, permission FROM products WHERE id = ?");
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
}