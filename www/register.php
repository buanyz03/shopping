
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
        <title>會員註冊</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="dist/css/docs.min.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

        <script type="text/javascript">

            function chk() {
                function showalert(message, alerttype) {
                    $("#alertdiv").remove();
                    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' + alerttype + '"><a class="close" data-dismiss="alert">×</a><span>' + message + '</span></div>')
                }


                if (document.form1.name.value == '') {
                    showalert('姓名未填！', 'alert-danger');
                    document.form1.name.focus();
                    return false;
                }
                if (document.form1.account.value == '') {
                    showalert('帳號未填！', 'alert-danger');
                    document.form1.account.focus();
                    return false;
                }


                if (document.form1.password.value == '') {
                    showalert('密碼未填！', 'alert-danger');
                    document.form1.password.focus();
                    return false;
                }
                if (document.form1.password.value !== document.form1.password2.value) {
                    showalert('密碼不符！', 'alert-danger');
                    document.form1.password2.focus();
                    return false;
                }
                if (document.form1.email.value == '') {
                    showalert('信箱未填！', 'alert-danger');
                    document.form1.email.focus();
                    return false;
                }
                return true;
            }
        </script>

    </head>

    <body >
        <div id="alert_placeholder">
        </div>
        <div class="container">


            <div align="center" class ="row">
                <h1><small>會員註冊</small></h1>

                <form name="form1" class="row col-xs-4 col-xs-offset-4" method="post"  name="form1" action="regcheck.php" onsubmit="return chk();">
                    <div class="input-group">
                        <span class="input-group-addon">姓&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp名</span>
                        <input type="text" class="form-control" name="name" >
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">登入帳號</span>
                        <input type="text" class="form-control" name="account">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">密&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp碼</span>
                        <input type="password" class="form-control" name="password" >
                    </div>  

                    <div class="input-group">
                        <span class="input-group-addon">密碼確認</span>
                        <input type="password" class="form-control" name="password2" >
                    </div>      

                    <div class="input-group">
                        <span class="input-group-addon">註冊信箱</span>
                        <input type="email" class="form-control"  name="email">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">市&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp話</span>
                        <input type="text" class="form-control" name="phone" placeholder="02-1234567">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">手&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp機</span>
                        <input type="text" class="form-control" name="mobilephone" placeholder="0911-111-111" >
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">住家地址</span>
                        <input type="text" class="form-control" name="live_in">
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">性&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp別</span>
                        <select name="sex"class="form-control" >
                            <option value="u">不公開</option>
                            <option value="m">男生</option>
                            <option value="f">女生</option>
                        </select>
                    </div> 
                    <br>
                    <button class="btn btn-success" type="submit">Sumit</button>

                </form>	
            </div>
        </div>

        <script src="dist/js/jquery.min.js"></script>
        <script src="../../dist/js/bootstrap.min.js"></script>
    </body>
</html>