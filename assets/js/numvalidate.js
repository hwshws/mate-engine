$("input.num-pin").on("input", (e) => { // TODO: Check on submit
    const input = e.target;
    if (!/[0-9]{4}/.test(input.value)) {
        // TODO: Handle error - probably on submit
    }
})