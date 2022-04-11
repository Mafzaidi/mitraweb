<?php

class M_form_application extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getRowPinjamMR($orderByRNUM, $orderByMEDREC, $orderByPASIEN, $orderBy4, $orderBy5, $orderBy6, $orderBy7, $orderBy8) {
        $ql = "SELECT
                    ROW_NUMBER() OVER (ORDER BY X.TGL_MASUK ASC) AS RNUM,
                    X.*
                FROM 
                (
                SELECT
                    SUBSTR(A.MR, 4) AS MEDREC,
                    D.NAMA AS PASIEN,
                    A.RUANG_ID,
                    C.NAMA_DEPT,
                    E.NAMA_DR,
                    TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                    F.REKANAN_NAMA
                FROM 
                    HIS_MANAGER.MS_REG A, 
                    HIS_MANAGER.MS_RUANG B,
                    HIS_MANAGER.MS_HIS_DEPT C,
                    HIS_MANAGER.MS_MEDREC D,
                    HIS_MANAGER.MS_HIS_DOKTER E,
                    HIS_MANAGER.MS_REKANAN F
                WHERE 
                    A.MR = B.MR 
                    AND A.REG_ID = B.REG_ID 
                    AND A.RUANG_ID = B.RUANG_ID
                    AND B.DEPT_ID = C.DEPT_ID
                    AND A.MR = D.MR
                    AND A.DOKTER_ID = E.DOKTER_ID
                    AND A.REKANAN_ID = F.REKANAN_ID
                    AND A.TGL_KELUAR IS NULL 
                    AND A.DONE_STATUS <> '03' 
                ) X
                ORDER BY X.TGL_MASUK ASC
            ";
    }
}