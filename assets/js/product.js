const table = document.querySelector("#product-table");
const tableBody = table.querySelector("tbody");
const add = document.querySelector(".add-btn");
const permissions = ["Teilnehmer*Inn", "Mentor*Inn", "Infodesk Mensch", "Superduper Admin"];

refreshTable();

// TODO: Form validators

function addListener(row) {
    const edit = row.querySelector(".edit-btn");
    const del = row.querySelector(".delete-btn");
    const confirms = row.querySelector(".confirm-btn:not(#confirm-submit-btn)");
    const abort = row.querySelector(".abort-btn:not(#abort-submit-btn)");

    edit.addEventListener("click", evt => {
        const row = evt.target.parentElement.parentElement;
        const d = row.dataset;
        for (let i = 0; i < row.children.length; i++) {
            const child = row.children[i];
            const key = child.dataset.key;
            const value = d[key];
            let val = "";
            switch (key) {
                case "amt":
                    const [crates, bottles] = value.split(";");
                    val = `<input type="number" name="crates" value="${crates}"> Kästen und <input type="number" name="bottles" value="${bottles}"> Flaschen`;
                    break;
                case "permission":
                    val = `
                    <select name="permission" id="permission" class="form-control">
                        <option value="0" ${+value === 0 ? "selected" : ""}>Teilnehmer*Inn</option>
                        <option value="1" ${+value === 1 ? "selected" : ""}>Mentor*Inn</option>
                        <option value="2" ${+value === 2 ? "selected" : ""}>Infodesk Mensch</option>
                        <option value="3" ${+value === 3 ? "selected" : ""}>Superduper Admin</option>
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

    confirms.addEventListener("click", async evt => {
        const row = evt.target.parentElement.parentElement;
        const body = { id: row.dataset.id };
        const inputs = row.querySelectorAll("input");
        const selects = row.querySelectorAll("select");
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
            saSuccess(res.data.title, res.data.text)
            await refreshTable();
        } else {
            saError(res.data.title, res.data.text);
        }
    });

    abort.addEventListener("click", evt => {
        const row = evt.target.parentElement.parentElement;
        refreshRow(row);
    });

    del.addEventListener("click", async evt => {
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
                await refreshTable();
            } else {
                saError(result.value.data.title, result.value.data.text)
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            saError("Abgebrochen!", "Das Produkt wurde nicht gelöscht!");
        }
    });
}

async function refreshTable() {
    const resp = await fetch("controller/product.php", {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    });
    const res = await resp.json();
    if (res.success) {
        const rows = res.data.rows;
        clearTable();
        for (let row of rows) {
            tableBody.appendChild(createRow(row));
        }
    } else {
        saError("AHHHH!!", "Tabelle konnte nicht geupdated werden!");
    }
}

function clearTable() {
    const rows = tableBody.querySelectorAll("tr");
    rows.forEach(row => tableBody.removeChild(row));
}

function createRow(rowData) {
    const row = document.createElement("tr");
    refreshRow(row, rowData);
    return row;
}

function refreshRow(row, rowData) {
    row.querySelectorAll("td").forEach(td => row.removeChild(td));
    if (!rowData) rowData = row.dataset;
    row.dataset.id = rowData.id;
    row.dataset.name = rowData.name;
    row.dataset.price = rowData.price;
    row.dataset.permission = rowData.permission;
    let amtCol;
    if (rowData.amount) {
        const amt = Math.floor(rowData.amount);
        const btls = (rowData.amount % 1) * rowData.bottles_per_crate;
        row.dataset.amt = `${amt};${btls}`;
        amtCol = `${amt} Kästen und ${btls} Flaschen`;
        row.dataset.bpc = rowData.bottles_per_crate;
    } else {
        row.dataset.amt = rowData.amt;
        const s = rowData.amt.split(";");
        amtCol = `${s[0]} Kästen und ${s[1]} Flaschen`;
        row.dataset.bpc = rowData.bpc;
    }
    row.append(
        createTD(rowData.name, "name"),
        createTD(`${rowData.price}€`, "price"),
        createTD(amtCol, "amt"),
        createTD(rowData.bottles_per_crate || rowData.bpc, "bpc"),
        createTD(permissions[+rowData.permission], "permission"),
    );
    row.innerHTML += `
        <td data-key='edit-confirm'>
            <img src='assets/icons/edit.svg' alt='Edit' class='edit-btn' title='Bearbeiten'>
            <img src='assets/icons/check.svg' alt='Confirm' class='confirm-btn' title='Bestätigen' style='display: none'>
        </td>
        <td data-key='delete-abort'>
            <img src='assets/icons/x.svg' alt='Delete' class='delete-btn' title='Löschen'>
            <img src='assets/icons/x.svg' alt='Abort' class='abort-btn' title='Abbrechen' style='display: none;'>
        </td>
    `;
    addListener(row);
}

function createTD(value, key) {
    const td = document.createElement("td");
    td.textContent = value;
    td.dataset.key = key;
    return td;
}

add.addEventListener("click", () => {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td><input type="text" name="name" placeholder="Name" required></td>
        <td><input type="number" name="price" value="0.00" min="0" placeholder="Preis" required></td>
        <td><input type="number" name="crates" value="0" min="0" required> Kästen und <input type="number" name="bottles" value="0" min="0" required> Flaschen</td>
        <td><input type="number" name="bpc" value="0" min="1" placeholder="Flaschen pro Kasten" required></td>
        <td>
            <select name="permission" id="permission" class="form-control" required>
                <option value="0" selected>Teilnehmer*Inn</option>
                <option value="1">Mentor*Inn</option>
                <option value="2">Infodesk Mensch</option>
                <option value="3">Superduper Admin</option>
            </select>
        </td>
        <td><img src='assets/icons/check.svg' alt='Submit' class="confirm-btn" id='submit-add-btn' title='Hinzufügen'></td>
        <td><img src='assets/icons/x.svg' alt='Abort' class="abort-btn" id='abort-add-btn' title='Abbrechen'></td>
    `;

    tableBody.insertAdjacentElement("beforeend", row);

    document.getElementById("submit-add-btn").addEventListener("click", async e => {
        const row = e.target.parentElement.parentElement;
        const inputs = row.querySelectorAll("input");
        const selects = row.querySelectorAll("select");
        const body = {};
        inputs.forEach(input => {
            if (input.type !== "submit") body[input.name] = input.value
        });
        selects.forEach(select => body[select.name] = select.options[select.selectedIndex].value);
        const resp = await fetch("controller/product.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body),
        });
        const res = await resp.json();
        if (res.success) {
            saSuccess(res.data.title);
            await refreshTable();
        } else {
            saError(res.data.title, res.data.text);
        }
    })

    document.getElementById("abort-add-btn").addEventListener("click", refreshTable);
});