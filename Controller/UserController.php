<?php
	
class UserController extends Controller
{

	protected static $actions = array(
		'login' 		=> 'login',
		'loginSend' 	=> 'connect',
		'register' 		=> 'register',
		'registerSend'	=> 'registerSend'
	);
	
	public static function home(){
		self::login();
	} 
	
	public static function login($error = '', $speudo = ''){
		$data['speudo']		= $speudo;
		$data['error']		= $error;
		$display = new UserDisplay($data);
		$display->displayPage('login');
	}
	
	public static function connect(){
		$speudo = '';
		$password   = '';
		if(isset($_POST['speudo']) && isset($_POST['password'])){
			$speudo		= htmlspecialchars($_POST['speudo']);
			$password   = htmlspecialchars($_POST['password']);	
			try{		
				$res = Authenticate::checkLogin($speudo, $password);
				$display = new UserDisplay($speudo);
				$display->displayPage('connectOK');
			}catch(Exception $e){
				self::login($e->getMessage(), $speudo);
			}
		}else{
			self::login("Hackeur ?");
		}	
	}

	
	public static function register($error = '', $speudo = ''){
		$data['speudo']		= $speudo;
		$data['error']		= $error;
		$policy = new \PasswordPolicy\Policy;
		$policy->contains('lowercase', $policy->atLeast(1));
		$policy->contains('uppercase', $policy->atLeast(1));
		$policy->contains('digit', $policy->atLeast(1));
		$policy->length($policy->atLeast(6));
		$data['js'] = $policy->toJavaScript();
		$display = new UserDisplay($data);
		$display->displayPage('register');
	}
	
	public static function registerSend(){
		$speudo = '';
		$password   = '';
		if(isset($_POST['speudo']) && isset($_POST['password'])){
			$speudo		= htmlspecialchars($_POST['speudo']);
			$password   = htmlspecialchars($_POST['password']);	
			try{		
				$res = Authenticate::createUser($speudo, $password);
				$display = new UserDisplay($speudo);
				$display->displayPage('registerOK');
			}catch(Exception $e){
				self::register($e->getMessage(), $speudo);
			}
		}else{
			self::register("Hackeur ?");
		}	
	}
}