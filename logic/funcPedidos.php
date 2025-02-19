<?php

// ------------- CALCULO DEL PRECIO ---------------------------------------------
function calcPrecioTotal($productCode, $productQuantity)
{
    $maxQuantity = getQuantity($productCode);
    if (isset($_COOKIE[$productCode])) {
        $requestQuantity = $_COOKIE[$productCode] + $productQuantity;
    } else {
        $requestQuantity = $productQuantity;
    }
    if ($requestQuantity > $maxQuantity) {
        $precioTotal = -1;
    } else {
        $price = getPrice($productCode);
        $monto = $price * $productQuantity;
        $precioTotal = $monto;
        if (isset($_COOKIE['totalAmount'])) {
            $precioTotal = $monto + $_COOKIE['totalAmount'];
            setCookie('totalAmount', $precioTotal, time() + 3600, "/");
        } else {
            setCookie('totalAmount', $precioTotal, time() + 3600, "/");
        }
    }
    return $precioTotal;
}
