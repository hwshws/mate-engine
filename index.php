<?php
session_start();

if ($_SESSION["isLoggedIn"]) :
    if ($_SESSION["isAdmin"]) header("Location: admin.php");
    else header("Location: user.php");
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
            <h1>Login</h1>
            <form method="post" action="controller/login.php">
                <input type="text" name="secret" placeholder="Secret"><br>
                <input type="text" name="code" placeholder="Code"><br>
                <input type="submit" value="submit">
            </form>
        </div>

    </main>
    <?php include("includes/footer.php"); ?>
    </body>
    </html>
<?php
endif;
?>