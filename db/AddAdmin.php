<?php 
require_once __DIR__ . "/connection.php";
function AddAdmin($name, $email ,$phone,$password , $role ="admin"){
        $conn = dataBase_connect(); // connection database 

        // check email is exists ???
        $stmt = mysqli_prepare($conn, "SELECT Email FROM users WHERE Email=?"); // 
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);




        
        if(mysqli_num_rows($result) > 0) {
            echo "Email already exists"; 
            header('location:addadmins.php');
            exit(); // fucntion == return 0
         }

  $stmt = mysqli_prepare($conn, "INSERT INTO users (Username, Email, pass, Phone, Role) VALUES (?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt,"sssss",$name, $email ,$password ,$phone, $role);
  mysqli_stmt_execute($stmt);
}