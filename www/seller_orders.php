<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
        <script src="dist/js/jquery.min.js"></script>
        <link  rel="stylesheet" href="jquery/jquery.dataTables.css">
        <script type="text/javascript" src="jquery/jquery.min.js"></script>
        <script type="text/javascript" src="jquery/jquery.dataTables.min.js"></script>
        <title>shopping</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="dist/css/docs.min.css">
    </head>
    <body>
        <div class="bs-example">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>商品名稱</th>
                        <th>加入時間</th>
                        <th>數量</th>
                        <th>總價格</th>
                        <th>付款方式</th>
                        <th>狀態</th>
                        <th>賣家評分</th>
                        <th>買家評分</th>
                        <th>功能</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("db.php");
                    $cur_user_id = $_SESSION['user_id'];
                    $filter = mysql_escape_string($_POST['type_id']);
                    $filter_name = mysql_fetch_row(mysql_query("SELECT name FROM type WHERE type_id = $filter;"))[0];

                    echo "所有$filter_name";

                    $data = mysql_query(
                            "SELECT order_id, buyer_id, goods.name, goods_order.added_time, status, good_num, goods.price * good_num, payment " .
                            "FROM goods_order LEFT JOIN goods " .
                            "ON goods_order.good_id = goods.good_id " .
                            "WHERE status != 'in_car' AND seller_id = '$cur_user_id'"
                    );


                    while ($row = mysql_fetch_row($data)) {

                        echo'<tr>
                            <td>' . $row[2] . '</td>
                            <td>' . $row[3] . '</td>
                            <td>' . $row[5] . '</td>
                            <td>' . $row[6] . '</td>
                            <td>' . $row[7] . '</td>
                            <td>' . $row[4] . '</td> <td>';

                        if ($row[4] == "finish") {
                            $sellerRateData = mysql_query("SELECT score FROM rating WHERE order_id = '$row[0]' AND role = 'seller'");
                            $sellerRateCount = mysql_num_rows($sellerRateData);
                            $sellerScore = mysql_fetch_row($sellerRateData);

                            if ($sellerRateCount == 0) {
                                echo "<button class=\"btn btn-warning btn-sm\" type=\"submit\" onclick=\"rateOrder('$row[0]')\">評分</button>";
                            } else {
                                echo "$sellerScore[0]";
                            }
                            echo "</td><td>";

                            $buyerRateData = mysql_query("SELECT score FROM rating WHERE order_id = '$row[0]' AND role = 'buyer'");
                            $buyerRateCount = mysql_num_rows($buyerRateData);
                            $buyerScore = mysql_fetch_row($buyerRateData);

                            if ($buyerRateCount == 0) {
                                echo "未評分";
                            } else {
                                echo "$buyerScore[0]";
                            }
                            echo "</td><td>";
                        } else {
                            echo "交易中</td><td>交易中</td><td>";
                        }

                        echo "<button class=\"btn btn-primary\" type=\"submit\" onclick=\"contact('$row[1]')\">買家資訊</button>";
                        if ($row[4] == "submit") {
                            echo "<button class=\"btn btn-warning\" type=\"submit\" onclick=\"shipOrder('$row[0]')\">開始出貨</button>";
                        }


                        echo'</td></tr>';
                    }
                    if (mysql_errno() != 0) {
                        echo mysql_errno() . ": " . mysql_error() . "<br>"; //show other error
                    }
                    ?> 
                </tbody>
            </table>
        </div>


        <script>
            $(document).ready(function()
            {
                $("#table1").dataTable();
            });

            function contact(buyer_id) {
                $.post(
                        "userInfo.php", {
                            prepage: 'seller_orders',
                            user_id: buyer_id},
                function(data) {
                    $('#goodframe').html(data);
                }, "html"
                        );
            }

            function shipOrder(order_id) {
                $.post('shoping_api.php', {
                    order_id: order_id,
                    select: 'shipOrder'
                },
                function(data) {
                    console.log(data);
                    if (data == 'success') {
                        $.get('seller_orders.php').success(function(data) {
                            $('#goodframe').html(data);
                        });
                    }
                });
            }
            function rateOrder(order_id) {
                $.post("rating.php", {
                    prepage: 'seller_orders',
                    role: 'seller',
                    order_id: order_id
                },
                function(data) {
                    $('#goodframe').html(data);
                }, "html");
            }
        </script>
    </body>
</html>
