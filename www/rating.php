<?php
session_start();
if (!$_SESSION['user_id']) {
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <body>	
        <div class="container"> 
            <h1 class="glyphicon glyphicon-cog overview-normalize">使用者資訊</h1>
        </div>

        <div class="bs-example"> 
            <div class="row ">
                <div class=" col-md-4">
                    <?php
                    include("db.php");

                    $role = mysql_escape_string($_POST['role']);
                    $order_id = mysql_escape_string($_POST['order_id']);
                    $cur_user_id = $_SESSION['user_id'];

                    if ($role == "seller") {
                        $data = mysql_query(
                                "SELECT order_id, goods.name, good_num, goods.price * good_num, payment, buyer_id, seller_id  " .
                                "FROM goods_order LEFT JOIN goods " .
                                "ON goods_order.good_id = goods.good_id " .
                                "WHERE status = 'finish' AND seller_id = '$cur_user_id' AND order_id = $order_id"
                        );
                    } else {
                        $data = mysql_query(
                                "SELECT order_id, goods.name, good_num, goods.price * good_num, payment, buyer_id, seller_id  " .
                                "FROM goods_order LEFT JOIN goods " .
                                "ON goods_order.good_id = goods.good_id " .
                                "WHERE status = 'finish' AND buyer_id = '$cur_user_id' AND order_id = $order_id"
                        );
                    }

                    $order_info = mysql_fetch_row($data);

                    if (mysql_errno() != 0) {
                        echo mysql_errno() . ": " . mysql_error(); //show other error
                    }
                    echo '<span class="context">商品名稱：' . $order_info[1] . '</span><br>';
                    echo '<span class="context">訂購數量：' . $order_info[2] . '</span><br>';
                    echo '<span class="context">總價：' . $order_info[3] . '</span><br>';
                    echo '<span class="context">付款方式：' . $order_info[4] . '</span><br>';

                    echo '<span class="context">買家代號：' . $order_info[5] . '</span><br>';
                    echo '<span class="context">賣家代號：' . $order_info[6] . '</span><br>';
                    ?>

                    <span class="context">評分(1~5)</span>
                    <input id="rate_score" type="number" min="1" max ="5" value="4" style="width: 100px;">

                </div>
                <div class="col-md-6"></div>
            </div>
            <button class="btn btn-success" type="submit" onclick="submit()">確定</button>   
            <button class="btn btn-danger" type="submit" onclick="undo()">返回</button>            
        </div>	 	
    </body>
</html>

<script>
    function submit() {
        if (confirm("評分給定後後將無法更改，確認送出？") === true) {
            $.post('shoping_api.php', {
                order_id: '<?php echo $_POST['order_id']; ?>',
                role: '<?php echo $_POST['role']; ?>',
                score: $("#rate_score").val(),
                select: 'rateOrder'
            },
            function(data) {
                console.log(data);
                if (data == 'success') {
                    undo();
                }
            });
        }
    }

    function undo() {
        $.get('<?php echo $_POST['prepage']; ?>.php').success(function(data) {
            $('#goodframe').html(data);
        });
    }
</script>