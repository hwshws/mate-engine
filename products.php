<?php
if (!$_SESSION["isAdmin"]) :
    if ($_SESSION["isLoggedIn"]) header("Location: user.php");
    else header("Location: index.php");
else :
    require_once "db/dbController.php";
    require_once "db/dbconnector.php";
?>
    <!doctype html>
    <html lang="de">

    <head>
        <title>mate-engine - Getränkeverkauf bei JHULM</title>
        <?php require_once "includes/head.php"; ?>
    </head>

    <body>

        <?php include("includes/header.php"); ?>

        <main role="main" class="container">

            <div class="starter-template">
                <h1>Getränkeverkauf <small class="text-muted">Produktinformation</small></h1>
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <th>Preis</th>
                        <th>Restliche volle Kästen</th>
                        <th>Restliche Flaschen</th>
                    </tr>

                    <?php
                    // TODO: Product editor
                    foreach (dbController::getProducts($pdo) as $product) {
                    ?>
                        <tr>
                            <td><?php echo $product["name"] ?></td>
                            <td><?php echo $product["price"] ?></td>
                            <td><?php echo (int)$product["amount"] ?></td>
                            <td><?php echo fmod($product["amount"], 1) * $product["bottles_per_crate"] ?></td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>
            </div>

        </main>
        <?php include("includes/footer.php"); ?>
    </body>

    </html>
<?php
endif;
?>