<?php

session_start();

if (!$_SESSION['user_id']) {
    header("Location:login.php");
}

include("db.php");
header("Content-Type:text/html; charset=utf-8");
switch ($_POST['select']) {
    case 'shopingadd':
        shopingadd();
        break;
    case 'shopingedit':
        shopingedit();
        break;
    case 'shopingbuy':
        shopingbuy();
        break;
    case 'submitOrder':
        submitOrder();
        break;
    case 'finishOrder':
        finishOrder();
        break;
    case 'deleteOrder':
        deleteOrder();
        break;
    case 'shipOrder':
        shipOrder();
        break;
    case 'getGoodInfo':
        getGoodInfo();
        break;
    case 'rateOrder':
        rateOrder();
        break;
}

function shopingadd() {
    $goodsname = mysql_escape_string($_POST["goodsname"]);
    $goodstitle = mysql_escape_string($_POST["goodstitle"]);
    $goodsdes = mysql_escape_string($_POST["goodsdes"]);
    $goodspre = mysql_escape_string($_POST["goodspre"]);
    $goodsnum = mysql_escape_string($_POST["goodsnum"]);
    $image_src = mysql_escape_string($_POST["image_src"]);
    $typeid = mysql_escape_string($_POST["typeid"]);

    $cur_user_id = $_SESSION['user_id'];


    if ($goodsname == null) {
        echo "請填寫商品名稱";
    } else if ($goodsdes == null) {
        echo "請填寫商品描敘";
    } else if ($goodspre == null) {
        echo "請填寫商品價錢";
    } else {
        $str = "INSERT INTO goods(seller_id, type_id, name, price, title, description, current_count, image_src)"
                . "VALUES ('$cur_user_id', $typeid, '$goodsname', $goodspre, '$goodstitle', '$goodsdes', $goodsnum, '$image_src');";
        mysql_query($str);

        if (mysql_errno() != 0) {
            echo mysql_errno() . ": " . mysql_error(); //show other error
        }

        echo "商品新增完成";
    }
}

function shopingedit() {
    $good_id = mysql_escape_string($_POST["good_id"]);

    $goodsname = mysql_escape_string($_POST["goodsname"]);
    $goodstitle = mysql_escape_string($_POST["goodstitle"]);
    $goodsdes = mysql_escape_string($_POST["goodsdes"]);
    $goodspre = mysql_escape_string($_POST["goodspre"]);
    $goodsnum = mysql_escape_string($_POST["goodsnum"]);
    $image_src = mysql_escape_string($_POST["image_src"]);
    $typeid = mysql_escape_string($_POST["typeid"]);

    $cur_user_id = $_SESSION['user_id'];


    if ($goodsname == null) {
        echo "請填寫商品名稱";
    } else if ($goodsdes == null) {
        echo "請填寫商品描敘";
    } else if ($goodspre == null) {
        echo "請填寫商品價錢";
    } else {
        $str = "UPDATE goods " .
                "SET type_id = $typeid, name = '$goodsname', price = $goodspre, " .
                "title = '$goodstitle', description = '$goodsdes', current_count = $goodsnum, image_src = '$image_src' " .
                "WHERE good_id = $good_id;";
        //echo "$str";

        mysql_query($str);

        if (mysql_errno() != 0) {
            echo mysql_errno() . ": " . mysql_error(); //show other error
        }

        echo "商品修改完成";
    }
}

function shopingbuy() {
    $good_id = mysql_escape_string($_POST["good_id"]);
    $goodsnum = mysql_escape_string($_POST["goodsnum"]);
    $payment = mysql_escape_string($_POST["payment"]);

    $cur_user_id = $_SESSION['user_id'];

    $str = "INSERT INTO goods_order(buyer_id, status, good_id, good_num, payment)"
            . "VALUES ('$cur_user_id', 'in_car', $good_id, $goodsnum, '$payment');";
    mysql_query($str);

    if (mysql_errno() != 0) {
        echo mysql_errno() . ": " . mysql_error(); //show other error
    } else {
        echo "success";
    }
}

function submitOrder() {
    $cur_user_id = $_SESSION['user_id'];
    $order_id = mysql_escape_string($_POST["order_id"]);

    $data = mysql_query(
            "SELECT current_count, goods.good_id, good_num " .
            "FROM goods_order " .
            "LEFT JOIN goods " .
            "ON goods_order.good_id = goods.good_id " .
            "WHERE buyer_id = '$cur_user_id' AND order_id = $order_id"
    );

    $order_info = mysql_fetch_row($data);

    $good_count = $order_info[0];
    $good_id = $order_info[1];
    $need_num = $order_info[2];


    if ($good_count < $need_num) {

        echo "not_enough";
    } else {
        mysql_query(
                "UPDATE goods_order " .
                "SET status='submit' " .
                "WHERE buyer_id = '$cur_user_id' AND order_id = $order_id"
        );
        mysql_query(
                "UPDATE goods " .
                "SET current_count = current_count - $need_num, buy_count = buy_count + $need_num " .
                "WHERE good_id = $good_id"
        );
        if (mysql_errno() != 0) {
            echo mysql_errno() . ": " . mysql_error(); //show other error
        } else {
            echo "success";
        }
    }
}

function deleteOrder() {
    $cur_user_id = $_SESSION['user_id'];
    $order_id = mysql_escape_string($_POST["order_id"]);

    $data = mysql_query(
            "DELETE FROM goods_order " .
            "WHERE buyer_id = '$cur_user_id' AND order_id = $order_id AND status = 'in_car'" //can only delete in_car
    );


    if (mysql_errno() != 0) {
        echo mysql_errno() . ": " . mysql_error(); //show other error
    } else {
        echo "success";
    }
}

function shipOrder() {
    //$cur_user_id = $_SESSION['user_id'];
    $order_id = mysql_escape_string($_POST["order_id"]);

    mysql_query(
            "UPDATE goods_order " .
            "SET status='shipping' " .
            "WHERE order_id = $order_id" //has Security concerns
    );

    if (mysql_errno() != 0) {
        echo mysql_errno() . ": " . mysql_error(); //show other error
    } else {
        echo "success";
    }
}

function finishOrder() {
    //$cur_user_id = $_SESSION['user_id'];
    $order_id = mysql_escape_string($_POST["order_id"]);

    mysql_query(
            "UPDATE goods_order " .
            "SET status='finish' " .
            "WHERE order_id = $order_id AND status='shipping'" //has Security concerns
    );

    if (mysql_errno() != 0) {
        echo mysql_errno() . ": " . mysql_error(); //show other error
    } else {
        echo "success";
    }
}

function getGoodInfo() {

    $good_id = mysql_escape_string($_POST["good_id"]);

    $str = "SELECT  name, title, description, price, current_count, type_id, image_src FROM goods " .
            "WHERE good_id = $good_id";
    $good_info = mysql_fetch_row(mysql_query($str));

    if (mysql_errno() != 0) {
        echo mysql_errno() . ": " . mysql_error(); //show other error
    }


    echo "{\"goodsname\": \"$good_info[0]\","
    . "\"goodstitle\": \"$good_info[1]\", "
    . "\"goodsdes\": \"$good_info[2]\", "
    . "\"goodspre\": $good_info[3],"
    . "\"goodsnum\": $good_info[4],"
    . "\"typeid\": $good_info[5],"
    . "\"image_src\": \"$good_info[6]\"}";
}

function rateOrder() {

    $order_id = mysql_escape_string($_POST['order_id']);
    $role = mysql_escape_string($_POST['role']);
    $score = mysql_escape_string($_POST['score']);


    $str = "INSERT INTO rating(order_id, role, score) " .
            "VALUES ('$order_id', '$role', $score);";
    mysql_query($str);

    if (mysql_errno() != 0) {
        echo mysql_errno() . ": " . mysql_error(); //show other error
    } else {
        echo "success";
    }
}
