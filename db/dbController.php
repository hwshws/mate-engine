<?php

class dbController
{
    public static function createUser(PDO $pdo, string $secret, int $code, float $initBalance)
    {
        $stmt = $pdo->prepare("INSERT INTO users (secret, balance, permission, code) VALUE (?,?,?,?)");
        $stmt->execute([$secret, $initBalance, 0, md5($code)]);
    }

    public static function transaction(PDO $pdo, int $pid, int $product_amount, string $userSecret, string $authSecret)
    {
        $auth = dbController::getUserBySecret($pdo, $authSecret);
        $user = dbController::getUserBySecret($pdo, $userSecret);
        $product = dbController::getProductById($pdo, $pid);
        if ($auth["permission"] > 0) {
            dbController::changeUserBalance($pdo, $user["id"], $product["price"] * $product_amount);
            dbController::updateProduct($pdo, $pid, $product_amount);
            for ($i = 0; $i < $product_amount; $i++) dbController::updateLog($pdo, $user["id"], $auth["id"], $pid);
        } else {
            echo "Not authorized!";
        }

    }

    private static function updateLog(PDO $pdo, int $uid, int $aid, int $pid) {
        $stmt = $pdo->prepare("INSERT INTO transaction_log (uid, auth_uid, product_id) VALUE (?,?,?)");
        $stmt->execute([$uid, $aid, $pid]);
    }

    private static function updateProduct(PDO $pdo, int $pid, int $amount) {
        $stmt = $pdo->prepare("UPDATE products SET amount = amount - (? / bottles_per_crate) WHERE id = ?");
        $stmt->execute([$amount, $pid]);
    }

    private static function changeUserBalance(PDO $pdo, int $uid, float $amount) {
        $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$amount, $uid]);
    }

    private static function getUserBySecret(PDO $pdo, string $secret)
    {
        $stmt = $pdo->prepare("SELECT id, secret, balance, permission, code FROM users WHERE secret = ?");
        $stmt->execute([$secret]);
        return $stmt->fetch();
    }

    private static function getProductById(PDO $pdo, int $pid)
    {
        $stmt = $pdo->prepare("SELECT id, price, name, amount, permission FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        return $stmt->fetch();
    }

    public static function login(PDO $pdo, string $secret, int $code)
    {
        $stmt = $pdo->prepare("SELECT id, permission FROM users WHERE secret = ? AND code = ?");
        $stmt->execute([$secret, md5($code)]);
        $res = $stmt->fetch();
        return ["success" => !empty($res), "user" => $res];
    }
}