const edit = document.querySelectorAll(".edit-btn");
const del = document.querySelectorAll(".delete-btn");
const confirms = document.querySelectorAll(".confirm-btn");
const abort = document.querySelectorAll(".abort-btn");
const add = document.querySelector(".add-btn");

edit.on("click", evt => {
    // TODO: Convert td to form inputs for further editing
    // TODO: Improve the hell out of this
    const row = evt.target.parentElement.parentElement;
    const d = row.dataset;
    for (let i = 0; i < row.children.length; i++) {
        const child = row.children[i];
        // if (i >= row.children.length - 2) continue;
        const key = child.dataset.key;
        const value = d[key];
        let val = "";
        switch (key) {
            case "amt":
                const [crates, bottles] = value.split(";");
                console.log(crates, bottles, value);
                val = `<input type="number" name="crates" value="${crates}"> Kästen und <input type="number" name="bottles" value="${bottles}"> Flaschen`;
                break;
            case "permission":
                // TODO: Set selected via permission key
                val = `
                    <select name="permission" id="permission" class="form-control" required>
                        <option value="0">Teilnehmer*Inn</option>
                        <option value="1" selected>Mentor*Inn</option>
                        <option value="2">Infodesk Mensch</option>
                        <option value="3">Superduper Admin</option>
                    </select>`
                break;
            case "edit-confirm":
                child.children[0].style.display = 'none';
                child.children[1].style.display = 'block';
                continue;
            case "delete-abort":
                child.children[0].style.display = 'none';
                child.children[1].style.display = 'block';
                continue;
            default:
                const type = key === "name" ? "text" : "number";
                val = `<input type='${type}' value='${value}' name="${key}">`;
                break;
        }
        child.innerHTML = val;
    }
});

confirms.on("click", async evt => {
    const row = evt.target.parentElement.parentElement;
    const body = { id: row.dataset.id };
    const inputs = row.querySelectorAll("input");
    const selects = row.querySelectorAll("select");
    // TODO: Form validators
    inputs.forEach(input => {
        if (input.type !== "submit") body[input.name] = input.value
    });
    selects.forEach(select => body[select.name] = select.options[select.selectedIndex].value);
    const resp = await fetch("controller/product.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body),
    });

    const res = await resp.json();
    if (res.success) {
        saSuccess(res.data.title, res.data.text);
        refreshTable();
        // TODO: Reset row
    } else {
        saError(res.data.title, res.data.text);
    }
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
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ pid: row.dataset.id }),
            });
            return await resp.json();
        },
    });
    if (result.value) {
        if (result.value.success) {
            saSuccess(result.value.data.title);
            refreshTable();
        } else {
            saError(result.value.data.title, result.value.data.text)
        }
    } else if (result.dismiss === Swal.DismissReason.cancel) {
        saError("Abgebrochen!", "Das Produkt wurde nicht gelöscht!");
    }
});

add.addEventListener("click", evt => {
    // TODO: Open add form and POST
    refreshTable();
});

function refreshTable() {

}