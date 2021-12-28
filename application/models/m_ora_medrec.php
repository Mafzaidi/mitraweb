<?php

class M_ora_medrec extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getMedrec($mr)
    {
        $sql = "SELECT
                    A.MR,
                    A.NAMA,
                    NVL(A.TEMPAT_LAHIR,'-') AS TEMPAT_LAHIR, 
                    TO_CHAR(A.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR,
                    CASE WHEN A.ALAMAT = '' THEN '-'
                    ELSE
                        (A.ALAMAT || ' RT.' || A.RT || ' RW.' || A.RW || ' ' || A.KELURAHAN || ' ' || A.KECAMATAN || ' ' || A.KOTA) 
                    END AS ALAMAT 

                FROM
                    HIS_MANAGER.MS_MEDREC A
                WHERE
                    SUBSTR(A.MR,4) = '" . $mr . "'";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function getEmployee($search)
    {
        $sql = "SELECT  
                    A.NAMA_KAR, 
                    A.NO_KAR, 
                    A.BAGIAN
                FROM 
                    HIS_MANAGER.MS_KARYAWAN A
                WHERE 
                    A.SHOW_ITEM = '1'
                    AND A.NAMA_KAR LIKE UPPER('" . $search . "'||'%')
                    AND ROWNUM <= 5
                ORDER BY A.NAMA_KAR ASC";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }
}
