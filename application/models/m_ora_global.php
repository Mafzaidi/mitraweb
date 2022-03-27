<?php

class M_ora_global extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getLocalCode()
    {
        $sql = "SELECT 
                    A.VALUE LOKASI_ID,B.NAMA_RS
                FROM 
                    HIS_MANAGER.HIS_WHOLE_SYSTEM A,
                    HIS_MANAGER.LGD_LOKASI_MS B
                WHERE 
                    A.WH_SYS_ID= 'MEDREC-000001'
                    AND A.VALUE=B.LOKASI_ID
                    AND B.SHOW_ITEM='1'";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function getCurrentSess()
    {
        $sql = "SELECT
                    sys_context('USERENV','SID') AS SESS_ID
                FROM dual;";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }
}