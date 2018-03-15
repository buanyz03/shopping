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
        <title>shopping</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="dist/css/docs.min.css">
        <script type="text/javascript" src="dist/js/jquery.min.js"></script>
    </head>
    <body>	
        <div class="container"> 
            <h1 class="glyphicon glyphicon-cog overview-normalize">加入購物車</h1>
        </div>
        <div class="bs-example"> 
            <div class="row ">
                <div class=" col-md-4">
                    <?php
                    include("db.php");

                    $good_id = mysql_escape_string($_POST['good_id']);
                    $good_info = mysql_fetch_row(
                            mysql_query(
                                    "SELECT users.name, type.name, goods.name, price, title, description, added_time, buy_count, current_count, image_src " .
                                    "FROM goods LEFT JOIN users ON user_id = seller_id " .
                                    "LEFT JOIN type ON type.type_id = goods.type_id " .
                                    "WHERE good_id = $good_id"
                            )
                    );
                    $curCount = $good_info[8];
                    echo '<span class="context">' . $good_info[4] . '</span><br>';
                    echo '<span class="context">賣家名稱：' . $good_info[0] . '</span><br>';
                    echo '<span class="context">商品類別：' . $good_info[1] . '</span><br>';
                    echo '<span class="context">商品名稱：' . $good_info[2] . '</span><br>';
                    echo '<span class="context">商品單價：' . $good_info[3] . '</span><br>';
                    echo '<span class="context">商品描述：' . $good_info[5] . '</span><br>';
                    echo '<span class="context">新增時間：' . $good_info[6] . '</span><br>';
                    echo '<span class="context">賣出數量：' . $good_info[7] . '</span><br>';
                    echo '<span class="context">剩餘數量：' . $curCount . '</span><br>';
                    ?>
                    <span class="context">訂購數量</span>
                    <select id="goodsnum" class="form-control" >
                        <?php
                        for ($i = 1; $i <= $curCount; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>

                    <span class="context">付款方式</span>
                    <select id="payment" class="form-control" >
                        <option value="self">面交自取</option>
                        <option value="seven">7-11取貨付款</option>
                    </select>
                </div>
                <div class="col-md-6">

                    <img id="preview" style="width: 500px; height: auto;" src="<?php if ($good_info[9] == '') {
                            echo "images/empty.jpg";
                        } else {
                            echo $good_info[9];
                        } ?>" alt="商品">  
                </div>
            </div>
            <button class="btn btn-success" type="submit" onclick="ok_mod()">確認</button>
            <button class="btn btn-danger" type="submit" onclick="undo()">取消</button>     

        </div>	 

    </body>
</html>

<script>

    function ok_mod() {
        var json = {
            good_id:<?php echo $good_id; ?>,
            goodsnum: $("#goodsnum").val(),
            payment: $("#payment").val(),
            select: 'shopingbuy'
        };

        $.post(
                "shoping_api.php",
                json,
                function(data) {
                    console.log(data);
                    if (data == 'success') {
                        alert("已加入購物車!");
                        undo();
                    }
                }
        );
    }

    function undo() {
        $.post("goods_list.php",
                {type_id: 0},
        function(data) {
            $('#goodframe').html(data);
        }, "html");
    }
</script>