<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sweetalert2.js"</script>
<script>
    const quickBalanceForm = document.getElementById("quick-balance");
    if (quickBalanceForm) quickBalanceForm.addEventListener('submit', async e => {
        e.preventDefault();
        const secret = document.getElementById("qa-qr").value;
        const resp = await fetch("controller/quickAccess.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({secret}),
        });
        const res = await resp.json();
        if (res.success) alert("Guthaben: " + res.balance);
        else console.log(res.message);
    });
</script>