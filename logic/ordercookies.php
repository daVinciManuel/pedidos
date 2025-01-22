<?php
if(isset($_POST['product'])){
    $maxQuantity = getQuantity($_POST['product']);
    if (isset($_COOKIE[$productCode])) {
        $requestQuantity = $_COOKIE[$_POST['product']] + $_POST['cantidad'];
    } else {
        $requestQuantity = $_POST['cantidad'];
    }
    if ($requestQuantity > $maxQuantity) {
    } else {
  if(isset($_COOKIE[$_POST['product']])){
    $cantidad = $_POST['cantidad'] + $_COOKIE[$_POST['product']] ;
    setCookie($_POST['product'], $cantidad, time() + 3600, "/");
  }else{
    setCookie($_POST['product'], $_POST['cantidad'], time() + 3600, "/");
  }
  if(isset($_COOKIE['productsList'])){
    $productsList = $_COOKIE['productsList'] . ':' . $_POST['product'];
    setCookie("productsList",$productsList, time() + 3600, "/");
  }else {
    setCookie("productsList",$_POST['product'], time() + 3600, "/");
  }
  
}
}
