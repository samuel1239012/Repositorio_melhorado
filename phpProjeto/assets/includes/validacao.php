<?php
$path = "http://localhost:4200/admin";


$arr = explode("/", $_SERVER["REQUEST_URI"]);

$cont = count($arr);
$comp="";
$home_interno="";

if ($cont > 3){
  $comp = "../";
  $home_interno=$arr[2];
}

?>
