<?php
session_start();
session_unset();
session_destroy();
header("Location: https://cgi.luddy.indiana.edu/~djnash/index.php");
?>