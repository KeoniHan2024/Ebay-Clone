<?php
    $host = "localhost";
    $user = "customer";
    $password = 'randomUser';
    $db_name = "AuctionDatabase";

    $con = mysqli_connect($host, $user, $password, $db_name);
    if(mysqli_connect_errno()) {
        die("Failed to connect with MySQL: ". mysqli_connect_error());
    }
?>
