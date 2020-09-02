const quickAccessButton = document.getElementById("quick-access-button");
if (quickAccessButton) quickAccessButton.addEventListener('click', async (e) => {
    const result = await Swal.fire({
        title: "QR-Code",
        input: "text",
        inputAttributes: {autocapitalize: "off"},
        showCancelButton: true,
        confirmButtonText: "Kontostand abrufen",
        showLoaderOnConfirm: true,
        preConfirm: async (secret) => {
            const resp = await fetch("controller/quickAccess.php", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({secret}),
            });
            return await resp.json();
        },
    });
    if (result.value) {
        if (result.value.success) {
            saSuccess("Guthaben abgefragt!", `Der Kontostand beträgt: ${result.value.data.balance}`)
        } else {
            saError("Guthaben konnte nicht abgefragt werden!", result.value.data.message);
        }
    } else if (result.dismiss === Swal.DismissReason.cancel) {
        saError("Anfrage abgebrochen!");
    }
});