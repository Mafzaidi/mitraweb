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

            $page = str_replace('-', '_', $param);
            $monitor = $this->mctr->getMonitor();

            $data['user'] = $this->mu->getUserInfo($sess_id);
            $data['tittle'] = "Home";

            $i= 0;
            $tb = '';
            $tb.= '<div class="tb">';
            $tb.= '<div class="tb-header">';
            $tb.= '<div class="row">';
            $tb.= '<div class="col-md-1">NO.</div>';
            $tb.= '<div class="col-md-1">MEDREC</div>';
            $tb.= '<div class="col-md-3">PASIEN</div>';
            $tb.= '<div class="col-md-3">DOKTER</div>';
            $tb.= '<div class="col-md-1">NO URUT</div>';
            $tb.= '<div class="col-md-1">NO STRUK</div>';
            $tb.= '<div class="col-md-2">JAM</div>';
            $tb.= '</div>';      
            $tb.= '</div>'; 
            
            $tb.= '<div class="tb-body">';
            foreach($monitor as $pm) {
            $tb.= '<div class="row border-bottom ' . ($i%2 ? 'odd':'even') . '">';
            $tb.= '<div class="col-md-1">' . $pm->RNUM . '</div>';
            $tb.= '<div class="col-md-1">' . $pm->PID . '</div>';
            $tb.= '<div class="col-md-3">' . $pm->PASIEN . '</div>';
            $tb.= '<div class="col-md-3">' . $pm->DOKTER . '</div>';
            $tb.= '<div class="col-md-1">' . $pm->NO_URUT . '</div>';
            $tb.= '<div class="col-md-1">' . $pm->NO_BUKTI . '</div>';
            $tb.= '<div class="col-md-2">' . $pm->JAM . '</div>';
            $tb.= '</div>';
            $i++;
            }   
            $tb.= '</div>'; 

            $tb.= '</div>';
            $data['polimon'] = $tb;

            $this->load->view('templates/v_sidebar',$data);
            $this->load->view('templates/v_topbar', $data);
            $this->load->view('counter/' . $page, $data);
            $this->load->view('templates/v_footer');
        }else{
            redirect(base_url('auth'));
        }
    }
}
