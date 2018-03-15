<?php
function jsAlert($val) {
    echo '<script type="text/javascript">';
    echo 'alert("' . $val . '")';
    echo '</script>';
}

function jsRedirect($val){ //因為header("Location:xxx.php"); 會比javascript還要早執行，所以有用到jsAlert的，重新導向要用這個function
    echo '<script type="text/javascript">';
    echo 'window.location.href = "' . $val . '"';
    echo '</script>';
}

?>