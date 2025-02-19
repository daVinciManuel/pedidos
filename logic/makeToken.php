<?php
function makeToken($user,$pass){
// se va a crear un token para el usuario.
// el token va a ser:
// [salt][][nombre][][password][][salt]
  $a = password_hash($user, PASSWORD_DEFAULT);
  $b = password_hash($pass, PASSWORD_DEFAULT);
  $token = $a . ':' . $b;
  setcookie('acctk',$token,time()+3600,'/');
  return $token;
}
// include '../db/connect.php';
// include '../db/queries.php';

