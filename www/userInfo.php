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

                    $user_id = mysql_escape_string($_POST['user_id']);

                    $sql = "SELECT name, sex, email, phone, mobilephone, live_in " .
                            "FROM users " .
                            "WHERE user_id = '$user_id'";

                    $user_info = mysql_fetch_row(mysql_query($sql));

                    if (mysql_errno() != 0) {
                        echo mysql_errno() . ": " . mysql_error(); //show other error
                    }
                    
                    echo '<span class="context">使用者名稱：' . $user_info[0] . '</span><br>';
                    echo '<span class="context">使用者性別：' . $user_info[1] . '</span><br>';
                    echo '<span class="context">使用者信箱：' . $user_info[2] . '</span><br>';
                    echo '<span class="context">使用者市話：' . $user_info[3] . '</span><br>';
                    echo '<span class="context">使用者手機：' . $user_info[4] . '</span><br>';
                    echo '<span class="context">使用者住址：' . $user_info[5] . '</span><br>';
                    ?>

                </div>
                <div class="col-md-6"></div>
            </div>
            <button class="btn btn-danger" type="submit" onclick="undo()">返回</button>            
        </div>	 	
    </body>
</html>

<script>
    function undo() {
        $.get('<?php echo $_POST['prepage']; ?>.php').success(function(data) {
            $('#goodframe').html(data);
        });
    }
</script>