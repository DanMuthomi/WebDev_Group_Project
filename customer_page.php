<?php
@ include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Display products table -->
        <div class="product-display">
            <h3 style="font-size: 30px; text-align: center;">WELCOME TO OUR RESTAURANT</h3>
            <table class="product-display-table">
                <thead>

                    <tr>
                        <th colspan="4"> FOOD MENU</th>

                    </tr>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                $select = mysqli_query($conn, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($select)) { ?>
                    <tr>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>Kes<?php echo $row['price']; ?>/-</td>
                        <td>
                            <!-- Add to Cart button -->
                            <button class="btn add-to-cart-btn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>" data-price="<?php echo $row['price']; ?>">Add to Cart</button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Cart display -->
        <div class="cart-display">
            <h4 style="font-size: 40px; text-align: center;">Your Cart</h4>
            <table class="cart-display-table">
                <thead>

                    <tr>
                        <th colspan="3">RECEIPT</th>
                    </tr>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Cart items will be dynamically added here -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Total Price:</td>
                        <td id="total-price">Kes 0/-</td>
                    </tr>
                </tfoot>
            </table>
             <button class="btn" id="print-btn" style="width: 50%">Print Receipt</button>
        </div>
       <a href="logout.php" style="width: 50%;" class="btn">Logout</a>


    </div>

    
    <script>
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        const cartItemsContainer = document.getElementById('cart-items');
        const totalPriceElement = document.getElementById('total-price');

        let cartItems = {};

        
        addToCartButtons.forEach((button) => {
            button.addEventListener('click', addToCart);
        });

        function addToCart(event) {
            const id = event.target.dataset.id;
            const name = event.target.dataset.name;
            const price = event.target.dataset.price;

            if (!cartItems[id]) {
                cartItems[id] = {
                    name: name,
                    quantity: 1,
                    price: price,
                };
            } else {
                cartItems[id].quantity += 1;
            }

            updateCartDisplay();
        }

        function updateCartDisplay() {
            cartItemsContainer.innerHTML = '';
            let totalPrice = 0;

            for (const id in cartItems) {
                const { name, quantity, price } = cartItems[id];
                totalPrice += quantity * price;

                const row = `
                    <tr>
                        <td>${name}</td>
                        <td>${quantity}</td>
                        <td>Kes${price * quantity}/-</td>
                    </tr>
                `;
                cartItemsContainer.innerHTML += row;
            }

            totalPriceElement.textContent = `Kes ${totalPrice}/-`;
        }
    </script>
   <script>
  // Function to print the cart receipt
  function printReceipt() {
    
    document.getElementById('print-btn').style.display = 'none';

    
    window.print();

    
    document.getElementById('print-btn').style.display = 'block';
  }

  
  document.getElementById('print-btn').addEventListener('click', printReceipt);
</script>



</body>
</html>
