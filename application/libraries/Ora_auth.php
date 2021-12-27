<?php 	
    // oracle authentification
    $dbuser = 'PLAY_' . $username; /* your deakin login */
    $dbpass = 'HARD_' . $password; /* your oracle access password */
    $db= $this->oracle_db->hostname; /*'192.168.2.252:1521/uat'; */
    $connect = OCILogon($dbuser, $dbpass, $db);
    
?>