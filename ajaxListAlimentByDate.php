<?php

include_once ('./includes/init.php');
$date = $_GET['date'];

$aliments = $db->getAlimentsByDate($date);
echo json_encode($aliments);
?>