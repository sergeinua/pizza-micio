<?php
    if (session_status() < 2) {
        session_start ();
    }
    
    $_SESSION['order_made'] = 1;
    
    
    include 'functions.php';
    //echo '<meta charset="utf-8">';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel_num = $_POST['tel_num'];
    $address = $_POST['address'];
    $comment = $_POST['comment'];
    $customer = new Customer($name, $email, $tel_num, $address);
    $order = new Order($customer, $comment);
    ////отправить почту
    header('location: cart.php');
?>