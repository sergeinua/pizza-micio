<?php
    //echo '<meta charset="utf-8">';
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price30 = $_POST['price30'];
    $price60 = $_POST['price60'];
    $picture = $_POST['picture'];
    $description = $_POST['description'];

    $db = new SQLite3('data.db');
    $query = 'update items
                set
                    name = "' . $name . '",
                    price30 = "' . $price30 . '",
                    price60 = "' . $price60 . '",
                    picture = "' . $picture . '",
                    description = "' . $description . '"
                where
                    id = "' . $id . '"';
    $db->exec($query);
    header('location: admin.php');
?>