<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="shopping-cart">
        <h2>Shopping Cart</h2>
        <hr>
        <h3 style="text-align: center;">Order Summary</h3>
        <div class="order-summary" style="display: flex;">
            <div class="product-items">
                <?php
                // Start the session
                session_start();

                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "agriculture_management";

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $database);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Retrieve username from session
                $username = $_SESSION['username'];

                // Query to retrieve cart items for the current user
                $cart_query = "SELECT * FROM cart WHERE username = '$username'";
                $cart_result = mysqli_query($conn, $cart_query);

                // Check if cart items exist
                if(mysqli_num_rows($cart_result) > 0) {
                    // Loop through each cart item
                    while($cart_row = mysqli_fetch_assoc($cart_result)) {
                        // Retrieve product details for each cart item
                        $product_id = $cart_row['product_id'];
                        $product_query = "SELECT * FROM product WHERE id = $product_id";
                        $product_result = mysqli_query($conn, $product_query);

                        // Check if product exists
                        if(mysqli_num_rows($product_result) > 0) {
                            $product = mysqli_fetch_assoc($product_result);

                            // Display product details
                            echo '<div class="product">';
                            echo '<img src="' . $product['image_link'] . '" alt="' . $product['id'] . '">';
                            echo '<div class="info">';
                            // echo '<div class="product-name-display">';
                            // echo '<h3>Product name</h3><p>' . $product['name'] . '</p>';
                            echo '</div>';
                            echo '<div class="quantity">';
                            echo 'Quantity:';
                            echo '<button class="decrement" style="border-radius: 5px;">-</button>';
                            echo '<input type="text" value="1">';
                            echo '<button class="increment" style="border-radius: 5px;">+</button>';
                            echo '</div>';
                            echo '<div class="product-name-display">';
                            echo '<h3>PRICE</h3><p class="price">€' . $product['price'] . '</p>';
                            echo '</div>';
                            echo '<div class="product-name-display">';
                            echo '<h3>TOTAL</h3><p class="total-price">€' . $product['price'] . '</p>'; // Initial total price
                            echo '</div>';
                            echo '<button class="remove-btn" data-product-id="' . $product['id'] . '">Remove</button>'; // Add data-product-id attribute
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p>Your cart is empty.</p>';
                }

                // Close connection
                mysqli_close($conn);
            ?>


            </div>
        </div>
    </div>

    <script>
        // JavaScript for quantity adjustment and item removal
        document.querySelectorAll('.product').forEach(item => {
            const incrementBtn = item.querySelector('.increment');
            const decrementBtn = item.querySelector('.decrement');
            const quantityInput = item.querySelector('input');
            const priceElement = item.querySelector('.price');
            const totalPriceElement = item.querySelector('.total-price');
            const removeBtn = item.querySelector('.remove-btn');

            // Calculate total price based on quantity and update total price element
            const updateTotalPrice = () => {
                const price = parseFloat(priceElement.textContent.replace('€', ''));
                const quantity = parseInt(quantityInput.value);
                const totalPrice = price * quantity;
                totalPriceElement.textContent = '€' + totalPrice.toFixed(2);
            };

            // Event listener for increment button
            incrementBtn.addEventListener('click', () => {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateTotalPrice();
            });

            // Event listener for decrement button
            decrementBtn.addEventListener('click', () => {
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    updateTotalPrice();
                }
            });

            // Event listener for remove button
            removeBtn.addEventListener('click', () => {
                const productId = removeBtn.getAttribute('data-product-id');
                // Send AJAX request to remove the item from the cart
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'remove_from_cart.php?product_id=' + productId, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Reload the page to reflect changes
                        location.reload();
                    }
                };
                xhr.send();
            });

            // Update total price when quantity input changes
            quantityInput.addEventListener('change', () => {
                updateTotalPrice();
            });
        });
    </script>
</body>
</html>
