<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modal_variables {
	
	public $modal_variables;
	private $variables;
	private $tittle;
	private $message;
	private $button;
	private $link;
	private $action;

	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function getModalVariables ($params) 
	{
		$tittle = '';
		$message = '';
		$button = '';
		$link = '';
		$action = '';

		if ($params == 'logout') {
			$tittle = 'Ready to Leave?';
			$message = 'Select "Logout" below if you are ready to end your current session.';
			$button = 'yesno';
			$link = 'auth/logout';
			$action = $params;
		}

		$this->modal_variables = array(
			'tittle' => $tittle,
			'message' => $message,
			'button' => $button,
			'link' => $link,
			'action' => $action
		);
		
		return $this->modal_variables;
	}
}
?>