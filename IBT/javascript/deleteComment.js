function deleteComment(commentId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/delete_comment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.querySelector("button[data-id='" + commentId + "']").parentElement.remove();
                    } else {
                        console.error("Error: " + response.error);
                    }
                } catch (e) {
                    console.error("Invalid JSON response: " + xhr.responseText);
                }
            } else {
                console.error("Error: " + xhr.status);
            }
        }
    };
    xhr.send("id=" + encodeURIComponent(commentId));
}