<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_user', 'mu');
	}

	public function index()
	{
		$this->load->view('v_login');
	}

	function user_login()
	{
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$where = array(
			'username' => $username,
			'password' => $password
		);

		if ($username <> '' && $password <> '') {
			$check = $this->mu->cek_login('ms_user_m', $where)->num_rows();
			if ($check > 0) {
				$login = $this->mu->loginUser($username, $password);

				$data_session = array(
					'user_id' => $login->user_id,
					'username' => $login->username,
					'email' => $login->email,
					'first_name' => $login->first_name,
					'last_name' => $login->last_name,
					'status' => 'login'
				);

				$this->session->set_userdata($data_session);
				redirect(base_url('home'));
			} else {
				echo "<script>alert('Mohon periksa User & Password Anda');javascript:history.back();</script>";
				exit();
			}
		} else {
			/*echo "<script>alert('User & Password Harus diisi '); javascript:history.back();</script>";
			exit();*/
		}
	}
}
