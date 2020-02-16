<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="mate-engine - Getränkeverkauf bei JHULM">
    <meta name="author" content="hwshws">
    <link rel="icon" href="https://jugendhackt.org/wp-content/themes/jh-lauch-theme/images/favicon/favicon.ico">

    <title>mate-engine - Getränkeverkauf bei JHULM</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
  </head>

  <body>

    <?php 
include("header.php");
    ?>

    <main role="main" class="container">

      <div class="starter-template">
        <h1>Getränkeverkauf <small class="text-muted">Neu, jetzt noch besser!</small></h1>
        <p class="lead">Teilnehmis und Mentoris haben Durst. Dein Job ist, dem Abhilfe zu schaffen.</p>
        <a class="btn btn-primary btn-lg btn-block" href="einzahlung.php" role="button">Einzahlung</a>
        <a class="btn btn-primary btn-lg btn-block" href="ausgabe.php" role="button">Ausgabe</a>
        <a class="btn btn-primary btn-lg btn-block" href="kassenstand.php" role="button">Abrufen Kontostand (auch oben rechts)</a>
        <a class="btn btn-danger btn-lg btn-block disabled" href="#" role="button">Leerstandmeldung</a>
        <a class="btn btn-danger btn-lg btn-block disabled" href="#" role="button">Konto leeren</a>
        

      </div>

    </main>
    <?php include ("footer.php");  ?>
  </body>
</html>
