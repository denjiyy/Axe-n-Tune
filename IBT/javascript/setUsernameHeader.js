window.addEventListener('DOMContentLoaded', function () {
    function getUsername() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var username = xhr.responseText.trim();
                    if (username !== '') {
                        var signUpLink = document.querySelector('ul#navbar li:nth-child(3) a');
                        signUpLink.textContent = username;
                        signUpLink.href = 'account.html';
                    }
                } else {
                    console.error('Error fetching username');
                }
            }
        };

        xhr.open('GET', 'php/get-username.php', true);
        xhr.send();
    }

    getUsername();
});