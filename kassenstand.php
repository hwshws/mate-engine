    <!doctype html>
    <html lang="de">
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
        <?php error_reporting(E_ALL); ?>
        <?php include("header.php");?>
        <main role="main" class="container">

      
          <div class="starter-template">
            <h1>Getränkeverkauf <small class="text-muted">Neu, jetzt noch besser!</small></h1>
            
            <?php
          $abfrage = $_POST["qr"];
          $con=mysqli_connect("localhost","mate","mate","mate");
            // Check connection
            if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $result = mysqli_query($con,"SELECT `vorname`,`nachname`, guthaben FROM `user` WHERE secret = '$abfrage'"); 

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

    mysqli_close($con);
    ?>
     
          </div>

        </main>
        <?php include ("footer.php");  ?>
      </body>
    </html>
