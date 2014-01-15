<?php
	
/**
 * Controle les connexions/enregistrement d'un utilisateur
 */
class UserController extends Controller
{
	/**
	 * Liste des actions
	 */
	protected static $actions = array(
		'login' 		=> 'login',
		'loginSend' 	=> 'connect',
		'register' 		=> 'register',
		'registerSend'	=> 'registerSend'
	);
	
	/**
	 * Action par défault, s'éxecute en cas d'action incorrect et en page de garde
	 */
	public static function home(){
		self::login();
	} 
	
	/**
	 * Affiche la page de login
	 * les paramètres sont en cas d'erreur, pour remplir les inputs
	 */
	public static function login($error = '', $speudo = ''){
		$data['speudo']		= $speudo;
		$data['error']		= $error;
		$display = new UserDisplay($data);
		$display->displayPage('login');
	}
	
	/**
	 * Vérifie les données des utilisateurs et affiche la confirmation de connection
	 * sinon affiche la page de login avec un message d'erreur
	 */
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

	
	/**
	 * Affiche la page d'enregistrement
	 */
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
	
	/**
	 * Vérifie les données des utilisateurs et affiche la confirmation d'enregistrement
	 * sinon affiche la page de login avec un message d'erreur
	 */
	public static function registerSend(){
		$speudo = '';
		$password   = '';
		if(isset($_POST['speudo']) && isset($_POST['password']) && isset($_POST['email'])){
			$speudo		= htmlspecialchars($_POST['speudo']);
			$password   = htmlspecialchars($_POST['password']);	
			$email 		= htmlspecialchars($_POST['email']);
			try{		
				$res = Authenticate::createUser($speudo, $password, $email, $level);
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