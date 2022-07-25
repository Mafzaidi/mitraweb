<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
	{
			parent::__construct();
			$this->load->library('session');        
    		$this->load->model('m_user','mu');
			$this->load->model('m_ora_global', 'org');
			$this->load->library('modal_variables');
	}

    public function index()
    {
		$this->load->helper(array('path'));
        $sess_id = $this->session->userdata('user_id');

	   if(!empty($sess_id))
	   {
			$params = array('logout');
			include (APPPATH.'controllers/menu_control.php');
			include (APPPATH.'controllers/modal_control.php');
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
					"dept_name"=>$userOrainfo->BAGIAN,
					"role_name"=>"",
					"created_date"=>"",
					"img_url"=>"default.png"
				);
				$data['user'] = $user;
				echo "<script>console.log('" . json_encode($user) . "');</script>";
				
			}
			// $data['local_code'] = $this->mu->getLocalCode();
            $data['tittle'] = 'Home';
            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view('v_home', $data);
            $this->load->view('templates/v_footer');
	   }else{
			redirect(base_url('auth'));
	   } 
    }
}
