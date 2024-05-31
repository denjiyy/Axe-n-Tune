function checkLoggedIn() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/check_login.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText.trim() === "not_logged_in") {
                window.location.href = "login.html";
            }
        }
    };
    xhr.send();
}

window.onload = checkLoggedIn;