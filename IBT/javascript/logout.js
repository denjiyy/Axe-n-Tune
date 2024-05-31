document.addEventListener('DOMContentLoaded', function() {
    var logoutButton = document.getElementById('logout');

    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            window.location.href = 'php/logout.php';
        });
    }
});