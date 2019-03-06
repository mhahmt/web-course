<?php
session_start();
	$allowed_urls =array(
					'http://127.0.0.1/webcourse/index.php',
					'http://127.0.0.1/webcourse/',
					'http://127.0.0.1/webcourse',
					'http://localhost/webcourse/index.php',
					'http://localhost/webcourse/',
					'http://localhost/webcourse'
						);
	#check url
	if (isset($_SERVER['HTTP_REFERER']) && in_array($_SERVER['HTTP_REFERER'] , $allowed_urls)){
		#check request methood
		if ($_SERVER['REQUEST_METHOD'] == "POST"){
			#check token
			 if(isset($_POST['token'])){
			 	if (password_verify($_SESSION['token'],$_POST['token'])){
			 		define('LANG', 'en'); 
					$language_file = "lang/".LANG.".php";
					
					if(file_exists($language_file)){
						require($language_file);
					}
					else{
						exit("the language file does not exist");
					}
					

					spl_autoload_register(function($class_name){	
					require"classes/". $class_name .".class.php";
					});
					switch ($_POST['section']) {
			
				        	case "skills":
				        	$skills = new Ptc;
				        	$skills->render("skills");
				        	break;

				        	case "languages":
				        	$languages = new Ptc;
				        	$languages->render("languages");
				        	break;
				        	
				        	case "home":
				        	default:
				        	$home = new Ptc;
				        	
				        	foreach ($contentinfo as $key => $value){
							$home->assign($key,$value);
						}
				        	$home->render("home");
			        	
					} # end switch
					
				}
				else{
					exit('Error Number 4');		#wrong token
				}
				
			}
			else{
				exit('Error Number 3'); # no token
			}
		}
		else{
			exit('Error Number 2'); # not POST
		}
		
	  }
	else
	  {
	 	exit('Error Number 1');  # Error  HTTP_REFERER
	  }
