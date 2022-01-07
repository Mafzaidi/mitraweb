<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modal_variables {
	
	public $modal_variables;
	private $arrModals;
	private $objModals;
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
		$this->modal_variables = array();
		$this->objModals = new stdClass();
		$this->tittle = '';
		$this->message = '';
		$this->button = '';
		$this->link = '';
		$this->action = '';

		foreach($params as $value){
			if ($value == 'logout') {
				$this->tittle = 'Ready to Leave?';
				$this->message = 'Select "Logout" below if you are ready to end your current session.';
				$this->button = 'yesno';
				$this->link = 'auth/logout';
				$this->action = $value;
			} elseif ($value == 'save') {
				$this->tittle = 'Confirmation';
				$this->message = 'Are you sure want to save this data?';
				$this->button = 'yesno';
				$this->link = 'auth/logout';
				$this->action = $value;
			} else {
				$this->tittle = '';
				$this->message = '';
				$this->button = '';
				$this->link = '';
				$this->action = '';
			}

			$this->arrModals = array(
				'tittle' => $this->tittle,
				'message' => $this->message,
				'button' => $this->button,
				'link' => $this->link,
				'action' => $this->action
			);

			$this->objModals = (object) $this->arrModals;
			array_push($this->modal_variables, $this->objModals);
	
		}
		return $this->modal_variables;
	}
}
?>