<!doctype html>
<html lang="de">
<head>
    <title>mate-engine - Getränkeverkauf bei JHULM - Userbackend</title>
    <?php require_once "includes/head.php"; ?>
</head>

<body>

<?php
include("includes/header.php");
include("utility/User.php");
require 'utility/Pretix.php';
// $u = new User("qwertz");
// var_dump($u);
?>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Getränkeverkauf <small class="text-muted">Neu, jetzt noch besser!</small></h1>
        <p class="lead">Finde heraus, wie viel Geld noch auf deinem Konto ist.</p>
        <a class="btn btn-primary btn-lg btn-block" href="kassenstand.php" role="button">Abrufen Kontostand (auch oben
            rechts)</a>
     

    </div>

    <?php
        Pretix::fetchPretixUsers();
    ?>

</main>
<?php include("includes/footer.php"); ?>
</body>
</html>