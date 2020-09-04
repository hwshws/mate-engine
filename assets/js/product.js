const edit = document.querySelectorAll(".edit-btn");
const del = document.querySelectorAll(".delete-btn");
const add = document.querySelector(".add-btn");

edit.on("click", evt => {
    const row = evt.target.parentElement.parentElement;
    // TODO: Convert td to form inputs for further editing and PUT
});

del.on("click", async evt => {
    const row = evt.target.parentElement.parentElement;
    const result = await Swal.fire({
        title: "Produkt wirklich löschen?",
        text: "Dies kann nicht rückgängig gemacht werden!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Löschen!",
        confirmButtonColor: "#28a745",
        cancelButtonText: "Abbrechen",
        cancelButtonColor: "#dc3545",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            const resp = await fetch("controller/product.php", {
                method: "DELETE",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({pid: row.dataset.id}),
            });
            return await resp.json();
        },
    });
    if (result.value) {
        if (result.value.success) {
            saSuccess(result.value.data.title);
        } else {
            saError(result.value.data.title, result.value.data.text)
        }
    } else if (result.dismiss === Swal.DismissReason.cancel) {
        saError("Abgebrochen!", "Das Produkt wurde nicht gelöscht!");
    }
});

add.addEventListener("click", evt => {
    // TODO: Open add form and POST
});
