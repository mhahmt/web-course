<?php
session_start();

	$pswd_generator  = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*');
	$_SESSION['token'] = substr($pswd_generator,0,30).time();
	$token_hash = password_hash($_SESSION['token'] ,PASSWORD_DEFAULT);

	define('LANG', 'en');
################################################
$language_file = "lang/".LANG.".php";
		if(file_exists($language_file)){
			require($language_file);
		}
		else{
			exit("the language file does not exist");
		}
################################################
spl_autoload_register(function($class_name){	
	require"classes/". $class_name .".class.php";
});
################################################
# start building
$html = new Ptc;

foreach ($init as $key => $value){
	$html->assign($key,$value);
}
$html->render("start");
################################################
# build navbar
$navbar = new Ptc;

foreach ($nav as $key => $value){
	$navbar->assign($key,$value);
}
$navbar->render("nav");
################################################
# build card
$card = new Ptc;

foreach ($cardinfo as $key => $value){
	$card->assign($key,$value);
}
$card->render('card');
################################################
# build content
$content = new Ptc;

foreach ($contentinfo as $key => $value){
	$content->assign($key,$value);
}

$content->render('content');
################################################
# build footer
$footer = new Ptc;
$footer->assign("token_value",$token_hash);
$footer->render('footer');
################################################
# finish  building
$html->render("end");
