<?php
require_once('avangate.php');
$avgt = new Avangate();
echo $avgt->Handler($_POST,$_GET['query']);
echo "read receipt confirmation";
?>