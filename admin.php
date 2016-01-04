<?php
    include 'functions.php';
    adminIsLogged();
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Самая большая пицца Киева бесплатная доставка пиццы 60 см киев
        бесплатная доставка пиццы оболонь бесплатная доставка пиццы петровка доставка пиццы куреневка доставка пиццы киев">
        <title>Админ панель</title>

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
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img class="brand" src="/pics/logo.gif">
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
        <div class="col-lg-2 col-md-2 col-sm-1 col-xs-1">
            <div class="admin_menu">
                <ul>
                    <li><a href="admin.php?tab=items">Каталог продукции</a></li>
                    <li><a href="admin.php?addnew">Добавить товар</a></li>
                    <li><a href="admin.php?tab=orders">Заказы</a></li>
                    <li><a href="admin.php?tab=password">Изменить пароль</a></li>
                    <li><a href="admin.php?tab=quit">Выйти</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-11 col-xs-11">
            <div class="admin_tab">
                <?php
                adminCheckStatus();
                adminLoadTab();
                ?>
            </div>
        </div>


    </body>
</html>