document.addEventListener("DOMContentLoaded", function() {
    var addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productId = button.dataset.productId;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', './add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            button.textContent = 'Added to Cart';
                            button.disabled = true;
                        } else {
                            console.error('Error adding product to cart:', response.error);
                        }
                    } else {
                        console.error('Error adding product to cart');
                    }
                }
            };
            xhr.send('productId=' + encodeURIComponent(productId));
        });
    });
});
