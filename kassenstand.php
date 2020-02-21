    <!doctype html>
    <html lang="de">
      <head>
          <title>mate-engine - Getränkeverkauf bei JHULM</title>
          <?php require_once "includes/head.php";?>
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
