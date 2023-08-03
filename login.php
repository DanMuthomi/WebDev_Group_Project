<?php
include 'config.php'; 


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $query_customers = "SELECT * FROM customer WHERE username = '$username' AND password = '$password'";
    $result_customers = mysqli_query($conn, $query_customers);
    $row_customers = mysqli_fetch_assoc($result_customers);

    
    $query_admin = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result_admin = mysqli_query($conn, $query_admin);
    $row_admin = mysqli_fetch_assoc($result_admin);

    if ($row_customers) {
        
        $customerId = $row_customers['id']; 
        session_start();
        $_SESSION['user_id'] = $customerId;

        
        header("Location: customer_page.php");
        exit();
    } elseif ($row_admin) {
        
        $adminId = $row_admin['id']; 
        session_start();
        $_SESSION['user_id'] = $adminId;

        
        header("Location: admin_page.php");
        exit();
    } else {
        $message = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
     <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: var(--bg-color);
        }

        .container1 {
            background: var(--bg-color);
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .registration-form-container {
            text-align: center;
        }

        
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .box {
            width: 100%;
            border-radius: 0.5rem;
            padding: 1.2rem 1.5rem;
            font-size: 1.7rem;
            background: var(--white);
            text-transform: none;
        }

        .box-long{
              width: 100%; 
              border-radius: 0.5rem;
              padding: 1.2rem 1.5rem;
              font-size: 1.7rem;
              background: var(--white);
              text-transform: none;
        }

        .btn {
            display: block;
            width: 100%;
            cursor: pointer;
            border-radius: 0.5rem;
            margin-top: 1rem;
            font-size: 1.7rem;
            padding: 1rem 3rem;
            background: var(--green);
            color: var(--white);
            text-align: center;
            text-transform: uppercase;
        }

        .btn:hover {
            background: var(--black);
        }

        p {
            font-size: 1.5rem;
        }

        p a {
            color: var(--green);
        }
    </style>
</head>
<body>
    <div class="container1">
        <div class="registration-form">
            <h2 style="text-transform: uppercase; font-size: 2.5rem; margin-bottom: 1rem;" >Login</h2>
            <?php
                if (isset($message)) {
                    echo "<p>$message</p>";
                }
            ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" class ="box-long" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" class ="box-long" required>
                </div>
                <input type="submit" name="login" value="Login" class="btn">
                <p>Don't have an account? <a href="index.php">Signup</a></p>
            </form>
        </div>
    </div>
</body>
</html>
