<?php
include "db.php";

$id = $_POST['id'];

$conn->query("
    UPDATE rentals 
    SET status = IF(status='Active','Returned','Active') 
    WHERE id=$id
");

header("Location: rentalhistory.php");
?>