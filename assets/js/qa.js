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
        allowOutsideClick: () => !Swal.isLoading(),
    });
    if (result.value) {
        if (result.value.success) {
            Swal.fire({
                icon: "success",
                title: "Anfrage erfolgreich!",
                text: `Der Kontostand beträgt: ${result.value.balance}`,
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Ein Fehler ist aufgetreten!",
                text: result.value.message,
            });
        }
    } else {
        Swal.fire({
            icon: "error",
            title: "Ein Fehler ist aufgetreten!",
            text: result.value.message,
        });
    }
});