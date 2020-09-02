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

    // There probably is a better solution - at least it works
    let req = true;
    let result = undefined;
    if (!form.action.endsWith("balance.php")) req = false;
    if (!req) result = await Swal.fire({
        icon: "question",
        title: "Guthaben auszahlen",
        text: `Guthaben von ${balance.value}€ auszahlen`,
        confirmButtonText: "Guthaben ausgezahlt",
        confirmButtonColor: "28a745",
        showCancelButton: true,
        cancelButtonText: "Abbrechen",
    });

    if (req || result.value) {
        const resp = await fetch(form.action, {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(data),
        });
        const res = await resp.json();
        if (!res.success) {
            return saError(res.data.title, res.data.text);
        }

        if (form.action.endsWith("balance.php")) {
            balance.parentElement.style.display = "flex";
            balance.value = res.balance;

            authSecret.disabled = true;
            authCode.disabled = true;
            userSecret.disabled = true;
            userCode.disabled = true;

            form.action = "controller/emptyAccount.php";
            document.querySelector("input[type=submit]").value = "Konto leeren";
        } else {
            saSuccess("Konto geleert!");
            form.reset();
            balance.parentElement.style.display = "none";
            balance.value = 0;
            authSecret.disabled = false;
            authCode.disabled = false;
            userSecret.disabled = false;
            userCode.disabled = false;
        }
    } else if (result.dismiss === Swal.DismissReason.cancel) {
        saError("Abgebrochen!", "Konto wurde nicht geleert!");
    }
});