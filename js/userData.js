window.onload = function() {
    const userId = localStorage.getItem('usuarioID');
    const userName = localStorage.getItem('usuarioNombre');
    const userSub = localStorage.getItem('usuarioSubscripcion');

    if (userId && userName) {
        console.log("Usuario:", userName, "| ID:", userId, "| Sub:", userSub);
        document.getElementById('username').textContent = userName;
    }
};
