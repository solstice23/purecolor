<?php
require_once('config.php');

function check_id($id){
	return (strlen($id) == 10);
}

function get_random_id(){
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$res = ''; 
	for ($i = 1; $i <= 10; $i++) { 
		$res .= $chars[rand(0, strlen($chars) - 1)]; 
	}
	return $res; 
}

function check_json($str){
	json_decode($str);
	return (json_last_error() == JSON_ERROR_NONE);
}

function check_hex($hex){
	if (strlen($hex) != 7){
		return False;
	}
	if (substr($hex, 0, 1) != "#"){
		return False;
	}
	$dec = array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, 'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15);
	if (!isset($dec[substr($hex, 1, 1)]) || !isset($dec[substr($hex, 2, 1)]) || !isset($dec[substr($hex, 3, 1)]) || !isset($dec[substr($hex, 4, 1)]) || !isset($dec[substr($hex, 5, 1)]) || !isset($dec[substr($hex, 6, 1)])){
		return False;
	}
	return True;
}

function esc_str($str){
	return addslashes($str);
}
?>