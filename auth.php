<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="newstyle.css" />
        <title>Зайдите в аккаунт</title>
    </head>
    <body class="body">
        <div class="auth_form">
            <form action="auth.php" method="post">
                <div class="form-group">   
                    <div class="login-form">
                        <input class="login-field" type="text" name="username" value placeholder="login">
                        <img class="glyphicon" src="pics/glyphs/user.svg">
                    </div>
                </div>
                <div class="form-group">   
                    <div class="login-form">
                        <input class="password" type="password" name="password" value placeholder="password">
                        <img class="glyph_pswd" src="pics/glyphs/key.svg">
                    </div>
                </div>
                <div class="btn"> 
                    <input class="button" type="submit" value="войти">
                </div>
            </form>
        </div>
         <?php
            require 'functions.php';
            if (session_status() < 2)
                session_start ();
            if(isset($_POST['username'])) {
                $user = new User();
                if ($user->logIn($_POST['username'], $_POST['password']) == true) {
                    $_SESSION['current_user'] = $_POST['username'];
                    header('location: admin.php');
                } else 
                    echo '<br>неверно введено имя пользователя или пароль<br>';
            }
        ?>
    </body>
</html>