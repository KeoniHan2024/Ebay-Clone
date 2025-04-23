<?php 

session_start(); 

include "connection.php";

// Checks to see if both fields were set if not then it redirects
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

        header("Location: index.php?error=User Name is required");

        exit();

    }else if(empty($pass)){

        header("Location: index.php?error=Password is required");

        exit();

    }else{
    	// Turns the entered password into a hash then checks to see if the login username and password match in the login database
	$pass = hash('ripemd160', $pass);

        $sql = "SELECT * FROM login WHERE username='$uname' AND password='$pass'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['username'] == $uname && $row['password'] == $pass) {

		// Sets a cookie that expires in 3 minutes so it's easier to check if cookie expires and works
                echo "Logged in!";
                setcookie("user", $row['username'], time() + 600);
                setcookie("pass", $row['password'], time() + 600);

                $_SESSION['username'] = $row['username'];

                $_SESSION['name'] = $row['username'];


                $ID = mysqli_real_escape_string($con, $_GET['ID']);
                if (!isset($ID) || $ID == "") {
                	header("Location: home.php");
                }
                else {
                	header("Location: bidding.php?ID=".$ID."");
                }

                exit();

            }else{

                header("Location: index.php?error=Incorect User name or password");

                exit();

            }

        }else{

            header("Location: index.php?error=Incorect User name or password");

            exit();

        }

    }

}else{

    header("Location: index.php");

    exit();

}
