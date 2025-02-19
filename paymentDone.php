<h1>oh HELLO!</h1>
<?php
require_once "./db/inserts.php";
require_once "./db/queries.php";
require_once "./db/updateProducts.php";
require './API_PHP/redsysHMAC256_API_PHP_7.0.0/apiRedsys.php';

	// Se crea Objeto
	$miObj = new RedsysAPI;

    echo '<a href="./pe_inicio.php">Go back to Inicio</a>';

if (!empty( $_POST ) ) {//URL DE RESP. ONLINE
					
					$version = $_POST["Ds_SignatureVersion"];
					$datos = $_POST["Ds_MerchantParameters"];
					$signatureRecibida = $_POST["Ds_Signature"];
					

					$decodec = $miObj->decodeMerchantParameters($datos);	
					$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
					$firma = $miObj->createMerchantSignatureNotif($kc,$datos);	

					echo PHP_VERSION."<br/>";
					echo $firma."<br/>";
					echo $signatureRecibida."<br/>";
					if ($firma === $signatureRecibida){
echo "<h2>PAYMENT WENT OK</h2>";
						echo "FIRMA OK";
            storePayment();
					} else {
						echo "FIRMA KO";
					}
	}
	else{
		if (!empty( $_GET ) ) {//URL DE RESP. ONLINE
				
			$version = $_GET["Ds_SignatureVersion"];
			$datos = $_GET["Ds_MerchantParameters"];
			$signatureRecibida = $_GET["Ds_Signature"];
				
		
			$decodec = $miObj->decodeMerchantParameters($datos);
			$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; //Clave recuperada de CANALES
			$firma = $miObj->createMerchantSignatureNotif($kc,$datos);
		
			if ($firma === $signatureRecibida){
echo "<h2>PAYMENT WENT OK</h2>";
				echo "FIRMA OK";
        storePayment();
			} else {
				echo "FIRMA KO";
			}
		}
		else{
			die("No se recibió respuesta");
		}
	}
// --------------------------------------- calls to inserts to db here --------------------------------------------
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!!!!!!! orders !!!!!!!!!!!!!!!!!!!!!!!!!!
//
function storePayment(){
  
$orderNumber = $_COOKIE['orderNumber'];
$orderDate = date('Y-m-d');
$requiredDate = date('Y-m-d');
$shippedDate = null;
$status = 'Shipped';
$comments = null;
$customerNumber = getUsername($_COOKIE['user']);
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
    // make priceEach a nunmber with 2 decimals
    $priceEach = floatval(getPrice($p));
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

}

?>
