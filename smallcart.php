<?php
if (session_status() < 2) {
    session_start();
}
echo '<meta charset="utf-8">';
echo '<div class="small_cart_header">'
    . '<a>Ваш заказ</a>'
    . '<a><img src="pics/glyphs/pocket.png" width=20px heiht=20px></a>'
    . '</div>';

require_once 'functions.php';
$cart = new smallCart();
$cart->load();
    
if (isset($_GET['clear'])) {
        unset($_SESSION['current_order']);
        header('location:' . $_SERVER['HTTP_REFERER']);
}	
if (isset($_GET['increase'])) {
    require_once 'functions.php';
    $cart = new smallCart();
    $cart->increase($_GET['increase']);
    header('location:' . $_SERVER['HTTP_REFERER']);
}
if (isset($_GET['decrease'])) {
    require_once 'functions.php';
    $cart = new smallCart();
    $cart->decrease($_GET['decrease']);        
    header('location:' . $_SERVER['HTTP_REFERER']);
}
if (isset($_GET['delete'])) {
    require_once 'functions.php';
    $cart = new smallCart();
    $cart->delete($_GET['delete']);
    header('location:' . $_SERVER['HTTP_REFERER']);
}

?>