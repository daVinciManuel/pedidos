<?php 
function delToken(){
  setCookie('acctk','',time()-9999,'/');
}
