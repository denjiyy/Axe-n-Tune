window.addEventListener('DOMContentLoaded', function () {
    function getUsername() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var username = xhr.responseText.trim();
                    if (username !== '') {
                        var usernameSpan = document.querySelector('.username span');
                        usernameSpan.textContent = username;
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