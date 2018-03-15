<html>
    <head>
        <title>會員登入</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">	
        <script src="dist/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="login.css" >
    </head>

    <body>
        <div class="container">

            <div align="center">
                <form class="form-signin form-group has-success" name="form1" method="POST" action="logincheck.php">
                    <h2 class="form-signin-heading ">會員登入</h2>
                    <input type="text" class="form-control"  name="account" placeholder="account" required autofocus>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <label class="checkbox ">
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                    <button class="btn btn-info btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>


        </div> 

    </body>
</html>