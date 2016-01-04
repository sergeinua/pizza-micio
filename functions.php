<?php
Class Items {

    public function load() {

        $db = new SQLite3('data.db');
        $query = $db->query('select * from items');
        $items = $query->fetchArray(SQLITE3_ASSOC);
        var_dump($items);        
    }
    
    
    public function loadGrid() {
        $db = new SQLite3 ('data.db');
        $query = $db->query('select id from items where id=(select max(id) from items)');
        $items = $query->fetchArray(SQLITE3_ASSOC);
        $n = $items['id'];
        
        for ($i = 0; $i <= $n; $i++) {
            $query = $db->query('select * from items where id='.$i);
            $items = $query->fetchArray(SQLITE3_ASSOC);
            if (isset($items['id'])) {
                echo '  
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="product_item">                            
                                <form action="addtocart.php" method="post" >
                                    <div class="product_pic"><img src="pics/' . $items["picture"] . '"></div>
                                    <div class="product_name">' . $items["name"] . '</div>
                                    <div class="product_descr"><a style="color: red;">состав: </a><a>' . $items["description"]
                                    . '</a></div>
                                    <div><input name="product_id" value="' . $items['name'] . '" type="hidden"></div>
                                    <table>
                                        <tr>                                    
                                            <td><div class="txt_size_30"><a>Ø30</a></div></td>
                                            <td><div class="price30"><a name="price30">' . $items["price30"] . ' грн</a></div></td>
                                            <td><div><input name="product_size" id="product_size_30" type="submit" value="30" onclick="confirm()"></div></td>
                                        </tr>
                                        <tr>                                    
                                            <td><div class="txt_size_60"><a>Ø60</a></div></td>
                                            <td><div class="price60"><a name="price60">' . $items["price60"] . ' грн</a></div></td>
                                            <td><div><input name="product_size" id="product_size_60" type="submit" value="60" onclick="confirm()"></div></td>
                                            <td><div><input name="price30" value="' . $items["price30"] . '" type="hidden"></div></td>
                                            <td><div><input name="price60" value="' . $items["price60"] . '" type="hidden"></div></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                        ';	
            }
        }
        
    }
    
    
}

class smallCart {
           
    function load() {
        
        $url = $_SERVER['REQUEST_URI'];
        if (isset($_SESSION['current_order'])) {
            $order = $_SESSION['current_order'];
            $n = count($order);                    
            echo '<table>';
            for ($i = 0; $i < $n; $i++) {
                if(isset($order[$i])) {
                    echo '<tr>';
                    echo '<td>' . $order[$i]['item'] . '</td> ';
                    echo '<td><a href="' . $url . '?decrease=' . $i . '"><i class="fa fa-minus"></i></a></td>';
                    echo '<td>' . $order[$i]['quan'] . '</td>';
                    echo '<td><a href="' . $url . '?increase=' . $i . '"><i class="fa fa-plus"></i></a></td>';
                    echo '<td id="cart_item_price">' . $order[$i]['price'] . '</td>';
                    echo '<td><a href="' . $url . '?delete=' . $i . '"><i class="fa fa-times"></i></a></td>';
                    echo '</tr>';
                }
            }
            echo '</table>';
            if ($n > 0) {
                require_once 'functions.php';
                echo '<div class="btn_block">'
                        . '<div class="small_cart_order">'
                            . '<i class="fa fa-check-square-o"></i>'
                            . '<a href="cart.php">оформить</a>'
                        . '</div>'
                        . '<div class="small_cart_total_cost">'
                            . '<a>' . cartCost() . '</a>'
                        . '</div>'
                    . '</div>';
            }
        } 
        //else {
          //  echo '<a id="empty_cart">Вы еще ничего не заказали</a>';
        //}
        $this->isEmpty();
    }

    function increase($i) {
        $_SESSION['current_order'][$i]['quan']++;
    }

    function decrease($i) {                
        $_SESSION['current_order'][$i]['quan']--;
        if ($_SESSION['current_order'][$i]['quan'] == 0) {                    
            unset($_SESSION['current_order'][$i]);                    
            sort($_SESSION['current_order']);                    
        }
    }

    function delete($i) {
        unset($_SESSION['current_order'][$i]);                    
        sort($_SESSION['current_order']);                 
    }

    function add($item, $size, $price) {
        $item = $item . '(' . $size . ')';
        if (isset($_SESSION['current_order'])) {
            $order = $_SESSION['current_order'];
            $n = count($order);
        } else {
            $n = 0;
        }
        if ($n == 0) {
            $i = 1;
            $order['0']['item'] = $item;
            $order['0']['price'] = $price;
            $order['0']['quan'] = '1';
        }
        $exists = 0;
        if ($n > 0) {
            for ($i = 0; $i < $n; $i++) {
                if ($order[$i]['item'] == $item) {
                    $order[$i]['quan'] = $order[$i]['quan'] + 1;
                    $exists = $exists + 1;
                }
                if ($exists > 0) {
                    break;
                }
            }
            if ($exists == 0) {
                $n = count($order);
                $order[$n]['item'] = $item;
                $order[$n]['price'] = $price;
                $order[$n]['quan'] = '1';
            }
        }
        $_SESSION['current_order'] = $order;
    }

    function isEmpty() {
        if (isset($_SESSION['current_order'])) {
            if (count($_SESSION['current_order']) == 0) {
                echo '<a id="empty_cart">Вы еще ничего не заказали</a>';
            }
        } else {
            echo '<br><a id="empty_cart">Вы еще ничего не заказали</a>';
        }
    }


}
    
class Cart {

    function load() {

        if (session_status() < 2) {
            session_start();
        }
        if (isset($_SESSION['current_order'])) {
            $order = $_SESSION['current_order'];
            $n = count($order);
            if ($n > 0) {
                echo '<div class="cart_top">'
                    //    . '<a>Ваш заказ</a>'                    
                    . '</div>'
                    . '<div class="cart_content">';                
                        for ($i = 0; $i < $n; $i++) {
                            echo '<div class="cart_single_position">'
                                    . '<div class="cart_img">' . $this->showImage($order[$i]["item"]) . '</div>'
                                    . '<div class="cart_item">' . $order[$i]["item"] . '</div>'
                                    . '<div class="cart_quan">' . $order[$i]["quan"] . '</div>'
                                    . '<div class="cart_cost">' . $order[$i]["price"] . '</div>' // * $order[$i]["quan"]
                                    . '<div class="cart_del_item">'
                                        . '<a href="cart.php?delete=' . $i . '">'
                                            . '<i class="fa fa-trash-o"></i>'
                                        . '</a>'
                                    . '</div>'
                                . '</div>';
                        }
                    echo '</div>';
            }

            if (isset($_GET['clear'])) {
                $this->clear();
                header('location:'.$_SERVER['HTTP_REFERER']);
            }	
            if (isset($_GET['increase'])) {                
                $this->increase($_GET['increase']);
                header('location:'.$_SERVER['HTTP_REFERER']);
            }
            if (isset($_GET['decrease'])) {
                $this->decrease($_GET['decrease']);
                header('location:'.$_SERVER['HTTP_REFERER']);
            }	
            if (isset($_GET['delete'])) {
                $this->delete($_GET['delete']);
                header('location:'.$_SERVER['HTTP_REFERER']);
            }
            if ($n > 0) {
                echo '<div class="cart_bottom">'
                        . '<a href="cart.php?clear" id="cart_clear_btn" data-title="очистить корзину"><i class="fa fa-times"></i></a>'
                        . '<a id="cart_total_amount">' . cartCost() . ' грн</a>'
                    . '</div>';        
            }
        }
    }

    function increase($i) {
        $_SESSION['current_order'][$i]['quan']++;
    }

    function decrease($i) {                
        $_SESSION['current_order'][$i]['quan']--;
        if ($_SESSION['current_order'][$i]['quan'] == 0) {                    
            unset($_SESSION['current_order'][$i]);                    
            sort($_SESSION['current_order']);                    
        }
    }

    function delete($i) {
        unset($_SESSION['current_order'][$i]);                    
        sort($_SESSION['current_order']);                 
    }

    function clear() {
        unset($_SESSION['current_order']);
    }

    function isEmpty() {
        if (isset($_SESSION['current_order'])) {
            if (count($_SESSION['current_order']) == 0) {
                echo '  <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="empty_cart">
                                        <a>Ваша корзина пуста</a>
                                        <img src="pics/empty_cart.jpg">
                                        <div class="pizza_btn">
                                            <a href="pizza.php">выбрать пиццу!</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                            </div>
                        </div>';
            }
        } else {
            echo '  <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="empty_cart">
                                    <a>Ваша корзина пуста</a>
                                    <img src="pics/empty_cart.jpg">
                                    <div class="pizza_btn">
                                        <a href="pizza.php">выбрать пиццу!</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                        </div>
                    </div>';
        }
    }
    
    function orderMade() {
        echo '<div class="alert alert-success">'
                . '<p>Спасибо!</p>'
                . '<p>Ваш заказ принят. Мы свяжемся с Вами в ближайшее время для подтверждения заказа.</p>'
            . '</div>'; //order_made 
        if (session_status() < 2) {
            session_start();
        }
        unset($_SESSION['order_made']);
    }
            
    function showImage($name) {
        $length = strlen($name);
        $length = $length - 4;
        $name = substr($name, 0, $length);

        $db = new SQLite3('data.db');
        $query = $db->query('select id from items where id=(select max(id) from items)');
        $items = $query->fetchArray(SQLITE3_ASSOC);
        $n = $items['id'];
        for ($i = 1; $i <= $n; $i++) {
            $query = $db->query('select * from items where id=' . $i);
            $items = $query->fetchArray(SQLITE3_ASSOC);
            if ($items['name'] == $name) {
                return '<img src="/pics/' . $items["picture"] . '" width="80px" height="80px">';
            }
        }
    }

}

class Customer {

    public $name;
    public $email;
    public $tel_num;
    public $address;
	
    function __construct($name, $email, $tel_num, $address) {
        $this->name = $name;
        $this->email = $email;
        $this->tel_num = $tel_num;
        $this->address = $address;
    }
}



function cartCost() {
    if (isset($_SESSION['current_order'])) {
        $order = $_SESSION['current_order'];
        $n = count($order);
        $total_cost = 0;
        for ($i = 0; $i < $n; $i++) {
            if (isset($order[$i]['item'])) {
                $total_cost = $total_cost + $order[$i]['price'] * $order[$i]['quan'];
            }
        }
        if ($total_cost > 0)
            return $total_cost;
    }
}

function showDeliveryDetails() {
    
    echo '<div class="delivery_details">'
            . '<div class="delivery_details_header">'
                . '<a>Адрес доставки</a>'
                . '<i class="fa fa-truck"></i>'
            . '</div>'
            . '<form action="createorder.php" method="post">'
                . '<div class="delivery_box">'
                    . '<input type="text" name="tel_num" value placeholder="номер телефона">'
                    . '<i class="fa fa-phone"></i>'
                . '</div>'     
                . '<div class="delivery_box">'
                    . '<input type="text" name="name" value placeholder="имя">'
                    . '<i class="fa fa-user"></i>'
                . '</div>'
                . '<div class="delivery_box">'
                    . '<input type="text" name="address" value placeholder="адрес доставки">'
                    . '<i class="fa fa-map-marker"></i>'
                . '</div>'
                . '<div class="delivery_box">'
                    . '<input type="text" name="email" value placeholder="email">'
                    . '<i class="fa fa-envelope-o"></i>'
                . '</div>'
                . '<div class="delivery_box">'
                    . '<input name="comment" value placeholder="примечание">'
                    . '<i class="fa fa-pencil"></i>'
                . '</div>'                   
                . '<input class="delivery_btn" type="submit" value="заказать">'
            . '</form>'
        . '</div>';
}

function adminIsLogged() {
    if (session_status() < 2) {
        session_start();
    }
    if (!isset($_SESSION['current_user'])) {
        echo '<meta charset="utf-8"';
        echo '<a>Вы не авторизовались</a><br>';
        echo '<a href="auth.php">войти</a>';
        exit;
    }
}

function adminCheckStatus() {
    if (isset($_GET['addnew'])) {
        echo '
                <form action="additem.php" method="post">
                    <a>название</a><br><input id="name" name="name" type="text"><br>
                    <a>цена 30 см</a><br><input name="price30" type="text"><br>
                    <a>цена 60 см</a><br><input name="price60" type="text"><br>
                    <a>фото</a><br><input id="picture" name="picture" type="text"><br>
                    <a>описание</a><br><input id="description" name="description" type="text"><br>
                    <input type="submit" value="сохранить">
                </form>
                ';
    }

    if (isset($_GET['editid'])) {
        $id = $_GET['editid'];
        $db = new SQLite3('data.db');
        $query = $db->query('select * from items where id="' . $id . '"');
        $items = $query->fetchArray(SQLITE3_ASSOC);
        echo '
                <form action="edititem.php" method="post">
                    <a>id</a><br><input id="id" name="id" type="text" value="' . $items["id"] . '"><br>
                    <a>название</a><br><input id="name" name="name" type="text" value="' . $items["name"] . '"><br>
                    <a>цена 30 см</a><br><input  name="price30" type="text" value="' . $items["price30"] . '"><br>
                    <a>цена 60 см</a><br><input  name="price60" type="text" value="' . $items["price60"] . '"><br>
                    <a>фото</a><br><input id="picture" name="picture" type="text" value="' . $items["picture"] . '"><br>
                    <a>описание</a><br><input id="description" name="description" type="text" value="' . $items["description"] . '"><br>
                    <input type="submit" value="сохранить">
                </form>
                ';
        $db->close();
    }

    if (isset($_GET['deleteid'])) {
        $id = $_GET['deleteid'];
        $db = new SQLite3('data.db');
        $query = 'delete from items where id = "' . $id . '"';
        $db->exec($query);
        $db->close();
        header('location:' . $_SERVER['HTTP_REFERER']);
    }

    if (isset($_GET['updid'])) {
        $db = new SQLite3('data.db');
        $db->exec('update orders set status="Выполнен" where orderid="' . $_GET['updid'] . '"');
        $db->close();
        header('location:' . $_SERVER['HTTP_REFERER']);
    }
}

function adminLoadTab() {
    if (isset($_GET['tab'])) {
        if ($_GET['tab'] == 'items') {
            echo 'Продукция';
            adminShowItems();
        }
        if ($_GET['tab'] == 'orders') {
            echo 'Заказы';
            showAllOrders();
        }
        if ($_GET['tab'] == 'password') {
            adminSetPswd();
        }
        if ($_GET['tab'] == 'quit') {
            if (session_status() < 2)
                session_start();
            unset($_SESSION['current_user']);
            header('location: http://pizza-micio.kiev.ua/');
        }
    } else {
        echo 'добавить картинку';
    }
}


function adminShowItems() {
    $db = new SQLite3('data.db');
    $query = $db->query('select id from items where id=(select max(id) from items)');
    $items = $query->fetchArray(SQLITE3_ASSOC);
    $n = $items['id'];
    echo '<table border=1>';
    for ($i = 1; $i <= $n; $i++) {
        echo '<tr>';
        $query = $db->query('select * from items where id=' . $i);
        $items = $query->fetchArray(SQLITE3_ASSOC);
        if (isset($items['id'])) {
            echo '
                <td><a href="admin.php?editid= ' . $items['id'] . '"><i class="fa fa-pencil-square-o"></i></a></td>
                <td><a href="admin.php?deleteid=' . $items['id'] . '"><i class="fa fa-trash-o"></i></a></td>
                <td><a href="admin.php?editid=' . $items['id'] . '">' . $items['id'] . '</a></td>
                <td>' . $items['name'] . '</td><td>' . $items['price30'] . '</td>
                <td>' . $items['price60'] . '</td>
                <td>' . $items['picture'] . '</td>
                <td>' . $items['description'] . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

class Order {

    public $id;
    public $status;
    public $orderid;
    public $cus_name;
    public $cus_tel;
    public $cus_email;
    public $cus_addr;
    public $item;
    public $price;
    public $quan;

    function __construct($customer, $comment) {

        $order = $_SESSION['current_order'];
        $n = count($order);
        $date = date("m.d.y") . ' : ' . date("H:i:s");
        $db = new SQLite3('data.db');
        $query = $db->query('select orderid from orders where orderid=(select max(orderid) from orders)');
        $var = $query->fetchArray(SQLITE3_ASSOC);
        $orderid = $var['orderid'] + 1;
        $result = $db->query('select id from orders where id=(select max(id) from orders)');
        $last_id = $result->fetchArray(SQLITE3_ASSOC);
        $lastid = $last_id['id'];
        for ($i = 0; $i < $n; $i++) {
            $lastid++;
            $query = 'insert into orders 
                    (id, status, orderid, cus_name, cus_tel, cus_email, cus_addr, item, price, quan, comment, date)
                    values
                    ("' . $lastid . '", "В обработке", "' . $orderid . '", "' . $customer->name . '", "' . $customer->tel_num . '", "' . $customer->email .
                    '", "' . $customer->address . '", "' . $order[$i]['item'] . '", "' . $order[$i]['price'] . '", "' . $order[$i]['quan'] . '", "' . $comment . '" , "' . $date . '")';

            $db->exec($query);
        }
        $this->clear();
        $this->sendMail();
    }

    function clear() {
        unset($_SESSION['current_order']);
    }

    function sendMail() {
        $to = 'candy-09@yandex.ru';
        $subject = 'Поступил новый заказ';
        $message = 'New order';
        mail($to, $subject, $message);
    }

}


Class User {

    public $username;
    public $pswd;

    function logIn($username, $password) {
        $this->username = $username;
        $db = new SQLite3('data.db');
        $result = $db->query('select pswd from users where name="' . $this->username . '"')->fetchArray(SQLITE3_ASSOC);
        $this->pswd = $result['pswd'];
        if ($this->pswd == $password)
            return true;
    }

    function logOut() {
        
    }

}

class ProductItems {

    public $id;
    public $name;
    public $price30;
    public $price60;
    public $picture;
    public $description;

    function __construct($name, $price30, $price60, $picture, $description) {
        $db = new SQLite3('data.db');
        $query = $db->query('select id from items where id=(select max(id) from items)');
        $items = $query->fetchArray(SQLITE3_ASSOC);
        $n = $items['id'] + 1;
        $this->id = $n;
        $this->name = $name;
        $this->price30 = $price30;
        $this->price60 = $price60;
        $this->picture = $picture;
        $this->description = $description;
        //пишем в базу
        $query = '
                insert into items 
                (id, name, price30, price60, picture, description)
                values
                (' . $n . ', "' . $name . '", "' . $price30 . '", "' . $price60 . '", "' . $picture . '", "' . $description . '")';
        $db->exec($query);
    }

}


function showAllOrders() {
    $db = new SQLite3('data.db');
    if (!isset($_GET['orderid'])) {
        $query = 'select id from orders where id=(select max(id) from orders)';
        $maxid = $db->query($query);
        $result = $maxid->fetchArray(SQLITE3_ASSOC);
        $n = $result['id'];
        echo '<table border=1>';
        echo '<tr><td></td><td>дата</td><td>номер</td><td>состояние</td><td>клиент</td><td>номер телефона</td>'
            . '<td>email</td><td>адрес</td><td>сумма заказа</td><td>комментарий</td></tr>';
        for ($i = $n; $i >= 1; $i--) {
            $query = 'select * from orders where orderid =' . $i;
            $result = $db->query($query)->fetchArray(SQLITE3_ASSOC);
            if (isset($result['orderid'])) {
                echo '<tr>';
                if ($result['status'] == 'В обработке') {
                    echo '<td><a href="admin.php?tab=orders&updid=' . $result['orderid']
                        . '"><i class="fa fa-check-square-o"></i></a></td>';
                } else {
                    echo '<td></td>';
                }
                echo '<td>' . $result['date'] . '</td>';
                echo '<td><a href="admin.php?tab=orders&orderid=' . $result['orderid'] . '">' . $result['orderid'] . '</a></td>';                
                echo '<td>' . $result['status'] . '</td>';
                echo '<td>' . $result['cus_name'] . '</td>';
                echo '<td>' . $result['cus_tel'] . '</td>';
                echo '<td>' . $result['cus_email'] . '</td>';
                echo '<td>' . $result['cus_addr'] . '</td>';
                echo '<td>' . orderCost($i) . '</td>';
                echo '<td>' . $result['comment'] . '</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    } else {
        showExactOrder($_GET['orderid']);
    }
    $db->close();
}

function showExactOrder($orderid) {
    $db = new SQLite3('data.db');
    $query = 'select * from orders where id=(select max(id) from orders)';
    $maxid = $db->query($query);
    $result = $maxid->fetchArray(SQLITE3_ASSOC);
    $n = $result['id'];
    $query = 'select * from orders where orderid =' . $orderid;
    $result = $db->query($query)->fetchArray(SQLITE3_ASSOC);
    echo '<a> #: ' . $orderid . '</a><br><a> состояние: ' . $result['status'] . '</a><br>';
    echo '<a> клиент: ' . $result['cus_name'] . '</a><br>';
    echo '<a> номер телефона: ' . $result['cus_tel'] . '</a><br>';
    echo '<a> адрес: ' . $result['cus_addr'] . '</a><br>';
    echo '<a> комментарий: ' . $result['comment'] . '</a><br>';
    echo '<table border=1>';
    for ($i = 1; $i <= $n; $i++) {
        $query = 'select * from orders where id =' . $i;
        $result = $db->query($query)->fetchArray(SQLITE3_ASSOC);
        if ($result['orderid'] == $orderid) {
            echo '<tr>';
            echo '<td>' . $result['item'] . '</td>';
            echo '<td>' . $result['price'] . '</td>';
            echo '<td>' . $result['quan'] . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
    echo 'Сумма заказа: ' . orderCost($orderid);
    $db->close();
}

function orderCost($orderid) {
    $db = new SQLite3('data.db');
    $query = 'select id from orders where id=(select max(id) from orders)';
    $result = $db->query($query)->fetchArray(SQLITE3_ASSOC);
    $n = $result['id'];
    $order_cost = 0;
    for ($i = 1; $i <= $n; $i++) {
        $query = 'select * from orders where id =' . $i;
        $result = $db->query($query)->fetchArray(SQLITE3_ASSOC);
        if ($result['orderid'] == $orderid) {
            $order_cost = $order_cost + $result['price'] * $result['quan'];
        }
    }
    $db->close();
    return $order_cost;
}


function initDB() {
    $db = new SQLite3('data.db');

//	$db->exec('CREATE TABLE items (id INT AUTO_INCREMENT, name TEXT, price30 FLOAT(10,2), price60 FLOAT(10,2), picture TEXT, description TEXT)');
//	$db->exec('insert into items (id, name, price30, price60, picture, description) values ("1", "Гавайская", "58.99", "220", "pics/2.jpg", "Описание Гавайской пиццы")');
//	$db->exec('insert into items (id, name, price30, price60, picture, description) values ("2", "Чика", "58.99", "220", "pics/1.jpg", "Хорошее и полное описание Чики")');
//		$db->exec('drop table orders');
// добавить триггеры и перевести в varchar(36)		
//		$db->exec('create table orders 
//		(id INT, status TEXT, orderid int, cus_name TEXT, cus_tel TEXT, cus_email TEXT, cus_addr TEXT, item TEXT, price FLOAT, quan FLOAT,  comment TEXT)');
//        $db->exec('drop table users');
//        $db->exec('create table users (name TEXT, pswd TEXT)');
//        $db->exec('insert into users (name, pswd) values ("admin", "123")');
}
