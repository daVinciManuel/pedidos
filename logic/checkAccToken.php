	<?php
    // compruebo que existe token

  if(!isset($_COOKIE["acctk"])) {
      header("Location: ./pe_login.php");
  }else{
    if(!checkToken()){
  header("Location: ./pe_login.php");
     }
   }
function checkToken(){
    $tokenok = false;
  if(isset($_COOKIE['acctk'])){
    $token = $_COOKIE['acctk'];
    $contactFirstName = $_COOKIE['user'];
    $tk = explode(":",$token);
    $userOK = password_verify(getUsername($contactFirstName),$tk[0]);
    $passOK = password_verify(getPassword($contactFirstName),$tk[1]);
      if($userOK && $passOK){
      $tokenok = true;
  }
  }
  return $tokenok;

}
