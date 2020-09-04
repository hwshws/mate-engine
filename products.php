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
                    <th>Bearbeiten</th>
                    <th>Löschen</th>
                </tr>

                <?php
                // TODO: Product editor
                $permDict = ["Teilnehmer*Inn", "Mentor*Inn", "Infodesk Mensch", "Superduper Admin"];
                foreach (dbController::getProducts($pdo) as $product) {
                    $amt = $product["amount"];
                    $bpc = $product["bottles_per_crate"];
                    // TODO: Consider page reload vs js refresh
                    ?>
                    <tr data-id="<?php echo $product["id"] ?>">
                        <td><?php echo $product["name"] ?></td>
                        <td><?php echo $product["price"] . "€" ?></td>
                        <td><?php echo (int)$amt ?> Kästen und <?php echo (int)(fmod($amt, 1) * $bpc) ?> Flaschen</td>
                        <td><?php echo $bpc ?></td>
                        <td><?php echo $permDict[(int)$product["permission"]] ?></td>
                        <td><img src="assets/icons/edit.svg" alt="Edit" class="edit-btn"></td>
                        <td><img src="assets/icons/x.svg" alt="Delete" class="delete-btn"></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <!-- TODO: I don't know css KEKW -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><img src="assets/icons/plus-circle.svg" alt="Add" class="add-btn"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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