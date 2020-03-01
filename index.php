<!doctype html>
<html lang="de">
<head>
    <title>mate-engine - Getränkeverkauf bei JHULM</title>
    <?php require_once "includes/head.php"; ?>
</head>

<body>

<?php
include("includes/header.php");
include("utility/User.php");
//require 'utility/Pretix.php';
// $u = new User("qwertz");
// var_dump($u);
?>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Getränkeverkauf <small class="text-muted">Neu, jetzt noch besser!</small></h1>
        <p class="lead">Teilnehmis und Mentoris haben Durst. Dein Job ist, dem Abhilfe zu schaffen.</p>
        <a class="btn btn-primary btn-lg btn-block" href="einzahlung.php" role="button">Einzahlung</a>
        <a class="btn btn-primary btn-lg btn-block" href="ausgabe.php" role="button">Ausgabe</a>
        <a class="btn btn-primary btn-lg btn-block" href="login.php" role="button">login</a>
        <a class="btn btn-primary btn-lg btn-block" href="kassenstand.php" role="button">Abrufen Kontostand (auch oben
            rechts)</a>
        <a class="btn btn-danger btn-lg btn-block disabled" href="#" role="button">Leerstandmeldung</a>
        <a class="btn btn-danger btn-lg btn-block disabled" href="konto-leeren.php" role="button">Konto leeren</a>


    </div>

    <?php
        Pretix::fetchPretixUsers();
    ?>

</main>
<?php include("includes/footer.php"); ?>
</body>
</html>
