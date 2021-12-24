<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{

    public function __construct()
	{
			parent::__construct();
			$this->load->library('session');        
    		$this->load->model('m_user','mu');
	}

    public function index()
    {
		$this->load->helper(array('path'));
        $sess_id = $this->session->userdata('user_id');

	   if(!empty($sess_id))
	   {
			include (APPPATH.'controllers/menu_control.php');
            $data['tittle'] = "Home";
            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar');
            $this->load->view('templates/v_content');
            $this->load->view('templates/v_footer');
	   }else{
			redirect(base_url('auth'));
	   } 
    }
}
