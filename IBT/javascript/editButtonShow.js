document.getElementById('edit').addEventListener('click', function() {
    var editForm = document.getElementById('edit-form');
    if (editForm.classList.contains('show')) {
        editForm.classList.remove('show');
        setTimeout(function() {
            editForm.style.display = 'none';
        }, 500);
    } else {
        editForm.style.display = 'block';
        setTimeout(function() {
            editForm.classList.add('show');
        }, 10);
    }
});
