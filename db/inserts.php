<?php

require_once "./db/connect.php";
function addCustomer($customerName, $contactLastName, $contactFirstName, $phone, $addrebLine1, $city, $country)
{
    $customerAdded = false;
    $conn = connect();
    try {
        $conn->beginTransaction();
        $query = "INSERT INTO customers(customerNumber,customerName,contactLastName,contactFirstName,phone,addrebLine1,city,country,pass)
                            VALUES (:customerNumber,:customerName,:contactLastName,:contactFirstName,:phone,:addrebLine1,:city,:country,:pass)";
        $stmt = $conn->prepare($query);
        $newCustomerNumber = generateCustomerNumber();
        $pass = password_hash($contactLastName, PASSWORD_DEFAULT);
        $stmt->bindParam(':customerNumber', $newCustomerNumber);
        $stmt->bindParam(':customerName', $customerName);
        $stmt->bindParam(':contactLastName', $contactLastName);
        $stmt->bindParam(':contactFirstName', $contactFirstName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':addrebLine1', $addrebLine1);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $conn->commit();
        $customerAdded = true;
    } catch (PDOException $e) {
        $conn->rollback();
        die($e->getMessage());

    }
    $conn = null;
    return $customerAdded;
}
function generateCustomerNumber()
{
    $code = rand(1000, 9999);
    return $code;
}
function insertIntoOrders($orderNumber, $orderDate, $requiredDate, $shippedDate, $status, $comments, $customerNumber)
{
    $insertDone = false;
    $conn = connect();
    try {
        $conn->beginTransaction();
        $query = "INSERT INTO orders(orderNumber,orderDate,requiredDate,shippedDate,status,comments,customerNumber)
                            VALUES (:orderNumber,:orderDate,:requiredDate,:shippedDate,:status,:comments,:customerNumber)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':orderNumber', $orderNumber);
        $stmt->bindParam(':orderDate', $orderDate);
        $stmt->bindParam(':requiredDate', $requiredDate);
        $stmt->bindParam(':shippedDate', $shippedDate);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':customerNumber', $customerNumber);
        $stmt->execute();
        $conn->commit();
        $insertDone = true;
    } catch (PDOException $e) {
        $conn->rollback();
        die($e->getMessage());
    }
    $conn = null;
    return $insertDone;
}

function insertIntoOrderDetails($orderNumber, $productCode, $quantity, $priceEach, $orderLineNumber)
{

    $priceEach = floatval($priceEach);
    $insertDone = false;
    $conn = connect();
    try {
        $conn->beginTransaction();
        //la tabla esta declarada en lowercase en la base de datos
        $query = "INSERT INTO orderdetails(orderNumber,productCode,quantityOrdered,priceEach,orderLineNumber)
                            VALUES (:orderNumber,:productCode,:quantityOrdered,:priceEach,:orderLineNumber)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':orderNumber', $orderNumber);
        $stmt->bindParam(':productCode', $productCode);
        $stmt->bindParam(':quantityOrdered', $quantity);
        $stmt->bindParam(':priceEach', $priceEach);
        $stmt->bindParam(':orderLineNumber', $orderLineNumber);
        $stmt->execute();
        $conn->commit();
        $insertDone = true;
    } catch (PDOException $e) {
        $conn->rollback();
        die($e->getMessage());
    }
    $conn = null;
    return $insertDone;

}
function insertIntoPayments($customerNumber, $checkNumber, $paymentDate, $amount)
{
    $insertDone = false;
    $conn = connect();
    try {
        $conn->beginTransaction();
        //la tabla esta declarada en lowercase en la base de datos
        $query = "INSERT INTO payments(customerNumber,checkNumber,paymentDate,amount)
                            VALUES (:customerNumber,:checkNumber,:paymentDate,:amount)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':customerNumber', $customerNumber);
        $stmt->bindParam(':checkNumber', $checkNumber);
        $stmt->bindParam(':paymentDate', $paymentDate);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();
        $conn->commit();
        $insertDone = true;
    } catch (PDOException $e) {
        $conn->rollback();
        die($e->getMessage());
    }
    $conn = null;
    return $insertDone;
}
