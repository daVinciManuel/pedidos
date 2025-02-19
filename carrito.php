<!DOCTYPE html>
<html>
  <head>
<?php require "./db/connect.php"; ?>
<?php require "./db/queries.php"; ?>
<?php require "./logic/logout.php"; ?>
<?php require "./logic/checkAccToken.php"; ?>
<?php include "./view/metatags.php"; ?>
<?php include "./view/styles.php"; ?>
  <title>Web Pedidos Carrito</title>
<?php $money = $_COOKIE['totalAmount']; ?>
  </head>
  <body>
<?php include "./view/header.php"; ?>
    <h2>Carrito de <?php echo $_COOKIE['user']; ?>:</h2>
<?php include "./view/carritoTable.php"; ?>
    <h3>Total a pagar: <?php echo $money; ?></h3>
    <?php
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ESTA LINEA DEFINE SI SE USA REDSYS O NO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $redsys = true;
if ($redsys) {

	include './API_PHP/redsysHMAC256_API_PHP_7.0.0/apiRedsys.php';
	$miObj = new RedsysAPI;
		
	$fuc="263100000";
	$terminal="8";
	$moneda="978";
	$trans="0";
	$url="http://sis-t.redsys.es:25443/sis/realizarPago";
	$urlOKKO="http://localhost/ApiPhpRedsys/ApiRedireccion/redsysHMAC256_API_PHP_5.2.0/ejemploRecepcionaPet.php";
  $urlKO="http://192.168.206.130/apps/pedidos/paymentError.php";
  $urlOK="http://192.168.206.130/apps/pedidos/paymentDone.php";
	$id=sprintf("%012d", $_COOKIE['orderNumber']);
	$amount=euroToCent($money);
  $card = 'C';
	// Se Rellenan los campos
	$miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
	$miObj->setParameter("DS_MERCHANT_ORDER",$id);
	$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
	$miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
	$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
	$miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
	$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
	$miObj->setParameter("DS_MERCHANT_URLOK",$urlOK);
	$miObj->setParameter("DS_MERCHANT_URLKO",$urlKO);
	$miObj->setParameter("DS_MERCHANT_PAYMENTMETHOD",$card);

	//Datos de configuración
	$version="HMAC_SHA256_V1";
	$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';//Clave recuperada de CANALES
	// Se generan los parámetros de la petición
	$request = "";
	$params = $miObj->createMerchantParameters();
	$signature = $miObj->createMerchantSignature($kc);

 
    ?>
    <form action='https://sis-t.redsys.es:25443/sis/realizarPago' method='POST'>
Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/></br>
Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/></br>
Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="<?php echo $signature; ?>"/></br>
      <input type='submit' value='PAGAR'>
    </form>
<?php
} else {
    ?>
    <a href='./paymentDone.php'><button>PAGAR</button></a>
    <a href='./paymentError.php'><button>NO PAGAR</button></a>
<?php
}
?>
  </body>
</html>
<?php
function getClaveComercio($orderNumber)
{
    $clave = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";
    $claveDecode = base64_decode($clave);
    $claveReady = $claveDecode . $orderNumber;
}
?>
    <?php
function euroToCent($money)
{
    $money = (string)$money;
    // si tiene punto, le agrego los 0 necesarios
    if (strpos($money, '.') !== false) {
        if (strlen(substr($money, strpos($money, '.') + 1)) == 1) {
            $money .= '0';
        }
        // le quito el punto
        $money = str_replace('.', '', $money);
    } else {
        // si no tiene punto le agrego 2 ceros
        $money .= '00';
    }
    return $money;
}
?>
