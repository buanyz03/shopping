

<?php
// 比對其帳號與密碼
$sql = "SELECT count(*) FROM user ";
$sql .= "WHERE username = '$loginname' ";
$sql .= "AND password = '$loginpswd' ";
$rs = mysql_db_query($cfgDatabaseName, $sql, $link);
list($nT) = mysql_fetch_row($rs);

// 依檢查結果分別導向主作業畫面與錯誤警告畫面
if ( $nT ) {
  Header("location:main.php");
  exit;
}
else {
  Header("location:error.php");
  exit;
}
?>