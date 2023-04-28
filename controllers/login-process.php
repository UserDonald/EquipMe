<?php

session_start();
$con=mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

if (!$con)
	{ die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

$sql = "SELECT email FROM entity";
$result = mysqli_query($con, $sql);

$emails = array();
while ($row = mysqli_fetch_assoc($result)) {
    $emails[] = $row['email'];
}

if (in_array($_GET['email'], $emails)) {
    $_SESSION['email'] = $_GET['email'];
} else {
    $_SESSION['error'] = "Invalid email address.";
}

$sql2 = "SELECT
    entity.email
FROM
    employee
    JOIN entity ON employee.employee_id = entity.id
WHERE
    entity.email = '{$_SESSION['email']}'";
    
$result2 = mysqli_query($con, $sql2);

if (mysqli_num_rows($result2) > 0) {
    $_SESSION['is_employee'] = true;
} else {
    $_SESSION['is_employee'] = false;
}

header("Location: https://cgi.luddy.indiana.edu/~djnash/pages/login.php");
exit();

?>