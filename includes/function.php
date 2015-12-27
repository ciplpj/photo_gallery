<?php

function strip_zero_from_date($marked_string=""){
	//remove marked zeros
	$zero_gone =str_replace("*0", "", $marked_string);
	//remove marked position
	$date = str_replace("*","",$marked_string);
	return $date;
}

function redirect($location=null){
	if($location!=null){
		header("Location: {$location}");
		exit;
	}
}

function output_message($message=""){
	if(!empty($message)){
			return "<p class=\"message\">{$message}</p>";
	}else{
		return "";
	}
}

function __autoload($class){
	$class = strtolower($class);
	$path = LIB_PATH.DS."{$class}.php";
	if(file_exists($path)){
		require_once($path);
	}else{
		die("The file {$class}.php could not be found");
	}
}

function include_layout_template($template=""){
	include(SITE_ROOT.DS."public".DS."layouts".DS.$template);
}

function datetime_to_text($date=''){
	$unixtimestamp = strtotime($date);
	return strftime("%B %d, %Y at %I:%M %p",$unixtimestamp);

}

?>