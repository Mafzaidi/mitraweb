<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test_logon extends CI_Controller
{

    function __construct()
	{
		parent::__construct();
        $this->oracle_db = $this->load->database('oracle', true);
	}

    public function index() {
        
        // oracle login
        $dbuser = "PLAY_17111306"; /* your deakin login */
        $dbpass = "HARD_17111306"; /* your oracle access password */
        $db= $this->oracle_db->hostname; /*'192.168.2.252:1521/uat'; */
        $connect = OCILogon($dbuser, $dbpass, $db);
        if (!$connect) {
            echo "An error occurred connecting to the database";
        } else {
            echo "good";
        exit;
        }

    }

    
                        
// end of oracle login
}