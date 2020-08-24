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
    <html lang="en">
    <head>
        <title>mate-engine - Getränkeverkauf bei JHULM</title>
        <?php require_once "includes/head.php"; ?>
    </head>

    <body>

    <?php include("includes/header.php"); ?>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>Getränkeverkauf <small class="text-muted">Entgeltung</small></h1>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <form id="balance-form" action="controller/balance.php">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="authSecret" class="input-group-text">Admin QR</label>
                            </div>
                            <input name="authSecret" id="authSecret" class="form-control" required/>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="authCode" class="input-group-text">Admin QR Pin</label>
                            </div>
                            <input type="number" name="authCode" id="authCode" class="form-control num-pin"
                                   maxlength="4" required/>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="userSecret" class="input-group-text">User QR</label>
                            </div>
                            <input name="userSecret" id="userSecret" class="form-control" required/>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <label for="userCode" class="input-group-text">User QR Pin</label>
                            </div>
                            <input type="number" name="userCode" id="userCode" class="form-control num-pin"
                                   required/>
                        </div>
                        <div class="input-group input-group-sm mb-3" style="display: none">
                            <div class="input-group-prepend">
                                <label for="balance" class="input-group-text">Gutenhaben</label>
                            </div>
                            <input type="number" name="balance" id="balance" class="form-control" disabled/>
                            <div class="input-group-append">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <input type="submit" value="Guthaben abfragen" class="btn btn-dark" style="width: 100%">
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
    <script>
        const form = document.getElementById("balance-form");

        form.addEventListener("submit", async e => {
            e.preventDefault();

            const authSecret = document.getElementById("authSecret");
            const authCode = document.getElementById("authCode");
            const userSecret = document.getElementById("userSecret");
            const userCode = document.getElementById("userCode");
            const balance = document.getElementById("balance");

            const data = {
                authSecret: authSecret.value,
                authCode: authCode.value,
                userSecret: userSecret.value,
                userCode: userCode.value,
                balance: balance.value,
            };

            let cnfirm = true;
            if (form.action.endsWith("account.php")) cnfirm = confirm(`Guthaben ${balance.value} ausgezahlt?`);
            if (cnfirm) {
                const resp = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                });
                const res = await resp.json();
                if (!res.success) {
                    // TODO: Error handling
                    alert(res.message);
                    return;
                }

                if (form.action.endsWith("balance.php")) {
                    balance.parentElement.style.display = "flex";
                    balance.value = res.balance;

                    authSecret.disabled = true;
                    authCode.disabled = true;
                    userSecret.disabled = true;
                    userCode.disabled = true;

                    form.action = "controller/emptyaccount.php";
                    document.querySelector("input[type=submit]").value = "Konto leeren";
                } else {
                    window.location.replace("index.php");
                }
            }
        });
    </script>
    </body>
    </html>
<?php
endif;
?>