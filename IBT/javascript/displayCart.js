window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/display-cart-items.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.error("Error:", response.error);
            } else {
                var ordersContainer = document.getElementById("order-list");
                response.forEach(function(order) {
                    var orderItem = document.createElement("div");
                    orderItem.classList.add("cart-item");
                    orderItem.innerHTML = "<p>" + order.ProductName + ", $" + order.Price + "</p>";
                    
                    var deleteButton = document.createElement("button");
                    deleteButton.textContent = "Delete";
                    deleteButton.onclick = function() {
                        deleteCartItem(order.UserProductId);
                        orderItem.remove();
                    };
                    orderItem.appendChild(deleteButton);

                    ordersContainer.appendChild(orderItem);
                });
            }
        }
    };
    xhr.send();
};

function deleteCartItem(product_id) {
    if (confirm("Are you sure you want to delete this item?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "php/delete-cart-item.php?product_id=" + product_id, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    console.error("Error:", response.error);
                } else {
                    alert("Item deleted successfully.");
                }
            }
        };
        xhr.send();
    }
}