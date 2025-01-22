<!DOCTYPE html>
<?php
require "./logic/validate.php";
require "./db/inserts.php";
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
    if (isset($_SESSION["username"]) && isset($_SESSION["password"])) {
        header("Location: ./pe_inicio.php");
    }
?>
	<title>Web Pedidos</title>
	<style>body{background:#ababab;}main{width:fit-content;margin:0 auto;}</style>
</head>
<body>
	<center>
		<h1>WELCOME TO WEB PEDIDOS</h1>
		<hr> <br>
	</center>
	<main>
		<form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
			<h3>Login</h3>
			<label for="customerName">Nombre empresa:</label>
			<input type="text" name="customerName">
			<br>
			<label for="contactFirstName">Nombre de contacto:</label>
			<input type="text" name="contactFirstName">
			<br>
			<label for="contactLastName">Apellido de contacto:</label>
			<input type="text" name="contactLastName">
			<br>
			<label for="phone">Telefono:</label>
			<input type="text" name="phone">
			<br>
			<label for="addRebLine1">Direccion:</label>
			<input type="text" name="addRebLine1">
			<br>
			<label for="city">Localidad:</label>
			<input type="text" name="city">
			<br>
			<label for="country">Pais:</label>
			<input type="text" name="country">
			<br>
			<input type="submit" value="Enviar">
			<br>
		</form>
			<br><br><br><br><br>
            <!-- ENVIAR A SESSION_DESTROY.PHP EN VEZ DE A LOGIN -->
			<p>Ya tienes usuario? <a href="./pe_login.php">Formulario de inicio sesion.</a></p>
	</main>
	<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customerName = trim($_POST["customerName"]);
        $contactFirstName = trim($_POST["contactFirstName"]);
        $contactLastName = trim($_POST["contactLastName"]);
        $phone = trim($_POST["phone"]);
        $addRebLine1 = trim($_POST["addRebLine1"]);
        $city = trim($_POST["city"]);
        $country = trim($_POST["country"]);
        if (isNotEmpty($customerName) && isNotEmpty($contactFirstName) && isNotEmpty($contactLastName) && isNotEmpty($phone) && isNotEmpty($addRebLine1) && isNotEmpty($city) && isNotEmpty($country)) {
            if (addCustomer($customerName, $contactLastName, $contactFirstName, $phone, $addRebLine1, $city, $country)) {
                ?>
                <br/><hr/>
                    <h1>YOUR USERNAME IS: <?php echo getUsername($contactFirstName, $contactLastName); ?></h1>
                    <h1>YOUR PASSWORD IS: <?php echo $contactLastName; ?></h1 
                <?php
            }
        } else {
            showAlertEmptyInput();
        }
    }

?>
</body>
</html>
