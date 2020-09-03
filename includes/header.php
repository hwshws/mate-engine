<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
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
            <?php
            if ($_SESSION["isAdmin"]) {
                ?>
                <button class="btn btn-outline-success my-2 my-sm-0" id="quick-access-button">Kontostand abrufen
                </button>
                <?php
            }
            if ($_SESSION["isLoggedIn"]) {
                ?>
                <a href="logout.php" class="btn btn-outline-danger my-2 my-sm-0">Logout</a>
                <?php
            }
            ?>
        </div>
    </nav>
<?php error_reporting(E_ALL); ?>