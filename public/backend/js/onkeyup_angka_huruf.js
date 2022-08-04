function angka(e) {
    if (!/^[0-9]+$/.test(e.value)) {
        e.value = e.value.substring(0, e.value.length - 1);
    }
}

function huruf(e) {
    if (!/^[a-z ' A-Z]+$/.test(e.value)) {
        e.value = e.value.substring(0, e.value.length - 1);
    }
}