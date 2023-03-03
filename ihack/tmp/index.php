
<?php
ini_set('session.save_path', '/tmp/');
session_start();
require 'vendor/autoload.php';
use Nullix\CryptoJsAes\CryptoJsAes;
$password = "8eac4ee0790850314134f837b47dfd56";

$smarty = new Smarty();
$smarty->setTemplateDir("template");
$smarty->assign('error', false);

$page = "login";
if(isset($_GET['page'])){
        $page = @CryptoJsAes::decrypt(base64_decode($_GET['page']), $password);
}

if(!isset($page)){
    $smarty->assign('error', true);  
    $page = "login";
}


$smarty->assign('page', $page);

if(isset($_POST['username'])){

    if($_POST['username'] == "adminz" && md5($_POST['password']) == "a8ddc10a7d3822963e2a102ef7aaa2e3"){
        $_SESSION['isadmin'] = true;
        header('location: index.php?page=eyJjdCI6InNUM1FmUXgzZlg2cHNicmdFZDNSVXc9PSIsIml2IjoiODQ4ZjMxNmZjMDU3YzRmOWJkZmNmYzE5Y2I3MzU3NDIiLCJzIjoiYzIzZjJiY2Y0NDdhNTNlMiJ9');
    }else{
        $smarty->assign('error', true);
    }

}

if($page == 'check'){
    if(!$_SESSION['isadmin']){
        header('location: index.php');
    }

    $smarty->assign('success', false);
    if(isset($_FILES['file'])){
   
        $file_tmp =$_FILES['file']['tmp_name'];
        $ext = explode(".",$_FILES['file']['name']);
    
        if($ext[1] != "txt"){
            $smarty->assign('error', true);
        }else{
            $smarty->assign('success', true);
            move_uploaded_file($file_tmp,"list.txt");
        }
    }


    $data = '';
    $handle = fopen("list.txt", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $data .= "<option>$line</option>";
        }
        fclose($handle);
    }

    $smarty->assign('list', $data);

    if(isset($_POST['data2'])){
        $target = CryptoJsAes::decrypt(base64_decode($_POST['data']), $password);
        $result = CryptoJsAes::decrypt(base64_decode($_POST['data2']), $password);
        $smarty->assign('result', $result);
        $target = escapeshellarg($target);
    
        if($page == "login"){
            $smarty->assign('page', 'login');
        }
    
        $cmd = exec( "ping -c 1 $target" );
        $smarty->assign('result2', $cmd);
        $smarty->display("$result.html");
        exit();
    }
}
if($page == 'logout'){
    session_destroy();
    header('location: index.php');
}



$smarty->display('index.html');

