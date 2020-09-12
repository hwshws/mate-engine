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
            <table>
                <tr>
                    <th>Name</th>
                    <th>Preis</th>
                    <th>Restliche Getränke</th>
                    <th>Flaschen pro Kasten</th>
                    <th>Ausgabeberechtigung</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php
                // TODO: Product editor
                $permDict = ["Teilnehmer*Inn", "Mentor*Inn", "Infodesk Mensch", "Superduper Admin"];
                foreach (dbController::getProducts($pdo) as $product) {
                    $id = $product["id"];
                    $name = $product["name"];
                    $price = $product["price"];
                    $amt = $product["amount"];
                    $iamt = (int)$amt;
                    $bpc = $product["bottles_per_crate"];
                    $leftover = (int)(fmod($amt, 1) * $bpc);
                    $permission = $product["permission"];
                    // TODO: Consider page reload vs js refresh
                    echo "
                        <tr data-id='$id' data-name='$name' data-price='$price' data-amt='$iamt;$leftover' data-bpc='$bpc' data-permission='$permission'>
                            <td data-key='name'>$name</td>
                            <td data-key='price'>$price €</td>
                            <td data-key='amt'>$iamt Kästen und $leftover Flaschen</td>
                            <td data-key='bpc'>$bpc</td>
                            <td data-key='permission'>$permDict[$permission]</td>
                            <td data-key='edit-confirm'>
                                <img src='assets/icons/edit.svg' alt='Edit' class='edit-btn' title='Bearbeiten'>
                                <img src='assets/icons/check.svg' alt='Confirm' class='confirm-btn' title='Bestätigen' style='display: none'>
                            </td>
                            <td data-key='delete-abort'>
                                <img src='assets/icons/x.svg' alt='Delete' class='delete-btn' title='Löschen'>
                                <img src='assets/icons/x.svg' alt='Abort' class='abort-btn' title='Abbrechen' style='display: none;'>
                            </td>
                        </tr>
                    ";
                    ?>
                    <?php
                }
                ?>
                <tr>
                    <!-- TODO: I don't know css KEKW -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><img src="assets/icons/plus-circle.svg" alt="Add" class="add-btn" title="Hinzufügen"></td>
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