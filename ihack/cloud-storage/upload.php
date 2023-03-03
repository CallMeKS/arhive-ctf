<?php

$uploaded = false;
define('UPLOAD_PATH', getcwd().'/upload');


if(isset($_POST['submit'])){
    $disallowed_exts = array('php','php2','php3','php4','php5','php6','php7','phps','pht','phtm','phtml','pgif','shtml','htaccess','phar','inc','hphp','ctp','module');
    $file_name = $_FILES['upload_file']['name'];
    $file_size = $_FILES['upload_file']['size'];
    $temp_file = $_FILES['upload_file']['tmp_name'];
    $file_ext = strtolower(substr($file_name,strrpos($file_name,".")+1));

    $upload_file = UPLOAD_PATH . '/' . $file_name;
    if ($file_size > 300000) {
        echo '<META http-equiv="refresh" content="0;URL='.$_SERVER['HTTP_REFERER'].'">';
        die('<script>alert("Exceeded 300kb file size.");</script>');
    }

    if (move_uploaded_file($temp_file, $upload_file)) {
        if(!in_array($file_ext,$disallowed_exts)){
             $img_path = UPLOAD_PATH . '/'. rand(10, 99).date("YmdHis").".".$file_ext;
             rename($upload_file, $img_path);
             $uploaded = true;
        } else {
            @unlink($upload_file);
            echo '<META http-equiv="refresh" content="0;URL='.$_SERVER['HTTP_REFERER'].'">';
            die("<script>alert('.{$file_ext} file is not allowed!')</script>");
        }
    } else {
        echo '<META http-equiv="refresh" content="0;URL='.$_SERVER['HTTP_REFERER'].'">';
        exit('<script>alert("upload error!")</script>');
    }
}

if ($uploaded) {
    echo "The file was uploaded to: " . $img_path;
}

?>
