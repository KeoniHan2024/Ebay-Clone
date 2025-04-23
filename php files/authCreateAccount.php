<?php 

session_start(); 

include "connection.php";
// Checks to see if it was able to get both text box $POSTS if not then goes back
if (isset($_POST['user']) && isset($_POST['pass'])) {

    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }

    $uname = validate($_POST['user']);

    $pass = validate($_POST['pass']);

    if (empty($uname)) {

        header("Location: createAccount.php?error=User Name is required");

        exit();

    }else if(empty($pass)){

        header("Location: createAccount.php?error=Password is required");

        exit();

    }else{
    	// Turns the password to it's hash equivalent then inserts it into the login table in the database
    	
	$pass = hash('ripemd160', $pass);
        $sql = "INSERT INTO login (username, password) VALUES('".$uname."', '".$pass."')";
        $result = mysqli_query($con, $sql);
        header("Location: successCreate.php");

            exit();


    }

}else{

    header("Location: createAccount.php");

    exit();

}
