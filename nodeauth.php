<?php
$sid = $_GET['SESSID'];

session_id($sid);
session_start();
header('text/html');
echo json_encode($_SESSION);
$echo print_r($_SERVER,true);

