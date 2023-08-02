<?php
@include 'config.php';

$id = isset($_GET['edit']) ? $_GET['edit'] : '';

$message = array(); // Initialize an empty array to store messages

// Check if the form is submitted for updating the product
if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Check if a new image is uploaded
    if ($_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder = 'uploaded_img/' . $product_image;

        // Move the uploaded file to the desired location
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
    } else {
        // If no new image is uploaded, retrieve the existing image
        $select = mysqli_query($conn, "SELECT image FROM products WHERE id='$id'");
        $row = mysqli_fetch_assoc($select);
        $product_image = $row['image'];
    }

    if (empty($product_name) || empty($product_price)) {
        $message[] = 'Please fill out all fields.';
    } else {
        $update = "UPDATE products SET name='$product_name', price='$product_price', image='$product_image' WHERE id='$id'";
        $upload = mysqli_query($conn, $update);

        if ($upload) {
            $message[] = 'Product updated successfully.';
        } else {
            $message[] = 'Failed to update the product.';
        }
    }
}

// Retrieve the product information from the database
$select = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$row = mysqli_fetch_assoc($select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin update</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>

    <div class="container">
        <div class="admin-product-form-container centered">
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?edit=' . $id; ?>" method="post" enctype="multipart/form-data">
                <h3>update the product</h3>
                <?php if ($row) { ?>
                    <input type="text" placeholder="enter product name" value="<?php echo $row['name']; ?>" name="product_name" class="box">
                    <input type="number" placeholder="enter product price" value="<?php echo $row['price']; ?>" name="product_price" class="box">
                <?php } else { ?>
                    <input type="text" placeholder="enter product name" name="product_name" class="box">
                    <input type="number" placeholder="enter product price" name="product_price" class="box">
                <?php } ?>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="update_product" value="update product">
                <a href="admin_page.php" class="btn">go back</a>
            </form>
        </div>
    </div>
</body>
</html>
