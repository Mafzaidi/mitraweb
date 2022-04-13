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
            $this->load->model('m_form_application','mfa');
			$this->load->library('modal_variables');
            $this->load->library('pagination');
	}

	public function index()
    {
		$this->load->helper(array('path'));
        $sess_id = $this->session->userdata('user_id');

        if(!empty($sess_id))
        {
            //
        }else{
            redirect(base_url('auth'));
        } 
    }

    function form_application($param) {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
			$params = array('save');
            include (APPPATH.'controllers/menu_control.php');
			include (APPPATH.'controllers/modal_control.php');
            $page = str_replace('-', '_', $param);
            $uri3 = $this->uri->segment(3);
            $uri2 = $this->uri->segment(2);
            $uri1 = $this->uri->segment(1);

            $filename = APPPATH."controllers/page/page.".$param.".php";

            if (file_exists($filename)) {
                if($this->uri->segment(3) <> ''){  
                    if ($param == str_replace('-', '_',$this->uri->segment(3))) {
                        require_once(APPPATH."controllers/page/page.".$param.".php");
                    }
                }
            }
            
            $checkUser = $this->mu->getUser('ms_user_m', ['user_id' => $sess_id])->row_array();
			if ($checkUser) {
				$data['user'] = $this->mu->getUserInfo($sess_id);
			} else {
				$userOrainfo = $this->mu->getOraUserInfo($sess_id);
				$user = array(
					"username"=>$userOrainfo->USERNAME,
					"first_name"=>$userOrainfo->FIRST_NAME,
					"last_name"=>$userOrainfo->LAST_NAME,
					"email"=>"",
					"dept_name"=>"",
					"role_name"=>"",
					"created_date"=>"",
					"img_url"=>"default.png"
				);
				$data['user'] = $user;
				// echo "<script>console.log('" . json_encode($user) . "');</script>";				
			}
            $data['tittle'] = "Home";

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view( $page, $data);
            $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        }
    }

    function features($param) {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
            
            $params = array('');
            $this->modal_variables->modalTittle = 'Data Medrec';
            $this->modal_variables->modalSize = 'modal-xl';
            $this->modal_variables->modalAction = 'select';
            $this->modal_variables->modalButton = 'yesno';

            include (APPPATH.'controllers/modal_control.php');
            include (APPPATH.'controllers/menu_control.php');
            
            $filename = APPPATH."controllers/page/page.".$param.".php";

            if (file_exists($filename)) {
                if($this->uri->segment(3) <> ''){  
                    if ($param == str_replace('-', '_',$this->uri->segment(3))) {
                        require_once(APPPATH."controllers/page/page.".$param.".php");
                    }
                }
            }   

            $page = str_replace('-', '_', $param);       

            $checkUser = $this->mu->getUser('ms_user_m', ['user_id' => $sess_id])->row_array();
			if ($checkUser) {
				$data['user'] = $this->mu->getUserInfo($sess_id);
			} else {
				$userOrainfo = $this->mu->getOraUserInfo($sess_id);
				$user = array(
					"username"=>$userOrainfo->USERNAME,
					"first_name"=>$userOrainfo->FIRST_NAME,
					"last_name"=>$userOrainfo->LAST_NAME,
					"email"=>"",
					"dept_name"=>"",
					"role_name"=>"",
					"created_date"=>"",
					"img_url"=>"default.png"
				);
				$data['user'] = $user;
				// echo "<script>console.log('" . json_encode($user) . "');</script>";			
			}
            $data['tittle'] = "Home";

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view($page, $data);
            $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        }
    }

    function reports($param) {
        $sess_id = $this->session->userdata('user_id');
        if(!empty($sess_id))
        {
			$params = array('save');
            include (APPPATH.'controllers/menu_control.php');
			include (APPPATH.'controllers/modal_control.php');

            $page = str_replace('-', '_', $param);
            $data['user'] = $this->mu->getUserInfo($sess_id);
            $data['tittle'] = "Polimon Report";

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view('counter/' . $page, $data);
            $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        }
    }
}
