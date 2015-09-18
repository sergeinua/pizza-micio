<?php 
    include 'functions.php';
    //$id = $_POST['id'];
    $name = $_POST['name'];
    $price30 = $_POST['price30'];
    $price60 = $_POST['price60'];
    $picture = $_POST['picture'];
    $description = $_POST['description'];
    $new_item = new ProductItems($name, $price30, $price60, $picture, $description);
    header('location: admin.php');
?>