<?php
function verify($customerNumber,$pass){
 // require_once('../sql/connect.php');
  $conn = connect();
  $ok = false;
    $query = "SELECT count(customerNumber) FROM customers WHERE customerNumber='".$customerNumber."' AND contactLastName='".$pass."';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $exist = $stmt->fetchColumn();
  if($exist == 1){
    $ok = true;
  } 
  $conn = null;
  return $ok;
}
