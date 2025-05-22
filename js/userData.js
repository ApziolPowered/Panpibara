window.onload = function() {
    const userId = localStorage.getItem('usuarioID');
    const userName = localStorage.getItem('usuarioNombre');

    if (userId && userName) {
        console.log("Usuario:", userName, "| ID:", userId);
        document.getElementById('username').textContent = userName;
    }
};
