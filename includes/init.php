<?php
session_start();

//Style save in Session for App navigation with same style
if(isset($_GET['style']) && (int)$_GET['style'] > 0){
    $_SESSION['style']=$_GET['style'];
}


//PDO Init
include_once ('./includes/Db.php');
$db = new \Sylvain\Db(1);
$db->connect();