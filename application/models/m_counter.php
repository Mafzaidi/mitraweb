<?php

class M_counter extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getRowcountMonitor($batal, $jml_dr, $resep, $selesai)
    {
        $sql = "SELECT 
                    PP.*
                FROM 
                (
                    SELECT 
                        ROW_NUMBER() OVER (ORDER BY X.JAM DESC, X.MR, X.DOKTER ASC ) AS RNUM, 
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
                                    AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    --AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                            ),0
                        ) AS JML_DOKTER,
                        NVL(
                            (
                                SELECT 
                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS RESEP
                                FROM 
                                    MS_TRANS_OP B1 
                                WHERE
                                    B1.TIPE_RAWAT = 'P'
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112' AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                    AND B1.MR=X.MR
                                    AND B1.DONE_STATUS NOT LIKE '%3'
                                    AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    --AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                                    AND B1.MR||B1.DOKTER_ID IN (
                                        SELECT 
                                            A1.PASIEN_ID||A1.DOKTER_ID 
                                        FROM 
                                            FRM_RESEP_DOKTER_MS A1 
                                        WHERE 
                                            A1.PASIEN_ID = B1.MR 
                                            AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                            --AND TO_CHAR(A1.CREATED_DATE,'DDMMYYYY') = 01122021)
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112'  
                                    AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                                
                            )
                        ,'N') AS RESEP,
                        NVL(
                            (
                                SELECT
                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS SELESAI 
                                FROM
                                    FRM_TRANS_MS B1
                                WHERE
                                    B1.JH_MR = X.MR
                                    AND B1.JH_DOKTER_ID = X.DOKTER_ID
                                    AND B1.JH_DONE_STATUS <> '03'
                                    AND B1.JH_JENIS_JUAL IN ('1','2','3','4')
                                    AND TRUNC(B1.JH_CREATED_DATE)=TRUNC(SYSDATE)
                            )
                        ,0) AS SELESAI
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
                            CASE 
                            WHEN 
                                A.DONE_STATUS LIKE '%3'
                            THEN 'Y'
                            ELSE 'N' 
                            END AS BATAL           
                        FROM 
                            MS_TRANS_OP A, 
                            MS_MEDREC B, 
                            MS_HIS_DOKTER C
                        WHERE 
                            TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                            --TO_CHAR(A.CREATED_DATE,'DDMMYYYY') = 01122021
                            AND A.MR=B.MR
                            AND A.DOKTER_ID=C.DOKTER_ID
                            AND A.TIPE_RAWAT = 'P'
                            AND(SUBSTR(A.DEPT_ID,1,3)='112' 
                            AND A.DEPT_ID NOT IN ('1120201000','1120401000'))
                    )X
                )PP
                WHERE 
                    PP.BATAL LIKE '" . $batal . "'||'%'
                    AND PP.JML_DOKTER >= " . $jml_dr . "
                    AND PP.RESEP LIKE '" . $resep . "'||'%'
                    AND PP.SELESAI LIKE '" . $selesai . "'||'%'
                ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER";
        
        $query = $this->oracle_db->query($sql);
        $row_count = $query->num_rows();
        return $row_count;
    }

    function getMonitor($batal, $jml_dr, $resep, $selesai, $pagestart, $per_page)
    {
        if ($per_page <> '')
        {
            $sql = "SELECT 
                        PP.*
                    FROM 
                    (
                        SELECT 
                            ROW_NUMBER() OVER (ORDER BY X.JAM DESC, X.MR, X.DOKTER ASC ) AS RNUM, 
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
                                        AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                        --AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                                ),0
                            ) AS JML_DOKTER,
                            NVL(
                                (
                                    SELECT 
                                        CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS RESEP
                                    FROM 
                                        MS_TRANS_OP B1 
                                    WHERE
                                        B1.TIPE_RAWAT = 'P'
                                        AND (SUBSTR(B1.DEPT_ID,1,3)='112' AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                        AND B1.MR=X.MR
                                        AND B1.DONE_STATUS NOT LIKE '%3'
                                        AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                        --AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                                        AND B1.MR||B1.DOKTER_ID IN (
                                            SELECT 
                                                A1.PASIEN_ID||A1.DOKTER_ID 
                                            FROM 
                                                FRM_RESEP_DOKTER_MS A1 
                                            WHERE 
                                                A1.PASIEN_ID = B1.MR 
                                                AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                                --AND TO_CHAR(A1.CREATED_DATE,'DDMMYYYY') = 01122021)
                                        AND (SUBSTR(B1.DEPT_ID,1,3)='112'  
                                        AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                                    
                                )
                            ,'N') AS RESEP,
                            NVL(
                                (
                                    SELECT
                                        CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS SELESAI 
                                    FROM
                                        FRM_TRANS_MS B1
                                    WHERE
                                        B1.JH_MR = X.MR
                                        AND B1.JH_DOKTER_ID = X.DOKTER_ID
                                        AND B1.JH_DONE_STATUS <> '03'
                                        AND B1.JH_JENIS_JUAL IN ('1','2','3','4')
                                        AND TRUNC(B1.JH_CREATED_DATE)=TRUNC(SYSDATE)
                                )
                            ,0) AS SELESAI
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
                                CASE 
                                WHEN 
                                    A.DONE_STATUS LIKE '%3'
                                THEN 'Y'
                                ELSE 'N' 
                                END AS BATAL           
                            FROM 
                                MS_TRANS_OP A, 
                                MS_MEDREC B, 
                                MS_HIS_DOKTER C
                            WHERE 
                                TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                --TO_CHAR(A.CREATED_DATE,'DDMMYYYY') = 01122021
                                AND A.MR=B.MR
                                AND A.DOKTER_ID=C.DOKTER_ID
                                AND A.TIPE_RAWAT = 'P'
                                AND(SUBSTR(A.DEPT_ID,1,3)='112' 
                                AND A.DEPT_ID NOT IN ('1120201000','1120401000'))
                        )X
                    )PP
                    WHERE 
                        PP.BATAL LIKE '" . $batal . "'||'%'
                        AND PP.JML_DOKTER >= " . $jml_dr . "
                        AND PP.RESEP LIKE '" . $resep . "'||'%'
                        AND PP.SELESAI LIKE '" . $selesai . "'||'%'
                        AND PP.RNUM >= " . ($pagestart) . "
                        AND PP.RNUM <= " . (($pagestart-1) + $per_page) . "
                    ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER";

        } else {
            $sql = "SELECT 
                    PP.*
                FROM 
                (
                    SELECT 
                        ROW_NUMBER() OVER (ORDER BY X.JAM DESC, X.MR, X.DOKTER ASC ) AS RNUM, 
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
                                    AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    --AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                            ),0
                        ) AS JML_DOKTER,
                        NVL(
                            (
                                SELECT 
                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS RESEP
                                FROM 
                                    MS_TRANS_OP B1 
                                WHERE
                                    B1.TIPE_RAWAT = 'P'
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112' AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                    AND B1.MR=X.MR
                                    AND B1.DONE_STATUS NOT LIKE '%3'
                                    AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    --AND TO_CHAR(B1.CREATED_DATE,'DDMMYYYY') = 01122021
                                    AND B1.MR||B1.DOKTER_ID IN (
                                        SELECT 
                                            A1.PASIEN_ID||A1.DOKTER_ID 
                                        FROM 
                                            FRM_RESEP_DOKTER_MS A1 
                                        WHERE 
                                            A1.PASIEN_ID = B1.MR 
                                            AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                            --AND TO_CHAR(A1.CREATED_DATE,'DDMMYYYY') = 01122021)
                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112'  
                                    AND B1.DEPT_ID NOT IN ('1120201000','1120401000'))
                                                
                            )
                        ,'N') AS RESEP,
                        NVL(
                            (
                                SELECT
                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS SELESAI 
                                FROM
                                    FRM_TRANS_MS B1
                                WHERE
                                    B1.JH_MR = X.MR
                                    AND B1.JH_DOKTER_ID = X.DOKTER_ID
                                    AND B1.JH_DONE_STATUS <> '03'
                                    AND B1.JH_JENIS_JUAL IN ('1','2','3','4')
                                    AND TRUNC(B1.JH_CREATED_DATE)=TRUNC(SYSDATE)
                            )
                        ,0) AS SELESAI
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
                            CASE 
                            WHEN 
                                A.DONE_STATUS LIKE '%3'
                            THEN 'Y'
                            ELSE 'N' 
                            END AS BATAL           
                        FROM 
                            MS_TRANS_OP A, 
                            MS_MEDREC B, 
                            MS_HIS_DOKTER C
                        WHERE 
                            TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                            --TO_CHAR(A.CREATED_DATE,'DDMMYYYY') = 01122021
                            AND A.MR=B.MR
                            AND A.DOKTER_ID=C.DOKTER_ID
                            AND A.TIPE_RAWAT = 'P'
                            AND(SUBSTR(A.DEPT_ID,1,3)='112' 
                            AND A.DEPT_ID NOT IN ('1120201000','1120401000'))
                    )X
                )PP
                WHERE 
                    PP.BATAL LIKE '" . $batal . "'||'%'
                    AND PP.JML_DOKTER >= " . $jml_dr . "
                    AND PP.RESEP LIKE '" . $resep . "'||'%'
                    AND PP.SELESAI LIKE '" . $selesai . "'||'%'
                ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER";
        }

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getRecordsMedrec($mr, $name, $birth_date, $telp, $address, $parent)
    {
        $sql = "SELECT
                    SUBSTR(A.MR,4) AS MR,
                    A.NAMA,
                    NVL(A.TEMPAT_LAHIR,'-') AS TEMPAT_LAHIR, 
                    TO_CHAR(A.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR,
                    CASE WHEN A.ALAMAT = '' THEN '-'
                    ELSE
                        (A.ALAMAT || ' RT.' || A.RT || ' RW.' || A.RW) 
                    END AS ALAMAT,
                    A.KOTA,
                    A.KECAMATAN, 
                    A.KELURAHAN,
                    A.BIN_BINTI, 
                    A.NAMA_ORG_TUA, 
                    A.NO_TELP, 
                    A.NO_HP
                FROM
                    HIS_MANAGER.MS_MEDREC A
                WHERE
                    SUBSTR(A.MR,4) LIKE '" . $mr . "' || '%' AND
                    A.NAMA LIKE '" . $name . "' || '%' AND
                    A.TGL_LAHIR = TO_DATE('" . $birth_date . "','DD.MM.YYYY') AND
                    (
                        (A.NO_TELP LIKE '" . $telp . "' || '%' OR A.NO_TELP IS NULL) OR  
                        (A.NO_HP LIKE '" . $telp . "' || '%' OR A.NO_HP IS NULL)
                    ) AND
                    (
                        A.ALAMAT LIKE '" . $address . "' || '%' OR 
                        A.KELURAHAN LIKE '" . $address . "' || '%' OR 
                        A.KECAMATAN LIKE '" . $address . "' || '%' OR 
                        A.KOTA LIKE '" . $address . "' || '%'
                    ) AND
                    (
                        (A.BIN_BINTI LIKE '" . $parent . "' || '%' OR A.BIN_BINTI IS NULL) OR 
                        (A.NAMA_ORG_TUA LIKE '" . $parent . "' || '%' OR A.NAMA_ORG_TUA IS NULL)
                    ) AND
                    A.SHOW_ITEM = '1'
                    AND SUBSTR(A.MR,4,1) IN ('0','1','2','3','4','5','6','7','8','9')
                    "; 

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getRowMedrec($mr)
    {
        $sql = "SELECT
                    SUBSTR(A.MR,4) AS MR,
                    A.NAMA,
                    NVL(A.TEMPAT_LAHIR,'-') AS TEMPAT_LAHIR, 
                    TO_CHAR(A.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR,
                    CASE WHEN A.ALAMAT = '' THEN '-'
                    ELSE
                        (A.ALAMAT || ' RT.' || A.RT || ' RW.' || A.RW) 
                    END AS ALAMAT,
                    A.KOTA,
                    A.KECAMATAN, 
                    A.KELURAHAN,
                    A.BIN_BINTI, 
                    A.NAMA_ORG_TUA, 
                    A.NO_TELP, 
                    A.NO_HP
                FROM
                    HIS_MANAGER.MS_MEDREC A
                WHERE
                    SUBSTR(A.MR,4) = '" . $mr . "' AND
                    A.SHOW_ITEM = '1'
                    "; 
        
        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }
}
