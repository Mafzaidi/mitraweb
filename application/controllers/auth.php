<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_user', 'mu');
        $this->load->library('form_validation');
	}

	public function index()
	{
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if($this->form_validation->run() == false) {
            $data['tittle'] = 'Login Page';
            $this->load->view('v_login', $data);
        } else {
            $this->_login();
        }
	}

	private function _login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => $password
		);

		if ($username <> '' && $password <> '') {
			$user = $this->mu->getUser('ms_user_m', ['username' => $username])->row_array();
			if ($user) {
            // there is user
                if ($user['is_active'] == 'Y') {
                //  user is active
                    if (password_verify($password, $user['password'])) {
                    // password verify
				        $login = $this->mu->loginUser($username);
                        
                        $data_session = array(
                            'user_id' => $login->user_id,
                            'username' => $login->username,
                            'email' => $login->email,
                            'first_name' => $login->first_name,
                            'last_name' => $login->last_name,
                            'role_id' => $login->role_id,
                            'role_name' => $login->role_name,
                            'dept_id' => $login->dept_id,
                            'status' => 'login'
                        );

                        $this->session->set_userdata($data_session);
                        redirect(base_url('home'));

                    } else {
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                        Wrong password!
                        </div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                    User is not active!
                    </div>');
                    redirect('auth');
                }
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                Username is not registered!
                </div>');
                redirect('auth');
			}
		} else {
			/*echo "<script>alert('User & Password Harus diisi '); javascript:history.back();</script>";
			exit();*/
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('auth'));
	}
}
