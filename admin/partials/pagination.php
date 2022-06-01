<?php
if (isset($_GET['from'])) {
    $from=$_GET['from'];
}else{
    $from="0";
} 


if (isset($_GET['to'])) {
    $to=$_GET['to'];
    $qty=intval($_GET['to']);
}else{
    $to="20";
    $qty=20;
}

$nextid=intval($from)+intval($to);
$previd=intval($from)-intval($to);
$pagenumber=intval($from)/intval($to);