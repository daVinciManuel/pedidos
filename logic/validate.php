<?php

require "./db/queries.php";
include "./view/errorMsg.php";
function verifyLogin($username, $password)
{
    $login = false;
    // revisa que los campos no esten vacios
    if (isNotEmpty($username) && isNotEmpty($password)) {
        // revisa que el password se corresponde con el usuario dado
        if (loginok($username, $password)) {
            $login = true;
            // crea cookie de token
            makeToken($username,$password);
            if ($username == 'root') {
                $username = '0000';
            }
      $firstName = getFirstName($username);
            setCookie("user", $firstName, time() + 3600, "/");
            // elimino la cookie que cuenta intentos fallidos de login con un usuario
            if (isset($_COOKIE["loginAttempts"])) {
                setCookie("loginAttempts", 0, time() - 99999, "/");
            }
        } else {
            // se ha equivocado de password.

            // Tiene 3 intentos (count starts here)
            $limitAttempts = 3;
            // si no esta definida la cookie, la crea
            if (!isset($_COOKIE["loginAttempts"])) {
                // crea la cookie inicializada en 1
                setCookie("loginAttempts", 1, time() + 120, "/");
                // Muestra cuantos intentos le quedan al usuario
                showAttempts($limitAttempts);
            } else {
                // si ya existe la cookie de intentos fallidos:
                // asigno el numero de intentos que lleva a $count
                $count = $_COOKIE["loginAttempts"];

                // si lleva menos intentos que el limite de intentos:
                if ($count > $limitAttempts - 1) {
                    // if ($_COOKIE["loginAttempts"] > $limitAttempts + 1) {
                    header('Location: ./pe_registro.php');
                    setCookie("ban", 0, time() + 120, "/");
                } else {

                    // calculo los intentos que le queda
                    $attemptsLeft = $limitAttempts - $count;

                    // Muestra cuantos intentos le quedan al usuario
                    showAttempts($attemptsLeft);
                }
                // suma 1 intento
                $count += 1;
                // setCookie("loginAttempts", $count, time() + 120, "/");
                setCookie("loginAttempts", $count, time() + 120, "/");

            }
        }
    } else {
        // Rellene los campos Username y Password
        showAlertLoginFormIsEmpty();
        // elimino la cookie que cuenta intentos fallidos de login con un usuario
        if (isset($_COOKIE["loginAttempts"])) {
            setCookie("loginAttempts", 0, time() - 99999, "/");
        }
    }
    return $login;
}
function isNotEmpty($word)
{
    $content = false;
    if (strlen($word) > 0) {
        $content = true;
    }
    return $content;
}
function verifySession($username)
{
    if (isset($_SESSION[$username])) {
        if (verifyPasswordHashed($username, $_SESSION[$username])) {
            var_dump($_SESSION);
        }
    }
}
function verifyPasswordHashed($username, $password)
{
    $cryptPass = getPasswordHashed($username);
    $passIsRight = false;
    if (password_verify($password, $cryptPass)) {
        $passIsRight = true;
    }
    return $passIsRight;
}
function loginok($username, $password)
{
    if ($username == 'root' && $password == 'root') {
        $login = true;
    } else {
      if(verify($username,$password)){
          $login = true;
      }else{ $login = false; }
    }
    return $login;
}
