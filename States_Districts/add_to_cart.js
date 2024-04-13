// add_to_cart.js

// Get all elements with class 'add-to-cart'
var addToCartButtons = document.querySelectorAll('.add-to-cart');

// Loop through each button and attach a click event listener
addToCartButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        // Get the product ID from the data-productId attribute
        var productId = this.getAttribute('data-productId');

        // Send an AJAX request to the PHP file to add the product to the cart
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Once the request is successful, change the button text to 'Added to Cart'
                    button.textContent = 'Added to Cart';
                    button.disabled = true; // Disable the button after adding to cart
                } else {
                    // Handle any errors here
                    console.error('Error:', xhr.statusText);
                }
            }
        };
        
        // Prepare the data to be sent in the request body
        var data = 'productId=' + encodeURIComponent(productId);
        
        // Send the request
        xhr.send(data);
    });
});
