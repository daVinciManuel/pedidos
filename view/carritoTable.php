<table border=1>
  <thead>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Precio-Unidad</th>
    <th>Total</th>
  </thead>
  <tbody>
    <?php
      $products = explode(":", $_COOKIE['productsList']);
    foreach ($products as $p) {
        ?>
    <tr>
      <td><?php echo getProductName($p); ?></td>
      <td><?php echo $_COOKIE[$p]; ?></td>
      <td><?php echo getPrice($p); ?></td>
      <td><?php echo $_COOKIE[$p] * getPrice($p); ?></td>
    </tr>
    <?php
    }
    ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><?php echo $_COOKIE['totalAmount'] ?></td>
    </tr>
  </tbody>
</table>
