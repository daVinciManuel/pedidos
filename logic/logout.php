<?php
// -------------------------- LOGOUT LOGIC: --------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        foreach ($_COOKIE as $name => $v) {
            setCookie($name, '', time() - 9999999, "/");
        }
        header('Location: ./pe_login.php');
    }
}
