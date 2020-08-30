<?php
session_start();
require_once "db/dbconnector.php";
require_once "db/dbController.php";
if (dbController::isSetup($pdo)) :
    header("Location: index.php");
else :
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
        <h1>Setup
            <small class="text-muted">Den Service gibt's <b>noch</b> nicht!</small>
        </h1>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="controller/setup.php" method="post" class="default-form">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <label for="balance" class="input-group-text">Initialer Kassenstand</label>
                        </div>
                        <input type="number" name="balance" id="balance" class="form-control" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <label for="authSecret" class="input-group-text">Admin QR</label>
                        </div>
                        <input name="authSecret" id="authSecret" class="form-control" required/>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <label for="authCode" class="input-group-text">Admin QR Pin</label>
                        </div>
                        <input type="number" name="authCode" id="authCode" class="form-control num-pin"
                               maxlength="4" required/>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <input type="submit" value="Setup" class="btn btn-dark" style="width: 100%">
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

</main>
<?php include("includes/footer.php"); ?>
</body>
</html>
<?php
endif;
?>