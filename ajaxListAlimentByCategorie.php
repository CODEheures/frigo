<?php

include_once ('./includes/init.php');
$category = $_GET['category'];

$aliments = $db->getAlimentsByCategory($category);
echo json_encode($aliments);
?>