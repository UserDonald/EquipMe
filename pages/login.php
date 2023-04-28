<?php
session_start();
if (isset($_SESSION['email'])){
    header("Location: https://cgi.luddy.indiana.edu/~djnash/index.php");
    exit();
};

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $error = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <link rel="stylesheet" href="../styles.css">

    <title>EquipMe</title>
</head>

<body>

<!-- Log In -->
<div class="login">
    <div class="login-box">
        <h2>Log In</h2>
        <p>Log in to your account to view your cart and make purchases.</p>
        <form action="../controllers/login-process.php" method="get">
            <div class="login-box--inputs">
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Your email" />
                </div>
            </div>
            
            <button class="btn btn-primary" type="submit">Log In</button>

            <p class="error"><?php echo $error; ?></p>
        </form>
    </div>
</div>

</body>

</html>