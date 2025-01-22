<!DOCTYPE html>
<html>
  <head>
<?php require "./db/queries.php"; ?>
<?php require "./logic/logout.php"; ?>
<?php require "./logic/checkAccToken.php"; ?>
<?php include "./view/metatags.php"; ?>
<?php include "./view/styles.php"; ?>
  <title>Web Pedidos Carrito</title>
<?php $money = $_COOKIE['totalAmount']; ?>
<?php $moneyFormatted = euroToCent($money); ?>
  </head>
  <body>
<?php include "./view/header.php"; ?>
    <h2>Carrito de <?php echo $_COOKIE['user']; ?>:</h2>
<?php include "./view/carritoTable.php"; ?>
    <h3>Total a pagar: <?php echo $money; ?></h3>
    <?php
    //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ESTA LINEA DEFINE SI SE USA REDSYS O NO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    $redsys = false;
if ($redsys) {
    ?>
    <form action='https://sis-t.redsys.es:25443/sis/realizarPago' method='POST'>
      <input type="hidden" name="DS_MERCHANT_AMOUNT" value="<?php echo $moneyFormatted;?>">
      <input type="hidden" name="DS_MERCHANT_CURRENCY" value="978"> <!-- ID único de la transacción -->
      <input type="hidden" name="DS_MERCHANT_MERCHANTCODE" value="263100000"> <!-- Código del comercio -->
      <input type="hidden" name="DS_MERCHANT_ORDER" value="<?php printf("%012d", $_COOKIE['orderNumber']); ?>"> 
      <input type="hidden" name="DS_MERCHANT_TERMINAL" value="1"> <!-- Número de terminal (1 para prueba) -->
      <input type="hidden" name="DS_MERCHANT_TRANSACTIONTYPE" value="0"> <!-- Tipo de transacción: 0 (venta) -->
      <input type="hidden" name="DS_MERCHANT_PAYMENTMETHOD" value="C"> <!-- Método de pago: tarjeta -->
      <input type="hidden" name="DS_MERCHANT_URLKO" value="http://192.168.206.130/apps/pedidos/paymentError.php"> <!-- Método de pago: tarjeta -->
      <input type="hidden" name="DS_MERCHANT_URLOK" value="http://192.168.206.130/apps/pedidos/paymentDone.php"> <!-- Método de pago: tarjeta -->
      <input type="hidden" name="DS_MERCHANT_PARAMETERS" value="<?php echo getEncodedParameter($_COOKIE['totalAmount'], $_COOKIE['orderNumber']); ?>"> <!-- Método de pago: tarjeta -->
      <input type="hidden" name="DS_SIGNATUREVERSION" value="HMAC_SHA256_V1"/>
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
function getEncodedParameter($money, $orderNumber)
{
    $parameters = [
    "DS_MERCHANT_AMOUNT" => euroToCent($money),
    "DS_MERCHANT_CURRENCY" => 978,
    "DS_MERCHANT_MERCHANTCODE" => 263100000,
    "DS_MERCHANT_MERCHANTURL" => "http://192.168.206.130/apps/pedidos/pe_inicio.php",
    "DS_MERCHANT_ORDER" => sprintf("%012d", $orderNumber),
    "DS_MERCHANT_TERMINAL" => 1,
    "DS_MERCHANT_TRANSACTIONTYPE" => 1,
    "DS_MERCHANT_URLKO" => "http://192.168.206.130/apps/pedidos/paymentError.php",
    "DS_MERCHANT_URLOK" => "http://192.168.206.130/apps/pedidos/paymentDone.php"
    ];
    $json_data = json_encode($parameters);
    $base64_string = base64_encode($json_data);
    return $base64_string;
}
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
