<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
	{
			parent::__construct();
			$this->load->library('session');        
    		$this->load->model('m_user','mu');
			$this->load->library('modal_variables');
	}

    public function index()
    {
		$this->load->helper(array('path'));
        $sess_id = $this->session->userdata('user_id');

	   if(!empty($sess_id))
	   {
			$params = 'logout';
			include (APPPATH.'controllers/menu_control.php');
			include (APPPATH.'controllers/modal_control.php');

			//$modals = $this->modal_variables->getModalVariables($params);

			$data['user'] = $this->mu->getUserInfo($sess_id);
            $data['tittle'] = 'Home';
			//$data['modal'] = $modals['modal'];

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view('v_home', $data);
            $this->load->view('templates/v_footer');
	   }else{
			redirect(base_url('auth'));
	   } 
    }
}
