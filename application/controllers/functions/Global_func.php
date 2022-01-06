<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Global_func extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->libaries('Modal_variables', 'mv');
    }

    public function getModal() 
	{
        echo"test";
	}
}