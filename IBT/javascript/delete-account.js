document.addEventListener('DOMContentLoaded', function() {
    var deleteButton = document.getElementById('delete');

    if (deleteButton) {
        deleteButton.addEventListener('click', function(event) {
            event.preventDefault();
            var confirmed = window.confirm("Are you sure you want to delete your account? This action cannot be undone.");
            if (confirmed) {
                window.location.href = 'php/delete-account.php';
            } else {
                return;
            }
        });
    }
});