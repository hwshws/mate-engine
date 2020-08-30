const forms = document.querySelectorAll(".default-form");

forms.forEach(form => {
    form.addEventListener("submit", async evt => {
        evt.preventDefault();
        const body = {};
        const inputs = form.querySelectorAll("input");
        const selects = form.querySelectorAll("select");

        // TODO: Input field validators and errors
        inputs.forEach(input => {
            if (input.type !== "submit") body[input.name] = input.value
        });
        selects.forEach(select => body[select.name] = select.options[select.selectedIndex].value);
        const resp = await fetch(form.action, {
            method: form.method.toUpperCase(),
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(body),
        });

        const res = await resp.json();
        if (res.success) {
            window[form.dataset.success]();
        } else {
            window[form.dataset.error](res.message);
        }
    });
});

function saError(title, text) {
    Swal.fire({
        icon: "error",
        title, text,
        showCloseButton: true,
    });
}

function saSuccess(title, text) {
    Swal.fire({
        icon: "success",
        title, text,
        showCloseButton: true,
    });
}

function loginSuccess() {
    window.location.replace("admin.php");
}

function loginError(message) {
    saError("Login Fehler!", message);
}

function depositSuccess() {
    saSuccess("Guthaben gutgeschrieben!")
}

function depositError(message) {
    saError("Guthaben konnte nicht gutgeschrieben werden!", message);
}
