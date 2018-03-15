<?php
session_start();
if (!$_SESSION['user_id']) {
    header("Location:login.php");
}
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
                        <li class="#"><a href="#">歡迎 <?php echo $_SESSION['name'] ?></a></li>
                        <li class="#"><a href="#">購物車</a></li>
                        <li class="#"><a href="logout.php">登出</a></li>
                    </ul>
                </div>	
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="goodslist">
                <div class="bs-example">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="glyphicon glyphicon-align-justify"> </th>
                                <th>商品名稱</th>
                                <th>商品簡介</th>
                                <th>價位</th>
                                <th>修改</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 1; $i < 5; $i++) {
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>商品名稱$i</td>";
                                echo "<td>商品簡介$i</td>";
                                echo "<td>". $i * 100 ."</td>";
                                echo'<td>
                                    <button type="button" class="btn btn-info">修改</button>
                                    <button type="button" class="btn btn-danger">刪除</button>
                                </td>';

                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bs-example">
            <p>免責聲明：本站為第三方交易服務平台，鑒於網路的性質，本站無法鑒別判斷交易方物品來源及歸屬權。敬請交易雙方事前辨明。本站不希望出現任何物品交易糾紛，
                如果出現交易歸屬權糾紛，請您直接與交易另一方聯絡解決。如交易一方違反法律規定而出現糾紛與及不良結果，由行爲人獨立承擔所有責任，本
                站概不負責也不承擔任何法律責任。</p>
        </div>
    </div>
    <script src="dist/js/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
</body>
</html>