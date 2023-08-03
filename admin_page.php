<?php
@include 'config.php';

$message = array(); // Initialize an empty array to store messages

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Check if the file was uploaded successfully
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder = 'uploaded_img/' . $product_image;

        // Move the uploaded file to the desired location
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
    } else {
        $message[] = 'Error uploading the product image.';
    }

    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'Please fill out all fields.';
    } else {
        $insert = "INSERT INTO products(name, price, image) VALUES('$product_name','$product_price', '$product_image')";
        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            $message[] = 'New product added successfully.';
        } else {
            $message[] = 'Could not add the product.';
        }
    }
};

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($conn, "DELETE FROM products WHERE id = '$id'");
    if ($delete) {
        $message[] = 'Product deleted successfully.';
    } else {
        $message[] = 'Failed to delete product.';
    }
}

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
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>

    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <h3>add a new product</h3>
                <input type="text" placeholder="enter product name" name="product_name" class="box">
                <input type="number" placeholder="enter product price" name="product_price" class="box">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
                <input type="submit" class="btn" name="add_product" value="add product">

                <a href="logout.php" class="btn">Logout</a>
            </form>
        </div>

        <?php
        $select = mysqli_query($conn, "SELECT * FROM products");
        ?>

        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>product image</th>
                        <th>product name</th>
                        <th>product price</th>
                        <th>action</th>
                    </tr>
                </thead>
                <?php while ($row = mysqli_fetch_assoc($select)) { ?>

                    <tr>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>Kes<?php echo $row['price']; ?>/-</td>
                        <td>
                            <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-edit"></i>edit</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-trash"></i>delete</a>
                        </td>
                    </tr>

                <?php } ?>


            </table>
        </div>
    </div>
</body>
</html>
