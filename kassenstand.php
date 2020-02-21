    <!doctype html>
    <html lang="de">
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <meta name="description" content="mate-engine - Getränkeverkauf bei JHULM">
          <meta name="author" content="hwshws">
          <link rel="icon" href="https://jugendhackt.org/wp-content/themes/jh-lauch-theme/images/favicon/favicon.ico">

          <title>mate-engine - Getränkeverkauf bei JHULM</title>


          <!-- Bootstrap core CSS -->
          <link href="assets/css/bootstrap.css" rel="stylesheet">

          <!-- Custom styles for this template -->
          <link href="assets/css/app.css" rel="stylesheet">
      </head>

      <body>
        <?php error_reporting(E_ALL); ?>
        <?php include("includes/header.php");?>
        <main role="main" class="container">

      
          <div class="starter-template">
            <h1>Getränk mate-everkauf <small class="text-muted">Neu, jetzt noch besser!</small></h1>

    echo "<table class='table'>
    <tr>
    <th>Vorname</th>
    <th>Nachname</th>
    <th>Guthaben</th>
    </tr>";

    while($row = mysqli_fetch_array($result))
    {
    echo "<tr>";
    echo "<td>" . $row['vorname'] . "</td>";
    echo "<td>" . $row['nachname'] . "</td>";
    echo "<td>" . $row['guthaben'] . "</td>";
    echo "</tr>";
    }
    echo "</table>";

    ?>
     
          </div>

        </main>
        <?php include ("includes/footer.php");  ?>
      </body>
    </html>
