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
                            "SELECT order_id, seller_id, goods.name, goods_order.added_time, status, good_num, goods.price * good_num, payment " .
                            "FROM goods_order LEFT JOIN goods " .
                            "ON goods_order.good_id = goods.good_id " .
                            "WHERE status = 'in_car' AND buyer_id = '$cur_user_id'"
                    );

                    while ($row = mysql_fetch_row($data)) {

                        echo'<tr>
                            <td>' . $row[2] . '</td>
                            <td>' . $row[3] . '</td>
                            <td>' . $row[5] . '</td>
                            <td>' . $row[6] . '</td>
                            <td>' . $row[7] . '</td> <td>';

                        echo "<button class=\"btn btn-primary\" type=\"submit\" onclick=\"submitOrder($row[0])\">送出</button>";
                        echo "<button class=\"btn btn-danger\" type=\"submit\" onclick=\"deleteOrder($row[0])\">移除</button>";
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

            function submitOrder(order_id) {
                if (confirm("訂單送出後將無法刪除，確認送出？") === true) {
                    $.post('shoping_api.php', {
                        order_id: order_id,
                        select: 'submitOrder'
                    },
                    function(data) {
                        console.log(data);
                        if (data == 'success') {
                            $.get('cart.php').success(function(data) {
                                $('#goodframe').html(data);
                            });
                        } else {
                            alert("抱歉，您要的商品已先被別人買走了，該項目已從購物車中移除。");
                        }
                    });
                }
            }
            function deleteOrder(order_id) {
                $.post('shoping_api.php', {
                    order_id: order_id,
                    select: 'deleteOrder'
                },
                function(data) {
                    console.log(data);
                    if (data == 'success') {
                        $.get('cart.php').success(function(data) {
                            $('#goodframe').html(data);
                        });
                    }
                });
            }

        </script>
    </body>
</html>
