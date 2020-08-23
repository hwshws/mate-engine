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
            <h1>Getränkeverkauf <small class="text-muted">Benutzeranlage</small></h1>
            <form action="./controller/add.php" method="post">
                <input type="number" name="amount" placeholder="initialAmount" min="1" /> <br>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend" >
                        <span class="input-group-text" id="inputGroup-sizing-sm">initialAmount</span>
                    </div>
                    <input type="number" min="1" class="form-control"  name="amount" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div><br>
                <input type="text" name="authSecret" placeholder="authSecret" /> <br>
                <input type="number" name="authCode" placeholder="authCode" /> <br>
                <input type="text" name="userSecret" placeholder="userSecret" /> <br>
                <input type="number" name="userCode" placeholder="userCode" min="0000" max="9999" /> <br>
                <input type="number" name="userCodeDoubleCheck" placeholder="userCodeDoubleCheck" min="0000" max="9999" /> <br>
                <input type="number" name="permission" placeholder="permission" min="0" max="3"/> <br> <!-- // TODO: Überlegen, welche Premissions für wen... > DOKU -->
                <input type="submit" value="Nutzer anlegen">
            </form>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    </body>
    </html>
<?php
endif;
?>