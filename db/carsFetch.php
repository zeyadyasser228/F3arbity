<?php 
require_once __DIR__ . "/connection.php";

// twa pages add car and car pages 
function getAllCars (){
  $conn = dataBase_connect(); // conncetion database 

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM cars");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}



// index 
function GetCarsWithLimit ($limit){
    $conn = dataBase_connect();

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM cars Limit ?");
        $stmt->bind_param("i", $limit);
 $stmt->execute();
    return $stmt->get_result();
}