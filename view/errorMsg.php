<?php
function showAttempts($n){
    echo "<p><b>Clave incorrecta. Quedan ". $n." intentos.</b></p>";
}
function showAlertUserNoExists(){
    echo "<script>alert('usuario no existe. Intentelo de nuevo')</script>";
}
function showAlertLoginFormIsEmpty(){
    echo "<script>alert('Rellene los campos Username y Password')</script>";
}
function showAlertEmptyInput(){
    echo "<script>alert('Debe rellenar todos los campos.')</script>";
}
function showAlertTooMuchQuantity(){
    echo "<script>alert('No tenemos suficientes unidades en Stock.')</script>";
}
