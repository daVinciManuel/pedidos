<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once "./logic/checkAccToken.php"; ?>
	<?php require_once "./logic/logout.php" ?>
  <?php require_once "./logic/funcPedidos.php"; ?>
	<?php require_once "./db/queries.php"; ?>
  <?php require_once "./logic/ordercookies.php"; ?>
	<?php include "./view/metatags.php" ?>
	<?php include "./view/styles.php" ?>
  <?php setCookie("orderNumber", getOrderNumber(), time() + 3600, "/"); ?>
	<title>Web Pedidos</title>
</head>
<body>
    <?php include "./view/header.php"; ?>
    <!-- crea la cookie del precio total y lo calcula -->
    <?php if (isset($_POST['product'])) {
        $precioTotal = calcPrecioTotal($_POST['product'], $_POST['cantidad']);
    }?>
	<main>
		<h1>Hola <?php echo $_COOKIE["user"]; ?></h1>
		<form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="product">Seleccione un producto:</label>
        <select name="product">
            <option disabled selected></option>
          <?php
          $options = selectAllProducts();
  foreach ($options as $index => $content) {
      echo '<option value="'.$index.'">'.$content.'</option>';
  }
  ?>
        </select>
        <br>
        <label for='cantidad'>Cantidad:</label>
        <input type="number" name='cantidad' min=0>
        <br>
        <input type='submit' value='Agregar al carrito'>
    </form>
<?php
if (isset($_POST['cantidad'])) {
    if ($precioTotal == -1) {
        include "./view/errorMsg.php";
        showAlertTooMuchQuantity();
    } else {
        ?>
      <dialog open>
        El precio total es: <?php echo $precioTotal ?> </br>
        <a href='./carrito.php'><button>PAGAR</button></a>
      </dialog>
      <?php
    }
}
  ?>
	</main>
</body>
</html>
