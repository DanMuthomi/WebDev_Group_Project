<?php

if (isset($_POST['register'])) {
    @include 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    

    if (empty($username) || empty($password) || empty($user_type)) {
        echo '<span class="message">Please fill out all fields.</span>';
    } else {
        $insert_query = "INSERT INTO $user_type (username, password) VALUES ('$username', '$password')";
        $result = mysqli_query($conn, $insert_query);

        if ($result) {
            // Registration successful, redirect to the respective page based on user type
            if ($user_type === 'customer') {
                header("Location: customer_page.php");
                exit();
            } else if ($user_type === 'admin') {
                header("Location: admin_page.php");
                exit();
            }
        } else {
            echo '<span class="message">Failed to register. Please try again later.</span>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h3 style="text-transform: uppercase; font-size: 2.5rem; margin-bottom: 1rem;" >Registration Form</h3>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" class="box-long" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" class="box-long" required>
                </div>
                <div class="form-group">
                    <label for="user_type">User Type:</label>
                    <select name="user_type" class="box" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <input type="submit" class="btn" name="register" value="Register">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>


