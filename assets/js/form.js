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
        // TODO: Default via basic sa and better response type => reduce boilerplate
        if (res.success) {
            if (form.dataset.success) window[form.dataset.success](res.data);
            else saSuccess(res.data.title, res.data.text);
        } else {
            if (form.dataset.error) window[form.dataset.error](res.data);
            else saError(res.data.title, res.data.text);
        }
    });
});
// TODO: Consider session checking
// TODO: Form clear on success e.g. redirect

function saSuccess(title, text) {
    Swal.fire({
        icon: "success",
        title, text,
        showCloseButton: true,
    });
}

function saError(title, text) {
    Swal.fire({
        icon: "error",
        title, text,
        showCloseButton: true,
    });
}

function loginSuccess(data) {
    window.location.reload();
}

function setupSuccess(data) {
    Swal.fire({
        icon: "success",
        title: data.title,
        text: data.text,
    }).then((result) => window.location.replace("index.php"));
}