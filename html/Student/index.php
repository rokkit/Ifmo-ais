<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title></title>
    <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/content/css/bootstrap-responsive.min.css">
    <link type="text/css" rel="stylesheet" href="/content/css/student-main.css">
    <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
</head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav">
                <li class="active">
                    <a href="#">Home</a>
                </li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container" id="container-auth">
    <div style="width: 400px;margin-left: 250px;">
        <form class="form well truewell" id="auth-form" action="/php_script/validation.php" method="POST">
            <input type="text" id="login-input" name="login" class="input-medium" placeholder="Email"></br>
            <input type="password" id="pass-input" name="pass" class="input-medium" placeholder="Password"></br>
            <button type="submit" class="btn btn-primary">Войти в систему</button>
        </form>
    </div>
</div>
</body>
</html>