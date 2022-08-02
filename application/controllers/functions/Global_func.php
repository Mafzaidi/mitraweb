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

    public function downloadSpreadsheet($url = NULL, $filename = NULL) {
        // read file contents
        $data = file_get_contents(base_url($url.$filename));
        force_download($filename, $data);
    }

}