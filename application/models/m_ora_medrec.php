<?php

class M_ora_medrec extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db=$this->load->database('oracle',true);
        $this->mysql_db=$this->load->database('default',true);
    }

    function getMedrec($mr)
    {
        $sql = "SELECT
                    A.MR,
                    A.NAMA
                FROM
                    HIS_MANAGER.MS_MEDREC A
                WHERE
                    A.MR = '" . $mr . "'";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }
}