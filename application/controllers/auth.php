<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_user', 'mu');
        $this->load->model('m_ora_global', 'mglobal');
        $this->load->library('form_validation');
        $this->oracle_db = $this->load->database('oracle', true);
	}

	public function index()
	{
        $sess_id = $this->session->userdata('user_id');

        if(!empty($sess_id))
        {   
            redirect(base_url('home'));
        } 
        else {          
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if($this->form_validation->run() == false) {
                $data['tittle'] = 'Login Page';
                $this->load->view('v_login', $data);
            } else {
                $this->_login();
            }
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
            // check mysql user
			if ($user) {
                if ($username <> 'POLI'){                
                        $userOra = $this->mu->getDataOra('MS_KARYAWAN', ['NO_KAR' => $username])->row_array();
                        // check ora user
                        if ($userOra) {
                            // there is user
                            if ($user['is_active'] == 'Y') {
                                //  user is active
                                // if (password_verify($password, $user['password'])) {
                                // password verify
                                    include (APPPATH.'controllers/functions/Ora_auth.php');
                                    $login = $this->mu->loginUser($username);
                                    $dataOra = $this->mu->getDataUser($username);
                                    $localcode = $this->mglobal->getLocalCode();
                                    // $currSession = $this->mglobal->getCurrentSess();
                                    if (!$connect) {
                                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                        Wrong password!
                                        </div>');
                                        redirect('auth');
                                    } else {
                                        $data_session = array(
                                            'user_id' => $login->user_id,
                                            'role_id' => $login->role_id,
                                            'dept_id' => $login->dept_id,
                                            'kd_bagian' => $dataOra->KD_BAGIAN,
                                            'lokasi_id' => $localcode->LOKASI_ID,
                                            // 'ora_session' => $currSession->SESS_ID,
                                            'status' => 'login'
                                        );
                
                                        $this->session->set_userdata($data_session);
                                        redirect(base_url('home'));    
                                    }
                                                        
                                // } else {
                                //     $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">
                                //     Wrong password!
                                //     </div>');
                                //     redirect('auth');
                                // }
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
                    if ($user['is_active'] == 'Y') {
                        //  user is active
                        if (password_verify($password, $user['password'])) {
                        // password verify
                            // include (APPPATH.'controllers/functions/Ora_auth.php');
                            $login = $this->mu->loginUser($username);
                            // $dataOra = $this->mu->getDataUser($username);
                            $localcode = $this->mglobal->getLocalCode();
                            $data_session = array(
                                'user_id' => $login->user_id,
                                'role_id' => $login->role_id,
                                'dept_id' => $login->dept_id,
                                'kd_bagian' => '',
                                'lokasi_id' => $localcode->LOKASI_ID,
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
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('dept_id');
		$this->session->set_userdata('status','logout');
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
        You have been logged out!
        </div>');

		redirect(base_url('auth'));
	}
}
