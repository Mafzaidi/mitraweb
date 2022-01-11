<?php

class M_counter extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getMonitor()
    {
        $sql = "SELECT 
                    ROW_NUMBER() OVER (ORDER BY PP.JAM DESC ) AS RNUM, PP.*
                FROM 
                (
                    SELECT 
                        X.*,
                        NVL(
                            (
                                SELECT 
                                    COUNT(*) 
                                FROM 
                                    MS_TRANS_OP B1 
                                WHERE
                                    B1.TIPE_RAWAT = 'P'
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112' AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                    AND B1.MR=X.MR
                                    AND B1.DONE_STATUS NOT LIKE '%3'
                                    --AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                            ),0
                        ) AS JML_DOKTER,
                        NVL(
                            (
                                SELECT 
                                    COUNT(*) 
                                FROM 
                                    MS_TRANS_OP B1 
                                WHERE
                                    B1.TIPE_RAWAT = 'P'
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112' AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                    AND B1.MR=X.MR
                                    AND B1.DONE_STATUS NOT LIKE '%3'
                                    --AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                                    AND B1.MR||B1.DOKTER_ID IN (
                                        SELECT 
                                            A1.PASIEN_ID||A1.DOKTER_ID 
                                        FROM 
                                            FRM_RESEP_DOKTER_MS A1 
                                        WHERE 
                                            A1.PASIEN_ID = B1.MR 
                                            --AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                            AND TO_CHAR(A1.CREATED_DATE,'DDMMYYYY') = 01122021)
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112'  
                                    AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                
                            )
                        ,0) AS RESEP
                    FROM(
                        SELECT 
                            A.MR, 
                            B.NAMA PASIEN, 
                            C.NAMA_DR DOKTER, 
                            A.NO_URUT, 
                            A.NO_TR_LAMA NO_BUKTI, 
                            TO_CHAR(A.CREATED_DATE,'HH24:MI:SS') JAM,
                            SUBSTR(A.MR,4,6) PID, 
                            C.DOKTER_ID,
                            D.A_JAMANTAR,
                            D.ALASAN,
                            CASE 
                            WHEN 
                                A.DONE_STATUS LIKE '%3'
                            THEN 1
                            ELSE 0  
                            END AS STATUS           
                        FROM 
                            MS_TRANS_OP A, 
                            MS_MEDREC B, 
                            MS_HIS_DOKTER C,
                            ANTAR_MR D
                        WHERE 
                            --TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                            TO_CHAR(A.CREATED_DATE,'DDMMYYYY') = 01122021
                            AND A.MR=D.A_MR(+)
                            AND A.NO_TR_LAMA=D.A_STRUK(+)
                            AND A.TIPE_RAWAT = 'P'
                            AND A.MR=B.MR
                            AND A.DOKTER_ID=C.DOKTER_ID
                            AND(SUBSTR(A.DEPT_ID,1,3)='112' 
                            AND A.DEPT_ID NOT IN ('1120201000','1120401000'))
                            AND ROWNUM <= 10
                    )X
                )PP
                ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }
}
