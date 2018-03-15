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
            <h1 id ="webtitle" class="glyphicon glyphicon-cog overview-normalize">新增商品</h1>
        </div>
        <div class="bs-example"> 
            <div id="alert_placeholder">
            </div>
            <div class="row ">
                <div class=" col-md-4">
                    <p class="context">商品名稱</p>
                    <input type="text" class="form-control" id="goodsname" placeholder="商品名稱" required>
                    <p class="context">商品標題</p>
                    <input type="text" class="form-control" id="goodstitle" placeholder="商品標題" required>
                    <p class="context">商品資訊</p>
                    <input type="text" class="form-control" id="goodsdes" placeholder="商品資訊" required>
                    <p class="context">價錢</p>
                    <input type="text" class="form-control" id="goodspre" placeholder="價錢" required>
                    <p class="context">預覽圖</p>
                    <input type="text" class="form-control" id="image_src" placeholder="請輸入圖片網址">

                    <span class="context">商品類別</span>
                    <select id="typeid" class="form-control" >
                        <option value="1">3C產品</option>
                        <option value="2">男性用品</option>
                        <option value="3">女性用品</option>
                        <option value="4">書籍</option>
                        <option value="5">食品</option>
                    </select>
                    <span class="context">商品數量</span>

                    <input id="goodsnum" type="number" min="1" value="1" style="width: 100px;">

                </div>
                <div class="col-md-6">
                    <div class="col-md-6">
                        <img id="preview" style="width: 500px; height: auto;" src="images/empty.jpg" alt="商品">  
                    </div>
                </div>
            </div>
            <button class="btn btn-success" type="submit" onclick="ok_mod()">確認</button>
            <button class="btn btn-danger " type="submit" onclick="go_back()">返回</button>
        </div>	 	

    </body>
</html>
<script>
    var editMode = false;
    $(document).ready(function() {
        $("#image_src").blur(function() {
            $("#preview").attr("src", $("#image_src").val());
        });

<?php
include("db.php");
header("Content-Type:text/html; charset=utf-8");
if ($_POST['good_id']) {
    echo '$("#webtitle").text("編輯商品");';
    echo 'editMode = true;';
}
?>
        if (editMode) {
            $.post('shoping_api.php', {good_id: '<?php echo $_POST['good_id'] ?>', select: 'getGoodInfo'}, function(data) {
                good_info = JSON.parse(data.trim());

                $("#goodsname").val(good_info.goodsname);
                $("#goodstitle").val(good_info.goodstitle);
                $("#goodsdes").val(good_info.goodsdes);
                $("#goodspre").val(good_info.goodspre);
                $("#goodsnum").val(good_info.goodsnum);
                $("#image_src").val(good_info.image_src);
                if (good_info.image_src != '') {
                    $("#preview").attr("src", good_info.image_src);
                }
                $("#typeid").val(good_info.typeid);
            });
        }

    });

    function showalert(message, alerttype) {
        $("#alertdiv").remove();
        $('#alert_placeholder').append('<div id="alertdiv" class="alert ' + alerttype + '"><a class="close" data-dismiss="alert">×</a><span>' + message + '</span></div>')
    }

    function ok_mod() {
        var goodsname = $("#goodsname").val();
        var goodstitle = $("#goodstitle").val();
        var goodsdes = $("#goodsdes").val();
        var goodspre = $("#goodspre").val();
        var goodsnum = $("#goodsnum").val();
        var image_src = $("#image_src").val();
        var typeid = $("#typeid").val();


        if (editMode) {
            var json = {
                good_id: '<?php echo $_POST['good_id'] ?>',
                goodsname: goodsname,
                goodstitle: goodstitle,
                goodsdes: goodsdes,
                goodspre: goodspre,
                goodsnum: goodsnum,
                image_src: image_src,
                typeid: typeid,
                select: 'shopingedit'
            }
            $.post(
                    "shoping_api.php",
                    json,
                    function(data)
                    {
                        showalert(data, 'alert-success');
                        console.log(data);
                    }
            );
        } else {
            var json = {
                goodsname: goodsname,
                goodstitle: goodstitle,
                goodsdes: goodsdes,
                goodspre: goodspre,
                goodsnum: goodsnum,
                image_src: image_src,
                typeid: typeid,
                select: 'shopingadd'
            }
            $.post(
                    "shoping_api.php",
                    json,
                    function(data)
                    {
                        showalert(data, 'alert-success');
                        console.log(data);
                    }
            );
            $("#goodsname").val('');
            $("#goodstitle").val('');
            $("#goodsdes").val('');
            $("#goodspre").val('');
            $("#image_src").val('');
            $("#preview").attr("src", "images/empty.jpg");
            $("#goodsnum").val('1');
        }
    }

    function go_back() {
        $.post("goods_list.php",
                {type_id: 0},
        function(data) {
            $('#goodframe').html(data);
        }, "html");
    }

</script>