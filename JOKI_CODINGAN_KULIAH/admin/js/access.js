document.addEventListener('DOMContentLoaded', function() {
    const loginButton = document.getElementById("login");
    console.log(loginButton);  // Cek apakah elemen ditemukan
    if (loginButton) {
        loginButton.addEventListener("click", function(event) {
            event.preventDefault();  // Menangani klik untuk mencegah pengiriman form
        });
    } else {
        console.error("Element with ID 'login' not found");
    }
});
