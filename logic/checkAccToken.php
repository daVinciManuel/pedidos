	<?php
    // compruebo que existe token
    if (!isset($_COOKIE["accToken"])) {
        header("Location: ./pe_login.php");
    }
