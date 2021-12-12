<?php
session_start();
$a="you have logged out";
echo "<script>alert('$a')</script>";
session_destroy();
?>