<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="files/bootstrap/3/css/bootstrap.css" />
    <script type="text/javascript" src="files/js/jquery.js"></script>
    <script type="text/javascript" src="files/bootstrap/3/js/bootstrap.js"></script>
    <link rel="stylesheet" href="files/css/login.css">
    <link rel="shortcut icon" href="img/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Felux - Shop Register</title>
</head>
<body>
    <div class="container">                  
        <div class="row">
            <form class="login" method="post" action="{{ url('signupform') }}">
                <h4><b><span class="glyphicon glyphicon-fire"></span> FELUX SHOP - Register</b></h4>
                @if(session('error'))
                    <div class='alert alert-dismissible alert-info'>
                        <button type='button' class='close' data-dismiss='alert'>×</button>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password_signup" placeholder="Password" required>
                <input type="password" name="password_signup2" placeholder="Confirm Password" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit" id="divButton">Register</button> 
                <button type="button" class="register" onclick="window.location.href = 'login.html'">Login</button>
            </form>
        </div>
    </div>
</body>
</html>