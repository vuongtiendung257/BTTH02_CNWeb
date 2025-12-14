// assets/js/auth.js

function toggleAuth() {
    document.getElementById("authBox").classList.toggle("login");
}

document.addEventListener("DOMContentLoaded", () => {
    const goRegister = document.getElementById("goRegister");

    if (goRegister) {
        goRegister.addEventListener("click", () => {
            document.body.classList.add("switching");
        });
    }
});