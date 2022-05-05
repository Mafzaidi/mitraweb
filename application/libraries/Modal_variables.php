<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modal_variables {
	
	public $modal_variables;
	private $arrModals;
	private $objModals;

	public $tittle;
	public $modalTittle ='';

	public $message;
	public $modalMessage ='';

	public $button;
	public $modalButton ='';

	public $link;
	public $modalLink ='';

	public $action;
	public $modalAction ='';

	public $size;
	public $modalSize ='';

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
		$this->size = '';

		foreach($params as $value){
			if ($value == 'logout') {
				$this->tittle = 'Ingin Keluar?';
				$this->message = 'Pilih "Logout" bila ingin meninggalkan situs ini.';
				$this->button = 'yesno';
				$this->link = 'auth/logout';
				$this->action = $value;
				$this->size = '';
			} elseif ($value == 'save') {
				$this->tittle = 'Konfirmasi';
				$this->message = 'Apakah anda yakin ingin menyimpan data berikut?';
				$this->button = 'yesno';
				$this->link = 'auth/logout';
				$this->action = $value;
				$this->size = '';
			} else {
				$this->tittle = $this->modalTittle;
				$this->message = $this->modalMessage;
				$this->button = $this->modalButton;
				$this->link = $this->modalLink;
				$this->action = $this->modalAction;
				$this->size = $this->modalSize;
			}

			$this->arrModals = array(
				'tittle' => $this->tittle,
				'message' => $this->message,
				'button' => $this->button,
				'link' => $this->link,
				'action' => $this->action,
				'size' => $this->size
			);

			$this->objModals = (object) $this->arrModals;
			array_push($this->modal_variables, $this->objModals);
	
		}
		return $this->modal_variables;
	}
}
?>