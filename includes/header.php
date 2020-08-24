<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">mate-engine</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <form action="kassenstand.php" method="post" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" name="qr" placeholder="QR scannen" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Kontostand abrufen</button>
        </form>
        <?php
        if ($_SESSION["isLoggedIn"]) {
            ?>
            <form action="logout.php">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
            </form>
            <?php
        }
        ?>
    </div>
</nav>
<?php error_reporting(E_ALL); ?>