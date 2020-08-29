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