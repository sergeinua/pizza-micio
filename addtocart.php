<?php

if (session_status() < 2) {
    session_start();
}
echo '<meta http-equiv="Content-type" content="text/html;charset=UTF-8">';

if (isset($_POST['product_id'])) {
    $item = $_POST['product_id'];
}
if (isset($_POST['product_size'])) {
    $size = $_POST['product_size'];
}
if ($size === '30') {
    $price = $_POST['price30'];
}
if ($size === '60') {
    $price = $_POST['price60'];
}

require 'functions.php';
$cart = new smallCart();
$cart->add($item, $size, $price);
header('location: pizza.php');

?>