<?php

include("base.php");
include("db.php");

$name = mysql_escape_string($_POST["name"]);
$account = mysql_escape_string($_POST["account"]);
$email = mysql_escape_string($_POST["email"]);
$plainText = mysql_escape_string($_POST["password"]);
$password = sha1($salt . $account . $plainText); //use user_id as salt
$phone = mysql_escape_string($_POST["phone"]);
$mobilephone = mysql_escape_string($_POST["mobilephone"]);
$sex = mysql_escape_string($_POST["sex"]);
$live_in = mysql_escape_string($_POST["live_in"]);

$userIds = mysql_query("select * from users where users_id ='$account'");

if (mysql_num_rows($userIds)) {
    jsAlert('這個帳號： ' . $account . ' 已經被註冊了');
    jsRedirect("register.php");
}

$emailsTest = mysql_query("select * from users where email ='$email'");
if (mysql_num_rows($emailsTest)) {
    jsAlert('這個信箱： ' . $email . ' 已經被註冊了');
    jsRedirect("register.php");
}

$str = "INSERT INTO users(user_id,password,email,name,sex,live_in,phone,mobilephone) VALUES ('$account','$password','$email','$name','$sex','$live_in','$phone','$mobilephone');";
$result = mysql_query($str);

if (mysql_errno() != 0) {
    echo mysql_errno() . ": " . mysql_error() . "<br>"; //show other error
} else {
    jsAlert('註冊成功');
    jsRedirect("login.php");
}
?>
	