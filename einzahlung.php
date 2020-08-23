<!doctype html>
<html lang="de">
<head>
    <title>mate-engine - Getränkeverkauf bei JHULM</title>
    <?php require_once "includes/head.php";?>
</head>

<body>

<?php include("includes/header.php"); ?>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Einzahlung
            <small class="text-muted">Show me all your money!</small>
        </h1>
        <form action="./controller/add.php" method="post">
            <div class="input-group">
                <input type="text" class="form-control" min="1" step=".01" aria-label="Euro amount (with dot and two decimal places)">
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                    <span class="input-group-text">0.00</span>
                </div>
            </div>
            <input type="number" name="amount" placeholder="Amount" min="1" step=".01" /> <br>
            <input type="text" name="authSecret" placeholder="authSecret" /> <br>
            <input type="number" name="authCode" placeholder="authCode" /> <br>
            <input type="text" name="userSecret" placeholder="userSecret" /> <br>
            <input type="number" name="userCode" placeholder="userCode" min="0000" max="9999" /> <br>
            <input type="submit" value="Guthaben gutschreiben"> <!-- IDEA: Popup mit aktuellem Kontostand -->
        </form>
    </div>

</main>
<?php include("includes/footer.php"); ?>
</body>
</html>
