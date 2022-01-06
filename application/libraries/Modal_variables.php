<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modal_variables {
	
	public $modal_variables;
	private $tittle;
	private $message;
	private $button;
	private $action;
	private $modal;

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
		$action = '';
		$modal = '';

		if ($params == 'logout') {
			$modal = $params;
		}

		$this->modal_variables=array(
			'tittle' => $tittle,
			'message' => $message,
			'button' => $button,
			'action' => $action,
			'modal' => $modal
		);
		return $this->modal_variables;
	}
}
?>