<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Counter extends CI_Controller
{

    public function __construct()
	{
			parent::__construct();
			$this->load->library('session');     
    		$this->load->model('m_user','mu');  
    		$this->load->model('m_counter','mctr');
			$this->load->library('modal_variables');
            $this->load->library('pagination');
	}

	public function index()
    {
		$this->load->helper(array('path'));
        $sess_id = $this->session->userdata('user_id');

        if(!empty($sess_id))
        {
            
        }else{
            redirect(base_url('auth'));
        } 
    }

    function fitures($param) {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
			$params = array('logout','save');
            include (APPPATH.'controllers/menu_control.php');
			include (APPPATH.'controllers/modal_control.php');

            if($this->uri->segment(3) <> ''){  
                if ($param == str_replace('-', '_',$this->uri->segment(3))) {
                    require_once(APPPATH."controllers/counter/page.".$param.".php");  
                }
            }
            
            $page = str_replace('-', '_', $param);           

            $data['user'] = $this->mu->getUserInfo($sess_id);
            $data['tittle'] = "Home";

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view('counter/' . $page, $data);
            $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        }
    }
}
