<h1>oh HELLO!</h1>
<h2> YOU ARE DOING WELL SIR</h2>
<h2>PAYMENT WENT OK</h2>
<?php
require_once "./db/inserts.php";
// --------------------------------------- calls to inserts to db here --------------------------------------------
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!!!!!!! orders !!!!!!!!!!!!!!!!!!!!!!!!!!
//
$orderNumber = $_COOKIE['orderNumber'];
$orderDate = date('Y-m-d');
$requiredDate = date('Y-m-d');
$shippedDate = null;
$status = 'Shipped';
$comments = null;
$customerNumber = $_COOKIE['user'];
$insertedOrder = insertIntoOrders($orderNumber, $orderDate, $requiredDate, $shippedDate, $status, $comments, $customerNumber);
if ($insertedOrder) {
    echo "<p>OK: table order </p>";
} else {
    echo "<p>ERROR: table order</p>";
}
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!!!!!!! orderDetails !!!!!!!!!!!!!!!!!!!!
//
$orderNumber = $orderNumber;
$products = explode(":", $_COOKIE['productsList']);
$count = 1;
foreach ($products as $p) {
    $productCode = $p;
    $quantity = $_COOKIE[$p];
    $priceEach = getPrice($_COOKIE[$p]);
    $orderLineNumber = $count;
    //insert:
    $insertedOrderDetails = insertIntoOrderDetails($orderNumber, $productCode, $quantity, $priceEach, $orderLineNumber);
    if ($insertedOrderDetails) {
        echo "<p>OK: table orderDetails;</p>";
    } else {
        echo "<p>ERROR: table orderDetails;</p>";
    }
    $count += 1;
}
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!!!!!!! payments !!!!!!!!!!!!!!!!!!!!!!!!
//
$customerNumber = $customerNumber;
$checkNumber = getCheckNumber();
$paymentDate = date('Y-m-d');
$amount = $_COOKIE['totalAmount'];
$insertedPayments = insertIntoPayments($customerNumber, $checkNumber, $paymentDate, $amount);
if ($insertedPayments) {
    echo "<p>OK: table payments;</p>";
} else {
    echo "<p>ERROR: table payments;</p>";
}
// --------------------------------------- calls to updates to db here --------------------------------------------
// !!! products !!!!!!!!!!!!!!!!!!!!!!!!
//

$products = explode(":", $_COOKIE['productsList']);
$count = 1;
foreach ($products as $p) {
    $productCode = $p;
    $quantity = $_COOKIE[$productCode];
    $quantityInStock = getQuantity($productCode);
    $newQuantity = $quantityInStock - $quantity;
    //insert:
    $updatedDone = updateProductsLeft($p, $newQuantity);
    if ($updatedDone) {
        echo "<p>OK: stock updated for ". $p. ";</p>";
    } else {
        echo "<p>ERROR: stock no updated in".$p.";</p>";
    }
    $count += 1;
}
