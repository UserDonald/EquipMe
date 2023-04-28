<?php
session_start();
if (!isset($_SESSION['email'])){
    header("Location: https://cgi.luddy.indiana.edu/~djnash/pages/login.php");
    exit();
};

if (!$_SESSION['is_employee']){
    header("Location: https://cgi.luddy.indiana.edu/~djnash/pages/login.php");
    exit();
};

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

    <?php include '../components/navigation.php';?>

    <?php include '../components/states.php';?>

    <?php include '../components/employee-pay.php';?>

    <?php include '../components/orders.php';?>

    <?php include '../components/footer.php';?>

</body>

</html>