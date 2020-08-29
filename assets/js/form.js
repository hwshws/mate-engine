const forms = document.querySelectorAll(".default-form");

forms.forEach(form => {
    form.addEventListener("submit", async evt => {
        evt.preventDefault();
        const body = {};
        const inputs = form.querySelectorAll("input");
        const selects = form.querySelectorAll("select");

        // TODO: Input field validators and errors
        // TODO: Test
        inputs.forEach(input => body[input.name] = input.value);
        selects.forEach(select => body[select.name] = select.options[select.selectedIndex].value);

        const resp = await fetch(form.action, {
            method: form.method.toUpperCase(),
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(body),
        });

        // TODO: Unified response type
        const res = await resp.json();
        if (res.success) {
            // TODO: Handle success
        } else {
            // TODO: Handle error
        }
    });
});