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
            <h1>Getränkeverkauf <small class="text-muted">Benutzeranlage</small></h1>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <form action="controller/add.php" method="post">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="amount" class="input-group-text">Startguthaben</label>
                            </div>
                            <input type="number" min="0" max="99.99" step="0.01" class="form-control" name="amount"
                                   id="amount" required/>
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
                            <div class="input-group-prepend">
                                <label for="userSecret" class="input-group-text">User QR</label>
                            </div>
                            <input name="userSecret" id="userSecret" class="form-control" required/>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="userCode" class="input-group-text">User QR Pin</label>
                            </div>
                            <input type="number" name="userCode" id="userCode" class="form-control num-pin" required/>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="userCodeDoubleCheck" class="input-group-text">User QR Pin
                                    Wiederholung</label>
                            </div>
                            <input type="number" name="userCodeDoubleCheck" id="userCodeDoubleCheck"
                                   class="form-control num-pin" required/>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="permission" class="input-group-text">User Rolle</label>
                            </div>
                            <select name="permission" id="permission" class="form-control" required>
                                <option value="0">Teilnehmer*Inn</option>
                                <option value="1">Mentor*Inn</option>
                                <option value="2">Infodesk Mensch</option>
                                <option value="3">Superduper Admin</option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <input type="submit" value="Nutzer anlegen" class="btn btn-dark" style="width: 100%">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    <script src="assets/js/numvalidate.js"></script>
    </body>
    </html>
<?php
endif;
?>