<?php

function userExists($username)
{
    // consulta cuantos registros hay con el nombre de usuario en {tabla:customers columna:customerNumber	}
    // si devuelve 1 => usuario existe (true). si NO devuelve 1 => usuario n existe (false)
    $exist = false;
    $conn = connect();

    $query = "SELECT count(customerNumber) FROM customers WHERE customerNumber='".$username."';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchColumn();
    if ($result == 1) {
        $exist = true;
    }
    $conn = null;
    return $exist;
}
function correctPassword($username, $password)
{
    $exist = false;
    $conn = connect();

    $query = "SELECT count(customerNumber) FROM customers WHERE customerNumber='".$username."' AND contactLastName='".$password."';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchColumn();
    if ($result == 1) {
        $exist = true;
    }

    $conn = null;

    return $exist;
}
// compara si el password introducido con el encriptado de la base de datos:
function getPasswordHashed($user)
{

    $conn = connect();

    $query = "SELECT pass FROM customers WHERE customerNumber='".$user."';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $passwordHashed = $stmt->fetchColumn();

    $conn = null;
    return $passwordHashed;
}
function getPassword($contactFirstName)
{
    $conn = connect();

    $query = "SELECT contactLastName FROM customers WHERE contactFirstName=:contactFirstName;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':contactFirstName',$contactFirstName);
    $stmt->execute();
    $username = $stmt->fetchColumn();
    $conn = null;
    return $username;
}
function getUsername($contactFirstName)
{
    $conn = connect();

    $query = "SELECT customerNumber FROM customers WHERE contactFirstName=:contactFirstName;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':contactFirstName',$contactFirstName);
    $stmt->execute();
    $username = $stmt->fetchColumn();
    $conn = null;
    return $username;
}
function getFirstName($username)
{
    $conn = connect();

    $query = "SELECT contactFirstName FROM customers WHERE customerNumber='". $username."';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $firstName = $stmt->fetchColumn();

    $conn = null;
    return $firstName;
}
function getPrice($productCode)
{
    $conn = connect();
    $query = "SELECT buyPrice FROM products WHERE productCode='". $productCode . "';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $productPrice = $stmt->fetchColumn();
    $conn = null;
    return $productPrice;
}
function selectAllCustomers()
{
    $conn = connect();
    $stmt = $conn->prepare("SELECT customerNumber, customerFirstName FROM customers;");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rawResult = $stmt->fetchAll();

    foreach ($rawResult as $r) {
        $arr[$r["customerNumber"]] = $r["customerFirstName"];
    }
    return($arr);
    $conn = null;
}
function selectAllProducts()
{
    $conn = connect();
    $stmt = $conn->prepare("SELECT productCode, productName FROM products WHERE quantityInStock > 0;");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rawResult = $stmt->fetchAll();

    foreach ($rawResult as $r) {
        $arr[$r["productCode"]] = $r["productName"];
    }
    return($arr);
    $conn = null;
}
function getOrderNumber()
{
    $conn = connect();
    $query = "SELECT max(orderNumber) FROM orders;";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $lastOrderNumber = $stmt->fetchColumn();
    $newOrderNumber = $lastOrderNumber + 1;
    $conn = null;
    //return $newOrderNumber;
    return rand(100000,199999);
}
function getQuantity($productCode)
{
    $conn = connect();
    $query = "select quantityInStock from products where productCode='" . $productCode . "';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $cantidad = $stmt->fetchColumn();
    $conn = null;
    return $cantidad;
}
function getProductName($productCode)
{
    $conn = connect();
    $query = "select productName from products where productCode='" . $productCode . "';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $name = $stmt->fetchColumn();
    $conn = null;
    return $name;
}
function getCheckNumber()
{
    $conn = connect();
    $query = "SELECT max(checkNumber) FROM payments WHERE checkNumber LIKE 'AA%';";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $lastCheckNumber = $stmt->fetchColumn();
    if ($lastCheckNumber == null) {
        $newCheckNumber = 'AA00001';
    } else {
        $newCheckNumber = 'AA' . sprintf("%05d", (strval(intval(substr($lastCheckNumber, 2)) + 1)));
    }

    $conn = null;
    return $newCheckNumber;
}
