<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
        <title>購物首頁</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="dist/css/docs.min.css">
        <script type="text/javascript" src="dist/js/jquery.min.js"></script> 
    </head>
    <div class="container">
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    </button>
                    <a class="navbar-brand" href="index.php">Shopping</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php
                        if ($_SESSION['user_id']) {//if login
                            echo '<li class="#"><a href="#">歡迎 ' . $_SESSION['name'] . '</a></li>';
                            echo '<li id ="seller_orders" class="#"><a href="#">客戶訂單</a></li>';
                            echo '<li id ="addgoods" class="#"><a href="#">新增商品</a></li>';
                            echo '<li id ="cart" class="#"><a href="#">購物車</a></li>';
                            echo '<li id ="bought" class="#"><a href="#">已購買</a></li>';
//                            echo '<li class="#"><a href="seller.php">賣家功能</a></li>';
                            echo '<li id ="acc" class="#"><a href="#">管理</a></li>';
                            echo '<li class="#"><a href="logout.php">登出</a></li>';
                        } else {
                            echo '<li id ="login" class="#"><a href="#">會員登入</a></li>';
                            echo '<li id ="register" class="#"><a href="#">免費註冊</a></li>';
                        }
                        ?>
                    </ul>
                </div>	
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <ul class="list-group">
                    <li class="list-group-item" id="allgoods"><a href="#">所有商品</a></li>
                    <li class="list-group-item" id="3cprod" name="qa"><a href="#">3C產品</a></li>
                    <li class="list-group-item" id="manprod"><a href="#">男性用品</a></li>
                    <li class="list-group-item" id="woprod"><a href="#">女性用品</a></li>	
                    <li class="list-group-item" id="bookprod"><a href="#">書籍</a></li>	
                    <li class="list-group-item" id="foodprod"><a href="#">食品</a></li>	
                </ul>
            </div>
            <div class="col-md-10" id="goodframe">
            </div>
        </div>
        <div class="bs-example">
            <p>免責聲明：本站為第三方交易服務平台，鑒於網路的性質，本站無法鑒別判斷交易方物品來源及歸屬權。敬請交易雙方事前辨明。本站不希望出現任何物品交易糾紛，
                如果出現交易歸屬權糾紛，請您直接與交易另一方聯絡解決。如交易一方違反法律規定而出現糾紛與及不良結果，由行爲人獨立承擔所有責任，本
                站概不負責也不承擔任何法律責任。</p>
        </div>
        <footer><p>Copyright © 2018 </p></footer>
    </div>
    <script src="dist/js/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>

    <script>
        function loadList(filter_type) {
            $.post(
                    "goods_list.php",
                    {type_id: filter_type},
            function(data) {
                $('#goodframe').html(data);
            }, "html"
                    );
        }

        $(document).ready(function() {
            loadList(0);
        });
        $('#allgoods').click(function() {
            loadList(0);
        });

        $('#3cprod').click(function() {
            loadList(1);
        });
        $('#manprod').click(function() {
            loadList(2);
        });
        $('#woprod').click(function() {
            loadList(3);
        });
        $('#bookprod').click(function() {
            loadList(4);
        });
        $('#foodprod').click(function() {
            loadList(5);
        });

<?php
if ($_SESSION['user_id']) {//if login
    echo "\$('#seller_orders').click(function() {\$.get('seller_orders.php').success(function(data) { \$('#goodframe').html(data);});});";
    echo "\$('#addgoods').click(function() {\$.get('addgoods.php').success(function(data) { \$('#goodframe').html(data);});});";
    echo "\$('#cart').click(function() {\$.get('cart.php').success(function(data) { \$('#goodframe').html(data);});});";
    echo "\$('#bought').click(function() {\$.get('bought.php').success(function(data) { \$('#goodframe').html(data);});});";
    echo "\$('#acc').click(function() {\$.get('updateInfo.php').success(function(data) { \$('#goodframe').html(data);});});";    
} else {
    echo "\$('#login').click(function() {\$.get('login.php').success(function(data) { \$('#goodframe').html(data);});});";
    echo "\$('#register').click(function() {\$.get('register.php').success(function(data) { \$('#goodframe').html(data);});});";
}
?>

    </script>
                
</body>
</html>