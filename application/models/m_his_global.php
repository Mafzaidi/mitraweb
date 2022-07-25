<?php

class M_his_global extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getRowsMsRekanan() {
        $sql = "SELECT
                    A.*
                FROM
                    HIS_MANAGER.MS_REKANAN A
                WHERE
                    A.SHOW_ITEM = '1'
                ORDER BY A.REKANAN_NAMA ASC
                ";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }
}