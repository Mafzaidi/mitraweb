<?php

class M_counter extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getRowcountMonitorX($batal, $jml_dr, $resep, $selesai)
    {
        
        $sql = "SELECT 
                    XX.*
                FROM
                (
                    SELECT 
                        ROW_NUMBER() OVER (ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER ASC ) AS RNUM,
                        PP.*
                    FROM 
                    (
                        SELECT
                            X.*,
                            NVL(
                                (
                                    SELECT 
                                        COUNT(*) 
                                    FROM 
                                        HIS_MANAGER.MS_TRANS_OP B1 
                                    WHERE
                                        B1.TIPE_RAWAT = 'P'
                                        AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                        AND B1.MR=X.MR
                                        AND B1.DONE_STATUS NOT LIKE '%3'
                                        AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                ),0
                            ) AS JML_DOKTER,
                            NVL(
                                (
                                    SELECT 
                                        CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS RESEP
                                    FROM 
                                        HIS_MANAGER.MS_TRANS_OP B1 
                                    WHERE
                                        B1.TIPE_RAWAT = 'P'
                                        AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                        AND B1.MR=X.MR
                                        AND B1.DONE_STATUS NOT LIKE '%3'
                                        AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                        AND B1.MR||B1.DOKTER_ID IN (
                                            SELECT 
                                                A1.PASIEN_ID||A1.DOKTER_ID 
                                            FROM 
                                                FRM_RESEP_DOKTER_MS A1 
                                            WHERE 
                                                A1.PASIEN_ID = B1.MR 
                                                AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                        AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                                    
                                )
                            ,'N') AS RESEP,
                            NVL(
                                (
                                    SELECT
                                        CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS SELESAI 
                                    FROM
                                        HIS_MANAGER.FRM_TRANS_MS B1
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
                                SUBSTR(A.MR,4) PID, 
                                C.DOKTER_ID,
                                CASE 
                                WHEN 
                                    A.DONE_STATUS LIKE '%3'
                                THEN 'Y'
                                ELSE 'N' 
                                END AS BATAL           
                            FROM 
                                HIS_MANAGER.MS_TRANS_OP A, 
                                HIS_MANAGER.MS_MEDREC B, 
                                HIS_MANAGER.MS_HIS_DOKTER C
                            WHERE 
                                TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                AND A.MR=B.MR
                                AND A.DOKTER_ID=C.DOKTER_ID
                                AND A.TIPE_RAWAT = 'P'
                                AND(SUBSTR(A.DEPT_ID,1,3)='112')
                        )X
                    )PP
                    WHERE 
                        PP.BATAL LIKE '" . $batal . "'||'%'
                        AND PP.JML_DOKTER >= " . $jml_dr . "
                        AND PP.RESEP LIKE '" . $resep . "'||'%'
                        AND PP.SELESAI LIKE '" . $selesai . "'||'%'
                ) XX
                ORDER BY XX.JAM DESC, XX.MR, XX.DOKTER";
        
        $query = $this->oracle_db->query($sql);
        $row_count = $query->num_rows();
        return $row_count;
    }

    function getMonitorX($batal, $jml_dr, $resep, $selesai, $page_start, $per_page)
    {
        if ($per_page <> '')
        {
            $sql = "SELECT 
                        XX.*
                    FROM
                    (
                        SELECT 
                            ROW_NUMBER() OVER (ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER ASC ) AS RNUM,
                            PP.*
                        FROM 
                        (
                            SELECT
                                X.*,
                                NVL(
                                    (
                                        SELECT 
                                            COUNT(*) 
                                        FROM 
                                            HIS_MANAGER.MS_TRANS_OP B1 
                                        WHERE
                                            B1.TIPE_RAWAT = 'P'
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                            AND B1.MR=X.MR
                                            AND B1.DONE_STATUS NOT LIKE '%3'
                                            AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    ),0
                                ) AS JML_DOKTER,
                                NVL(
                                    (
                                        SELECT 
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS RESEP
                                        FROM 
                                            HIS_MANAGER.MS_TRANS_OP B1 
                                        WHERE
                                            B1.TIPE_RAWAT = 'P'
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                            AND B1.MR=X.MR
                                            AND B1.DONE_STATUS NOT LIKE '%3'
                                            AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                            AND B1.MR||B1.DOKTER_ID IN (
                                                SELECT 
                                                    A1.PASIEN_ID||A1.DOKTER_ID 
                                                FROM 
                                                    HIS_MANAGER.FRM_RESEP_DOKTER_MS A1 
                                                WHERE 
                                                    A1.PASIEN_ID = B1.MR 
                                                    AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                                        
                                    )
                                ,'N') AS RESEP,
                                NVL(
                                    (
                                        SELECT
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS SELESAI 
                                        FROM
                                            HIS_MANAGER.FRM_TRANS_MS B1
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
                                    SUBSTR(A.MR,4) PID, 
                                    C.DOKTER_ID,
                                    CASE 
                                    WHEN 
                                        A.DONE_STATUS LIKE '%3'
                                    THEN 'Y'
                                    ELSE 'N' 
                                    END AS BATAL           
                                FROM 
                                    HIS_MANAGER.MS_TRANS_OP A, 
                                    HIS_MANAGER.MS_MEDREC B, 
                                    HIS_MANAGER.MS_HIS_DOKTER C
                                WHERE 
                                    TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                    AND A.MR=B.MR
                                    AND A.DOKTER_ID=C.DOKTER_ID
                                    AND A.TIPE_RAWAT = 'P'
                                    AND(SUBSTR(A.DEPT_ID,1,3)='112')
                            )X
                        )PP
                        WHERE 
                            PP.BATAL LIKE '" . $batal . "'||'%'
                            AND PP.JML_DOKTER >= " . $jml_dr . "
                            AND PP.RESEP LIKE '" . $resep . "'||'%'
                            AND PP.SELESAI LIKE '" . $selesai . "'||'%'
                    ) XX
                    WHERE 
                        XX.RNUM >= " . ($page_start) . "
                        AND XX.RNUM <= " . (($page_start-1) + $per_page) . "
                    ORDER BY XX.JAM DESC, XX.MR, XX.DOKTER";

        } else {
            $sql = "SELECT 
                        XX.*
                    FROM
                    (
                        SELECT 
                            ROW_NUMBER() OVER (ORDER BY PP.JAM DESC, PP.MR, PP.DOKTER ASC ) AS RNUM,
                            PP.*
                        FROM 
                        (
                            SELECT
                                X.*,
                                NVL(
                                    (
                                        SELECT 
                                            COUNT(*) 
                                        FROM 
                                            HIS_MANAGER.MS_TRANS_OP B1 
                                        WHERE
                                            B1.TIPE_RAWAT = 'P'
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                            AND B1.MR=X.MR
                                            AND B1.DONE_STATUS NOT LIKE '%3'
                                            AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                    ),0
                                ) AS JML_DOKTER,
                                NVL(
                                    (
                                        SELECT 
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS RESEP
                                        FROM 
                                            HIS_MANAGER.MS_TRANS_OP B1 
                                        WHERE
                                            B1.TIPE_RAWAT = 'P'
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                            AND B1.MR=X.MR
                                            AND B1.DONE_STATUS NOT LIKE '%3'
                                            AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                            AND B1.MR||B1.DOKTER_ID IN (
                                                SELECT 
                                                    A1.PASIEN_ID||A1.DOKTER_ID 
                                                FROM 
                                                    HIS_MANAGER.FRM_RESEP_DOKTER_MS A1
                                                WHERE 
                                                    A1.PASIEN_ID = B1.MR 
                                                    AND TRUNC(A1.CREATED_DATE)=TRUNC(SYSDATE))
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                                        
                                    )
                                ,'N') AS RESEP,
                                NVL(
                                    (
                                        SELECT
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END AS SELESAI 
                                        FROM
                                            HIS_MANAGER.FRM_TRANS_MS B1
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
                                    SUBSTR(A.MR,4) PID, 
                                    C.DOKTER_ID,
                                    CASE 
                                    WHEN 
                                        A.DONE_STATUS LIKE '%3'
                                    THEN 'Y'
                                    ELSE 'N' 
                                    END AS BATAL           
                                FROM 
                                    HIS_MANAGER.MS_TRANS_OP A, 
                                    HIS_MANAGER.MS_MEDREC B, 
                                    HIS_MANAGER.MS_HIS_DOKTER C
                                WHERE 
                                    TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                    AND A.MR=B.MR
                                    AND A.DOKTER_ID=C.DOKTER_ID
                                    AND A.TIPE_RAWAT = 'P'
                                    AND(SUBSTR(A.DEPT_ID,1,3)='112')
                            )X
                        )PP
                        WHERE 
                            PP.BATAL LIKE '" . $batal . "'||'%'
                            AND PP.JML_DOKTER >= " . $jml_dr . "
                            AND PP.RESEP LIKE '" . $resep . "'||'%'
                            AND PP.SELESAI LIKE '" . $selesai . "'||'%'
                    ) XX
                    ORDER BY XX.JAM DESC, XX.MR, XX.DOKTER";
        }

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getMonitor(
        $ctr_daftar,
        $dr_selesai,
        $ctr_selesai,
        $ctr_batal,
        $jml_dr,
        $ada_resep,
        $ada_lab,
        $ada_rad,
        $page_start,
        $per_page,
        $search
    )
    {
        if ($per_page <> '') {
                $sql = "SELECT
                            XXX.*
                        FROM
                        (
                            SELECT 
                                ROW_NUMBER() OVER (ORDER BY XX.JAM_DAFTAR DESC, XX.MR, XX.DOKTER ASC ) AS RNUM,
                                XX.*
                            FROM
                            (
                                SELECT 
                                    PP.*,
                                    CASE 
                                        WHEN 
                                            PP.DONE_STATUS LIKE '%0' AND 
                                            PP.COUNTER_BATAL = 'N' AND
                                            PP.COUNTER_SELESAI = 'N' AND 
                                            PP.DOKTER_SELESAI = 'N'
                                        THEN 'COUNTER DAFTAR'
                                        WHEN
                                            PP.DONE_STATUS LIKE '%0' AND 
                                            PP.COUNTER_BATAL = 'N' AND
                                            PP.COUNTER_SELESAI = 'N' AND
                                            PP.DOKTER_SELESAI = 'Y'
                                        THEN 'DOKTER SELESAI'
                                        WHEN
                                            PP.DONE_STATUS LIKE '%3' AND 
                                            PP.COUNTER_BATAL = 'Y' AND
                                            (PP.COUNTER_SELESAI = 'N' OR PP.COUNTER_SELESAI = 'Y') AND
                                            (PP.DOKTER_SELESAI = 'N' OR PP.DOKTER_SELESAI = 'Y')
                                        THEN 'COUNTER BATAL'
                                        WHEN
                                            (PP.DONE_STATUS LIKE '%1' OR PP.DONE_STATUS LIKE '%2') AND 
                                            PP.COUNTER_BATAL = 'N' AND
                                            PP.COUNTER_SELESAI = 'Y' AND
                                            (PP.DOKTER_SELESAI = 'N' OR PP.DOKTER_SELESAI = 'Y')
                                        THEN 'COUNTER SELESAI'
                                        ELSE 'NONE'
                                    END AS STATUS
                                FROM 
                                (
                                    SELECT
                                        X.*,
                                        NVL(
                                            (
                                                SELECT 
                                                    COUNT(*) 
                                                FROM 
                                                    HIS_MANAGER.MS_TRANS_OP B1 
                                                WHERE
                                                    B1.TIPE_RAWAT = 'P'
                                                    AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                                    AND B1.MR=X.MR
                                                    AND B1.DONE_STATUS NOT LIKE '%3'
                                                    AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                                    AND TRUNC(B1.DAFTAR_TGL) = TRUNC(X.DAFTAR_TGL)
                                            ),0
                                        ) AS JML_DOKTER,
                                        NVL(
                                            (
                                                SELECT
                                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                                FROM
                                                    FRM_RESEP_DOKTER_MS C1
                                                WHERE
                                                    C1.DOKTER_ID = X.DOKTER_ID
                                                    AND C1.PASIEN_ID = X.MR
                                                    AND C1.REG_ID IS NULL
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                            )
                                        ,'') AS DOKTER_SELESAI,
                                        NVL(
                                            (
                                                SELECT
                                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                                FROM
                                                    FRM_RESEP_DOKTER_MS C1,
                                                    FRM_RESEP_DOKTER_DT D1
                                                WHERE
                                                    C1.DOKTER_ID = X.DOKTER_ID
                                                    AND C1.PASIEN_ID = X.MR
                                                    AND C1.RESEP_ID = D1.RESEP_ID
                                                    AND C1.REG_ID IS NULL
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                            )
                                        ,'') AS ADA_RESEP,
                                        NVL(
                                            (
                                                SELECT
                                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                                FROM
                                                    FRM_RESEP_DOKTER_MS C1,
                                                    CO_LAB_DT D1
                                                WHERE
                                                    C1.RESEP_ID = D1.RESEP_ID
                                                    AND C1.PASIEN_ID = X.MR
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                            )
                                        ,'') AS ADA_LAB,
                                        NVL(
                                            (
                                                SELECT
                                                    CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                                FROM
                                                    FRM_RESEP_DOKTER_MS C1,
                                                    CO_RAD_DT D1
                                                WHERE
                                                    C1.RESEP_ID = D1.RESEP_ID
                                                    AND C1.PASIEN_ID = X.MR
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                    AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                            )
                                        ,'') AS ADA_RAD
                                    FROM(
                                        SELECT 
                                            A.MR, 
                                            B.NAMA PASIEN, 
                                            C.NAMA_DR DOKTER, 
                                            A.NO_URUT, 
                                            A.NO_TR_LAMA NO_BUKTI, 
                                            TO_CHAR(A.CREATED_DATE,'HH24:MI:SS') JAM_DAFTAR,
                                            A.CREATED_DATE,
                                            TRUNC(A.DAFTAR_TGL) AS DAFTAR_TGL,
                                            SUBSTR(A.MR,4) PID, 
                                            C.DOKTER_ID,
                                            A.DONE_STATUS,
                                            CASE WHEN A.DONE_STATUS LIKE '%3' THEN 'Y' ELSE 'N' END AS COUNTER_BATAL,
                                            CASE WHEN (A.DONE_STATUS LIKE '%1' OR A.DONE_STATUS LIKE '%2') THEN 'Y' ELSE 'N' END AS COUNTER_SELESAI                    
                                        FROM 
                                            HIS_MANAGER.MS_TRANS_OP A, 
                                            HIS_MANAGER.MS_MEDREC B, 
                                            HIS_MANAGER.MS_HIS_DOKTER C
                                        WHERE 
                                            TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                            AND A.MR=B.MR
                                            AND A.DOKTER_ID=C.DOKTER_ID
                                            AND A.TIPE_RAWAT = 'P'
                                            AND(SUBSTR(A.DEPT_ID,1,3)='112')
                                    )X
                                )PP
                            ) XX
                            WHERE    
                                XX.JML_DOKTER >= " . $jml_dr . "
                                AND
                                    (
                                        XX.STATUS LIKE '" . $ctr_daftar . "'||'%' OR 
                                        XX.STATUS LIKE '" . $dr_selesai . "'||'%' OR
                                        XX.STATUS LIKE '" . $ctr_selesai . "'||'%' OR
                                        XX.STATUS LIKE '" . $ctr_batal . "'||'%'
                                    )
                                AND XX.ADA_RESEP LIKE '" . $ada_resep . "'||'%'
                                AND XX.ADA_LAB LIKE '" . $ada_lab . "'||'%'
                                AND XX.ADA_RAD LIKE '" . $ada_rad . "'||'%'
                                AND (XX.PID LIKE '%'||'" . $search . "'||'%' OR XX.PASIEN LIKE '%'||'" . $search . "'||'%')
                        ) XXX
                        WHERE
                            XXX.RNUM >= " . ($page_start) . "
                            AND XXX.RNUM <= " . (($page_start-1) + $per_page) . "
                        ORDER BY XXX.JAM_DAFTAR DESC, XXX.MR, XXX.DOKTER";
        } else {
            $sql = "SELECT
                        XXX.*
                    FROM
                    (
                        SELECT 
                            ROW_NUMBER() OVER (ORDER BY XX.JAM_DAFTAR DESC, XX.MR, XX.DOKTER ASC ) AS RNUM,
                            XX.*
                        FROM
                        (
                            SELECT 
                                PP.*,
                                CASE 
                                    WHEN 
                                        PP.DONE_STATUS LIKE '%0' AND 
                                        PP.COUNTER_BATAL = 'N' AND
                                        PP.COUNTER_SELESAI = 'N' AND 
                                        PP.DOKTER_SELESAI = 'N'
                                    THEN 'COUNTER DAFTAR'
                                    WHEN
                                        PP.DONE_STATUS LIKE '%0' AND 
                                        PP.COUNTER_BATAL = 'N' AND
                                        PP.COUNTER_SELESAI = 'N' AND
                                        PP.DOKTER_SELESAI = 'Y'
                                    THEN 'DOKTER SELESAI'
                                    WHEN
                                        PP.DONE_STATUS LIKE '%3' AND 
                                        PP.COUNTER_BATAL = 'Y' AND
                                        (PP.COUNTER_SELESAI = 'N' OR PP.COUNTER_SELESAI = 'Y') AND
                                        (PP.DOKTER_SELESAI = 'N' OR PP.DOKTER_SELESAI = 'Y')
                                    THEN 'COUNTER BATAL'
                                    WHEN
                                        (PP.DONE_STATUS LIKE '%1' OR PP.DONE_STATUS LIKE '%2') AND 
                                        PP.COUNTER_BATAL = 'N' AND
                                        PP.COUNTER_SELESAI = 'Y' AND
                                        (PP.DOKTER_SELESAI = 'N' OR PP.DOKTER_SELESAI = 'Y')
                                    THEN 'COUNTER SELESAI'
                                    ELSE 'NONE'
                                END AS STATUS
                            FROM 
                            (
                                SELECT
                                    X.*,
                                    NVL(
                                        (
                                            SELECT 
                                                COUNT(*) 
                                            FROM 
                                                HIS_MANAGER.MS_TRANS_OP B1 
                                            WHERE
                                                B1.TIPE_RAWAT = 'P'
                                                AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                                AND B1.MR=X.MR
                                                AND B1.DONE_STATUS NOT LIKE '%3'
                                                AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                                AND TRUNC(B1.DAFTAR_TGL) = TRUNC(X.DAFTAR_TGL)
                                        ),0
                                    ) AS JML_DOKTER,
                                    NVL(
                                        (
                                            SELECT
                                                CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                            FROM
                                                FRM_RESEP_DOKTER_MS C1
                                            WHERE
                                                C1.DOKTER_ID = X.DOKTER_ID
                                                AND C1.PASIEN_ID = X.MR
                                                AND C1.REG_ID IS NULL
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                        )
                                    ,'') AS DOKTER_SELESAI,
                                    NVL(
                                        (
                                            SELECT
                                                CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                            FROM
                                                FRM_RESEP_DOKTER_MS C1,
                                                FRM_RESEP_DOKTER_DT D1
                                            WHERE
                                                C1.DOKTER_ID = X.DOKTER_ID
                                                AND C1.PASIEN_ID = X.MR
                                                AND C1.RESEP_ID = D1.RESEP_ID
                                                AND C1.REG_ID IS NULL
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                        )
                                    ,'') AS ADA_RESEP,
                                    NVL(
                                        (
                                            SELECT
                                                CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                            FROM
                                                FRM_RESEP_DOKTER_MS C1,
                                                CO_LAB_DT D1
                                            WHERE
                                                C1.RESEP_ID = D1.RESEP_ID
                                                AND C1.PASIEN_ID = X.MR
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                        )
                                    ,'') AS ADA_LAB,
                                    NVL(
                                        (
                                            SELECT
                                                CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                            FROM
                                                FRM_RESEP_DOKTER_MS C1,
                                                CO_RAD_DT D1
                                            WHERE
                                                C1.RESEP_ID = D1.RESEP_ID
                                                AND C1.PASIEN_ID = X.MR
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                                AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                        )
                                    ,'') AS ADA_RAD
                                FROM(
                                    SELECT 
                                        A.MR, 
                                        B.NAMA PASIEN, 
                                        C.NAMA_DR DOKTER, 
                                        A.NO_URUT, 
                                        A.NO_TR_LAMA NO_BUKTI, 
                                        TO_CHAR(A.CREATED_DATE,'HH24:MI:SS') JAM_DAFTAR,
                                        A.CREATED_DATE,
                                        TRUNC(A.DAFTAR_TGL) AS DAFTAR_TGL,
                                        SUBSTR(A.MR,4) PID, 
                                        C.DOKTER_ID,
                                        A.DONE_STATUS,
                                        CASE WHEN A.DONE_STATUS LIKE '%3' THEN 'Y' ELSE 'N' END AS COUNTER_BATAL,
                                        CASE WHEN (A.DONE_STATUS LIKE '%1' OR A.DONE_STATUS LIKE '%2') THEN 'Y' ELSE 'N' END AS COUNTER_SELESAI                    
                                    FROM 
                                        HIS_MANAGER.MS_TRANS_OP A, 
                                        HIS_MANAGER.MS_MEDREC B, 
                                        HIS_MANAGER.MS_HIS_DOKTER C
                                    WHERE 
                                        TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                        AND A.MR=B.MR
                                        AND A.DOKTER_ID=C.DOKTER_ID
                                        AND A.TIPE_RAWAT = 'P'
                                        AND(SUBSTR(A.DEPT_ID,1,3)='112')
                                )X
                            )PP
                        ) XX
                        WHERE    
                            XX.JML_DOKTER >= " . $jml_dr . "
                            AND
                                (
                                    XX.STATUS LIKE '" . $ctr_daftar . "'||'%' OR 
                                    XX.STATUS LIKE '" . $dr_selesai . "'||'%' OR
                                    XX.STATUS LIKE '" . $ctr_selesai . "'||'%' OR
                                    XX.STATUS LIKE '" . $ctr_batal . "'||'%'
                                )
                            AND XX.ADA_RESEP LIKE '" . $ada_resep . "'||'%'
                            AND XX.ADA_LAB LIKE '" . $ada_lab . "'||'%'
                            AND XX.ADA_RAD LIKE '" . $ada_rad . "'||'%'
                            AND (XX.PID LIKE '%'||'" . $search . "'||'%' OR XX.PASIEN LIKE '%'||'" . $search . "'||'%')
                    ) XXX
                    ORDER BY XXX.JAM_DAFTAR DESC, XXX.MR, XXX.DOKTER";
        }

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
        
    }

    function getRowcountMonitor(
        $ctr_daftar,
        $dr_selesai,
        $ctr_selesai,
        $ctr_batal,
        $jml_dr,
        $ada_resep,
        $ada_lab,
        $ada_rad,
        $search
        )
    {
        $sql = "SELECT
                    XXX.*
                FROM
                (
                    SELECT 
                        ROW_NUMBER() OVER (ORDER BY XX.JAM_DAFTAR DESC, XX.MR, XX.DOKTER ASC ) AS RNUM,
                        XX.*
                    FROM
                    (
                        SELECT 
                            PP.*,
                            CASE 
                                WHEN 
                                    PP.DONE_STATUS LIKE '%0' AND 
                                    PP.COUNTER_BATAL = 'N' AND
                                    PP.COUNTER_SELESAI = 'N' AND 
                                    PP.DOKTER_SELESAI = 'N'
                                THEN 'COUNTER DAFTAR'
                                WHEN
                                    PP.DONE_STATUS LIKE '%0' AND 
                                    PP.COUNTER_BATAL = 'N' AND
                                    PP.COUNTER_SELESAI = 'N' AND
                                    PP.DOKTER_SELESAI = 'Y'
                                THEN 'DOKTER SELESAI'
                                WHEN
                                    PP.DONE_STATUS LIKE '%3' AND 
                                    PP.COUNTER_BATAL = 'Y' AND
                                    (PP.COUNTER_SELESAI = 'N' OR PP.COUNTER_SELESAI = 'Y') AND
                                    (PP.DOKTER_SELESAI = 'N' OR PP.DOKTER_SELESAI = 'Y')
                                THEN 'COUNTER BATAL'
                                WHEN
                                    (PP.DONE_STATUS LIKE '%1' OR PP.DONE_STATUS LIKE '%2') AND 
                                    PP.COUNTER_BATAL = 'N' AND
                                    PP.COUNTER_SELESAI = 'Y' AND
                                    (PP.DOKTER_SELESAI = 'N' OR PP.DOKTER_SELESAI = 'Y')
                                THEN 'COUNTER SELESAI'
                                ELSE 'NONE'
                            END AS STATUS
                        FROM 
                        (
                            SELECT
                                X.*,
                                NVL(
                                    (
                                        SELECT 
                                            COUNT(*) 
                                        FROM 
                                            HIS_MANAGER.MS_TRANS_OP B1 
                                        WHERE
                                            B1.TIPE_RAWAT = 'P'
                                            AND (SUBSTR(B1.DEPT_ID,1,3)='112')
                                            AND B1.MR=X.MR
                                            AND B1.DONE_STATUS NOT LIKE '%3'
                                            AND TRUNC(B1.CREATED_DATE)=TRUNC(SYSDATE)
                                            AND TRUNC(B1.DAFTAR_TGL) = TRUNC(X.DAFTAR_TGL)
                                    ),0
                                ) AS JML_DOKTER,
                                NVL(
                                    (
                                        SELECT
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                        FROM
                                            FRM_RESEP_DOKTER_MS C1
                                        WHERE
                                            C1.DOKTER_ID = X.DOKTER_ID
                                            AND C1.PASIEN_ID = X.MR
                                            AND C1.REG_ID IS NULL
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                    )
                                ,'') AS DOKTER_SELESAI,
                                NVL(
                                    (
                                        SELECT
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                        FROM
                                            FRM_RESEP_DOKTER_MS C1,
                                            FRM_RESEP_DOKTER_DT D1
                                        WHERE
                                            C1.DOKTER_ID = X.DOKTER_ID
                                            AND C1.PASIEN_ID = X.MR
                                            AND C1.RESEP_ID = D1.RESEP_ID
                                            AND C1.REG_ID IS NULL
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                    )
                                ,'') AS ADA_RESEP,
                                NVL(
                                    (
                                        SELECT
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                        FROM
                                            FRM_RESEP_DOKTER_MS C1,
                                            CO_LAB_DT D1
                                        WHERE
                                            C1.RESEP_ID = D1.RESEP_ID
                                            AND C1.PASIEN_ID = X.MR
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                    )
                                ,'') AS ADA_LAB,
                                NVL(
                                    (
                                        SELECT
                                            CASE WHEN COUNT(*) > 0 THEN 'Y' ELSE 'N' END
                                        FROM
                                            FRM_RESEP_DOKTER_MS C1,
                                            CO_RAD_DT D1
                                        WHERE
                                            C1.RESEP_ID = D1.RESEP_ID
                                            AND C1.PASIEN_ID = X.MR
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(SYSDATE)
                                            AND TRUNC(C1.CREATED_DATE) = TRUNC(X.CREATED_DATE)
                                    )
                                ,'') AS ADA_RAD
                            FROM(
                                SELECT 
                                    A.MR, 
                                    B.NAMA PASIEN, 
                                    C.NAMA_DR DOKTER, 
                                    A.NO_URUT, 
                                    A.NO_TR_LAMA NO_BUKTI, 
                                    TO_CHAR(A.CREATED_DATE,'HH24:MI:SS') JAM_DAFTAR,
                                    A.CREATED_DATE,
                                    TRUNC(A.DAFTAR_TGL) AS DAFTAR_TGL,
                                    SUBSTR(A.MR,4) PID, 
                                    C.DOKTER_ID,
                                    A.DONE_STATUS,
                                    CASE WHEN A.DONE_STATUS LIKE '%3' THEN 'Y' ELSE 'N' END AS COUNTER_BATAL,
                                    CASE WHEN (A.DONE_STATUS LIKE '%1' OR A.DONE_STATUS LIKE '%2') THEN 'Y' ELSE 'N' END AS COUNTER_SELESAI                    
                                FROM 
                                    HIS_MANAGER.MS_TRANS_OP A, 
                                    HIS_MANAGER.MS_MEDREC B, 
                                    HIS_MANAGER.MS_HIS_DOKTER C
                                WHERE 
                                    TRUNC(A.CREATED_DATE)=TRUNC(SYSDATE)
                                    AND A.MR=B.MR
                                    AND A.DOKTER_ID=C.DOKTER_ID
                                    AND A.TIPE_RAWAT = 'P'
                                    AND(SUBSTR(A.DEPT_ID,1,3)='112')
                            )X
                        )PP
                    ) XX
                    WHERE    
                        XX.JML_DOKTER >= " . $jml_dr . "
                        AND
                            (
                                XX.STATUS LIKE '" . $ctr_daftar . "'||'%' OR 
                                XX.STATUS LIKE '" . $dr_selesai . "'||'%' OR
                                XX.STATUS LIKE '" . $ctr_selesai . "'||'%' OR
                                XX.STATUS LIKE '" . $ctr_batal . "'||'%'
                            )
                        AND XX.ADA_RESEP LIKE '" . $ada_resep . "'||'%'
                        AND XX.ADA_LAB LIKE '" . $ada_lab . "'||'%'
                        AND XX.ADA_RAD LIKE '" . $ada_rad . "'||'%'
                        AND (XX.PID LIKE '%'||'" . $search . "'||'%' OR XX.PASIEN LIKE '%'||'" . $search . "'||'%')
                ) XXX
                ORDER BY XXX.JAM_DAFTAR DESC, XXX.MR, XXX.DOKTER";

        $query = $this->oracle_db->query($sql);
        $row_count = $query->num_rows();
        return $row_count;
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
