<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Medrec extends CI_Controller
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
            echo "test";
            // $data['user'] = $this->mu->getUserInfo($sess_id);
            // $data['tittle'] = "Home";

            // $this->load->view('templates/v_sidebar',$data);
            // $this->load->view('templates/v_topbar', $data);
            // $this->load->view('medrec/mr_loan', $data);
            // $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        } 
    }

    function form_application($param) {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            include (APPPATH.'controllers/menu_control.php');
            $page = str_replace('-', '_', $param);
            $data['user'] = $this->mu->getUserInfo($sess_id);
            $data['tittle'] = "Home";

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view('medrec/' . $page, $data);
            $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        }
    }
}
