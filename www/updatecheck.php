<?php

session_start();
if (!$_SESSION['user_id']) {
    header("Location:login.php");
}
?>

<?php

include("base.php");
include("db.php");


$account = $_SESSION['user_id'];

$oldPlainText = mysql_escape_string($_POST["oldPassword"]);

$oldPassword = sha1($salt . $account . $oldPlainText); //use user_id as salt

$str = "select password from users where user_id ='$account'";
$result = mysql_query($str);
$row = mysql_fetch_row($result);

if ($row[0] == $oldPassword) {
    $email = mysql_escape_string($_POST["email"]);
    $phone = mysql_escape_string($_POST["phone"]);
    $mobilephone = mysql_escape_string($_POST["mobilephone"]);
    $sex = mysql_escape_string($_POST["sex"]);
    $live_in = mysql_escape_string($_POST["live_in"]);

    $emailsTest = mysql_query("select * from users where email = '$email' AND users_id != '$account'");
    if (mysql_num_rows($emailsTest)) {
        jsAlert('這個信箱： ' . $email . ' 已經被註冊了');
        jsRedirect("index.php");
    } else {
        $str = "UPDATE users SET email='$email',sex='$sex',live_in='$live_in',phone='$phone',mobilephone='$mobilephone' WHERE user_id = '$account'";
        mysql_query($str);

        $newPlainText = mysql_escape_string($_POST["newPassword"]);
        if ($newPlainText != '') {
            $newPassword = sha1($salt . $account . $newPlainText); //use user_id as salt
            $str = "UPDATE users SET password = '$newPassword' WHERE user_id = '$account'";
            mysql_query($str);
        }


        jsAlert("修改成功！！");
        jsRedirect("index.php");
    }
} else {
    jsAlert("密碼錯誤，修改失敗！！");
    jsRedirect("index.php");
}
?>
	