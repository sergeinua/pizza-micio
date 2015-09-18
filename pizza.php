<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Самая большая пицца Киева бесплатная доставка пиццы 60 см киев
    бесплатная доставка пиццы оболонь бесплатная доставка пиццы петровка доставка пиццы куреневка доставка пиццы киев">
    <title>Pizza Micio</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="body">   
   <?php
        if (session_status() < 2) {
            session_start();
        }
        require_once 'functions.php';
        $cart = new smallCart;
        if (isset($_GET['clear'])) {
            $cart->clear();
            header('location:'.$_SERVER['HTTP_REFERER']);
        }	
        if (isset($_GET['increase'])) {                
            $cart->increase($_GET['increase']);
            header('location:'.$_SERVER['HTTP_REFERER']);
        }
        if (isset($_GET['decrease'])) {
            $cart->decrease($_GET['decrease']);
            header('location:'.$_SERVER['HTTP_REFERER']);
        }	
        if (isset($_GET['delete'])) {
            $cart->delete($_GET['delete']);
            header('location:'.$_SERVER['HTTP_REFERER']);
        }
    ?>
    <div class="container">
        <div class="row">
           <h1>Список пицц</h1>
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
                            <span class="sr-only">Меню</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="responsive-menu">
                        <ul class="nav navbar-nav">
                            <li><a href="http://localhost">Главная</a></li>
                            <li><a href="/pizza.php">Пиццы</a></li>
                            <li><a href="/contacts.html">Контакты</a></li>
                            <li><a href="cart.php">Корзина</a></li>
                        </ul>
                    </div>      
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                  <!--плитка здесь-->
                    <?php
                       $items = new Items;
                       $items->loadGrid();
                    ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
               <div class="small_cart">
                    <!--корзина здесь--> <a id="your_order_label">Ваш заказ</a>
                    <i class="fa fa-cart-plus"></i>                    
                        <?php
                            $cart = new smallCart();
                            $cart->load();
                        ?>
                </div>
            </div>
        </div>
    </div>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  </body>
</html>