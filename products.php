<?php
session_start();
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
                    <th>Restliche Getränke</th>
                    <th>Flaschen pro Kasten</th>
                    <th>Ausgabeberechtigung</th>
                </tr>

                <?php
                // TODO: Product editor
                $permDict = ["Teilnehmer*Inn", "Mentor*Inn", "Infodesk Mensch", "Superduper Admin"];
                foreach (dbController::getProducts($pdo) as $product) {
                    $amt = $product["amount"];
                    $bpc = $product["bottles_per_crate"];
                    ?>
                    <tr data-id="<?php echo $product["id"] ?>">
                        <td><?php echo $product["name"] ?></td>
                        <td><?php echo $product["price"] . "€" ?></td>
                        <td>
                            <span style="cursor: help" title="<?php echo "à " . $bpc . " Flaschen" ?>">
                                <?php echo (int)$amt ?> Kästen und <?php echo (int)(fmod($amt, 1) * $bpc) ?> Flaschen
                            </span>
                        </td>
                        <td><?php echo $bpc ?></td>
                        <td><?php echo $permDict[(int)$product["permission"]] ?></td>
                        <td><img src="assets/icons/edit.svg" alt="Edit" class="edit-btn"></td>
                        <td><img src="assets/icons/x.svg" alt="Edit" class="delete-btn"></td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    <script src="assets/js/product.js"></script>
    </body>

    </html>
<?php
endif;
?>