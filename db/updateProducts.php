<?php

require_once "./db/connect.php";
function updateProductsLeft($productCode, $quantity)
{
    $updateDone = false;
    $conn = connect();
    try {
        $conn->beginTransaction();
        //la tabla esta declarada en lowercase en la base de datos
        $query = 'UPDATE products SET quantityInStock='.$quantity.' WHERE productCode="'.$productCode.'";';
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $conn->commit();
        $updateDone = true;
    } catch (PDOException $e) {
        $conn->rollback();
        die($e->getMessage());
    }
    $conn = null;
    return $updateDone;
}
