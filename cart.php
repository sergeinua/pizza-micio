<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Pizza Micio</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">

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
        ?>
        <div class="container">
            <div class="row">
                <h1>Корзина</h1>
                <div class="navbar navbar-inverse navbar-fixed-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="http://pizza-micio.kiev.ua"><img class="brand" src="/pics/logo.gif"></a>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
                                <span class="sr-only">Меню</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="responsive-menu">
                            <ul class="nav navbar-nav">
                                <li><a href="http://pizza-micio.kiev.ua">Главная</a></li>
                                <li><a href="/pizza.php">Пиццы</a></li>
                                <li><a href="/contacts.html">Контакты</a></li>
                                <li><a href="/cart.php">Корзина</a></li>
                                <li><a href="http://pizza-micio.kiev.ua"><img id="tel_num" src="/pics/tel_num.gif"></a></li>
                                <li><a>бесплатная доставка по Киеву</a></li>
                                <li><a href="https://www.facebook.com/PizzaMicioKiev"><i id="facebook" class="fa fa-facebook-square"></i></a></li>
                            </ul>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?php
                        include 'functions.php';
                        $cart = new Cart();
                        $cart->load();
                        if (isset($_SESSION['order_made'])) {
                            $cart->orderMade();
                        } else $cart->isEmpty();
                    ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <?php
                        if (isset($_SESSION['current_order'])) {
                            if (count($_SESSION['current_order']) > 0) {
                                showDeliveryDetails();
                            }
                        }                        
                    ?>
                </div>
            </div>
        </div>
      

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.js"></script>
    </body>
</html>