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
            headers: {
                "Content-Type": "application/json",
            },
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

function loginSuccess() {
    window.location.assign("admin.php");
}

function loginError(message) {
    Swal.fire("Login error", message, "error");
}
