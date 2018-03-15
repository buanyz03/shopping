<!DOCTYPE html>
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
                        <th>商品介紹</th>
                        <th>價錢</th>
                        <th>已購買</th>
                        <th>剩餘數量</th>                        
                        <th>賣家帳號</th>
                        <th>加入時間</th>
                        <th>功能</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start();
                    $cur_user_id = $_SESSION['user_id'];
                    include("db.php");
                    $filter = mysql_escape_string($_POST['type_id']);
                    $filter_name = mysql_fetch_row(mysql_query("SELECT name FROM type WHERE type_id = $filter;"))[0];

                    echo "所有$filter_name";
                    $data = mysql_query("SELECT good_id, name, description, price, buy_count, current_count, seller_id, added_time, seller_id FROM goods " .
                            "WHERE current_count > 0 AND type_id IN ( SELECT type_id FROM type WHERE parent_id = $filter OR type_id = $filter );");
                    //has a bug tree level can't deep than two
					
                    while ($row = mysql_fetch_row($data)) {
                        echo'<tr>
                    <td>' . $row[1] . '</td>
                    <td>' . $row[2] . '</td>
                    <td>' . $row[3] . '</td>
                    <td>' . $row[4] . '</td>
                    <td>' . $row[5] . '</td>
                    <td>' . $row[6] . '</td>
                    <td>' . $row[7] . '</td> <td>';

                        if ($cur_user_id != '' && $cur_user_id == $row[6]) {
                            echo "<button class=\"btn btn-warning\" type=\"submit\" onclick=\"edit($row[0])\">編輯</button>";
                        } else {
                            echo "<button class=\"btn btn-info\" type=\"submit\" onclick=\"buy($row[0])\">買</button>";
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
            function buy(good_id) {
                $.post('buygoods.php', {good_id: good_id}, function(data) {
                    $('#goodframe').html(data);
                });
            }

            function edit(good_id) {
                $.post('addgoods.php', {good_id: good_id}, function(data) {
                    $('#goodframe').html(data);
                });
            }


        </script>
    </body>
</html>
