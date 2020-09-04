NodeList.prototype.on = function (event, handler) {
    this.forEach(node => node.addEventListener(event, handler));
}

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
