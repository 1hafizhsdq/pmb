function successMsg(msg){
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "center",
        backgroundColor: "#4fbe87",
    }).showToast()
}

function errorMsg(msg){
    Toastify({
        text: msg,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "center",
        backgroundColor: "#be4f4f",
    }).showToast()
}