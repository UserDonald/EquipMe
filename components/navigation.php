<?php 
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    $email = "";
}

if (isset($_SESSION['is_employee'])) {
    $is_employee = $_SESSION['is_employee'];
} else {
    $is_employee = false;
}

?>

<nav>
    <div class="nav-logo">
        <a href="https://cgi.luddy.indiana.edu/~djnash/index.php"><img src="https://cgi.luddy.indiana.edu/~djnash/assets/logo.svg" alt="EquipMe Logo"></a>
    </div>
    <div class="nav-links">
        <ul>
            <li>About Us</li>
            <li>Rentals</li>
            <li>List Your Gear</li>
            <li>How It Works</li>
        </ul>
    </div>
    <div class="nav-auth">
        <ul>
            <!-- If the user is logged in, display their email and a log out button -->
            <?php if ($email != "") { ?>
                <li><a href="https://cgi.luddy.indiana.edu/~djnash/controllers/logout-process.php">Log Out</a></li>
                <?php if ($is_employee) { ?>
                    <li><a href="https://cgi.luddy.indiana.edu/~djnash/pages/employee-dashboard.php">Employee Dashboard</a></li>
                <?php } ?>
                <li><a class="cart-icon" href="https://cgi.luddy.indiana.edu/~djnash/pages/cart.php"><img src="https://cgi.luddy.indiana.edu/~djnash/assets/cart.svg" alt="Cart Icon"></a></li>
            <?php } else { ?>
                <li><a href="https://cgi.luddy.indiana.edu/~djnash/pages/login.php">Log In</a></li>
                <li><a class="btn btn-primary" href="https://cgi.luddy.indiana.edu/~djnash/pages/signup.php">Sign Up</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>