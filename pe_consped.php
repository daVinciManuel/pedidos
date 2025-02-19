<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './db/connect.php'; ?>
	<?php require_once "./db/queries.php"; ?>
  <?php require_once "./logic/checkAccToken.php"; ?>
	<?php require_once "./logic/logout.php" ?>

  <?php require_once "./logic/funcPedidos.php"; ?>
  <?php require_once "./logic/ordercookies.php"; ?>
	<?php include "./view/metatags.php" ?>
	<?php include "./view/styles.php" ?>
	<title>Web Pedidos</title>
</head>
<body>
    <?php include "./view/header.php"; ?>
    <!-- crea la cookie del precio total y lo calcula -->
	<main>
		<h1>Hola <?php echo $_COOKIE["user"]; ?></h1>
		<form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="customerNumber">Numero de cliente:</label>
        <select name="customerNumber">
            <option disabled selected></option>
          <?php
          $options = selectAllCustomers();
  foreach ($options as $index => $content) {
      echo '<option value="'.$index.'">'.$content.'</option>';
  }
  ?>
        </select>
        <br>
        <input type='submit' value='Consultar pedidos'>
    </form>
<?php
if (isset($_POST['customerNumber'])) {
    if ($precioTotal == -1) {
        include "./view/errorMsg.php";
        showAlertTooMuchQuantity();
    } else {
        ?>
      <?php
    }
}
  ?>
	</main>
</body>
</html>
