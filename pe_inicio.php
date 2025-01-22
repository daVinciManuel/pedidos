<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "./logic/checkAccToken.php"; ?>
    <?php require_once "./logic/logout.php"; ?>
    <?php include "./view/metatags.php"; ?>
    <?php include "./view/styles.php"; ?>
	<title>Web Pedidos</title>
</head>
<body>
    <?php include "./view/header.php"; ?>
	<main>
		<h1>Hola <?php echo $_COOKIE["user"]; ?></h1>
    <h2>Listado de actividades:</h2>
      <ul><a href="./pe_altaped.php">Hacer pedido</a></ul>

<?php
      $date = date('Y-m-d');
    var_dump($date);
    ?>
	</main>
</body>
</html>
