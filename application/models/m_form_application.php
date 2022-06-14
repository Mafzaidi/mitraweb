<?php

class M_form_application extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    // Borrow MR
    function getRowCountPinjamMr($mr) {
        $sql = "SELECT
                    A.*
                FROM
                    EDP_MANAGER.PINJAM_MR A
                WHERE
                    SUBSTR(A.MR,4) = '" . $mr . "'
                    AND A.SHOW_ITEM = '1'
                    AND A.TGL_AKHIR_KEMBALI IS NULL
                ";

        $query = $this->oracle_db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    // Inpatient File
    function getRowCountCurrentInpatient($keyword, $reg_id) {
        $search_condition = "";
        if (isset($reg_id) && !empty($reg_id)) {
            $search_condition = "AND X.REG_ID = " . ($reg_id) . "";
        }

        $sql = "SELECT
                    X.*,
                    NVL(Y.REG_ID,'') AS REG_BERKAS
                FROM 
                    (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY A.TGL_MASUK ASC) AS RNUM,
                        SUBSTR(A.MR, 4) AS MEDREC,
                        SUBSTR(D.NAMA, 0, LENGTH(D.NAMA) -3) AS PASIEN,
                        A.RUANG_ID,
                        C.NAMA_DEPT,
                        E.NAMA_DR,
                        TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                        F.REKANAN_NAMA,
                        A.REG_ID
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
                        AND (D.NAMA LIKE UPPER('" . $keyword . "'||'%') OR SUBSTR(A.MR, 4) LIKE UPPER('" . $keyword . "'||'%'))
                    ) X, 
                    EDP_MANAGER.MS_REG_BERKAS Y
                WHERE
                    X.REG_ID = Y.REG_ID (+)
                    " . $search_condition . "
            ";

        $query = $this->oracle_db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    function getRowCurrentInpatient($page_start, $per_page, $keyword, $reg_id) {
        
        $page_condition = "";
        if (isset($per_page) && !empty($per_page)) {
            $page_condition = "AND X.RNUM >= " . ($page_start) . "
                                AND X.RNUM <= " . (($page_start-1) + $per_page) . "";
        }

        $search_condition = "";
        if (isset($reg_id) && !empty($reg_id)) {
            $search_condition = "AND X.REG_ID = " . ($reg_id) . "";
        }
        
        $sql = "SELECT
                    X.*,
                    NVL(Y.REG_ID,'') AS REG_BERKAS
                FROM 
                    (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY A.TGL_MASUK ASC) AS RNUM,
                        SUBSTR(A.MR, 4) AS MEDREC,
                        SUBSTR(D.NAMA, 0, LENGTH(D.NAMA) -3) AS PASIEN,
                        A.RUANG_ID,
                        C.NAMA_DEPT,
                        E.NAMA_DR,
                        TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                        F.REKANAN_NAMA,
                        A.REG_ID
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
                        AND (D.NAMA LIKE UPPER('" . $keyword . "'||'%') OR SUBSTR(A.MR, 4) LIKE UPPER('" . $keyword . "'||'%'))
                    ) X, 
                    EDP_MANAGER.MS_REG_BERKAS Y
                WHERE
                    X.REG_ID = Y.REG_ID (+)
                    " . $page_condition . "
                    " . $search_condition . "
                ORDER BY X.RNUM ASC
            ";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getDataCurrentInpatient($reg_id) {
        $sql = "SELECT
                    X.*,
                    NVL(Y.REG_ID,'') AS REG_BERKAS
                FROM 
                    (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY A.TGL_MASUK ASC) AS RNUM,
                        SUBSTR(A.MR, 4) AS MEDREC,
                        SUBSTR(D.NAMA, 0, LENGTH(D.NAMA) -3) AS PASIEN,
                        D.TGL_LAHIR,
                        ROUND((TRUNC (SYSDATE - D.TGL_LAHIR) / 365), 0)||' Thn ' ||  ROUND((TRUNC ((SYSDATE - D.TGL_LAHIR) / 365)/12), 0)|| ' Bln' UMUR,
                        A.RUANG_ID,
                        C.NAMA_DEPT,
                        E.NAMA_DR,
                        TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                        F.REKANAN_NAMA,
                        A.REG_ID
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
                    ) X, 
                    EDP_MANAGER.MS_REG_BERKAS Y
                WHERE
                    X.REG_ID = Y.REG_ID (+)
                    AND X.REG_ID = '" . $reg_id . "'
                ORDER BY X.RNUM ASC
            ";

            $query = $this->oracle_db->query($sql);
            $row = $query->row();
            return $row;
    }

    function getBerkas() {
        $sql = "SELECT
                    A.BERKAS_ID, A.KETERANGAN
                FROM
                    EDP_MANAGER.MS_BERKAS A
                WHERE
                    A.SHOW_ITEM = '1'
        ";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getTransRegBerkas()
    {
        $sql = "SELECT  
                    'RB' || SUBSTR(TO_CHAR(EDP_MANAGER.SEQ_REG_BERKAS.nextval, '000000'),2) AS TRANS_ID
                FROM 
                    DUAL";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function savePinjamMR(
        $medrec,
        $nokar_peminjam,
        $keperluan,
        $dept_peminjam,
        $created_by,
        $diserahkan_oleh,
        $tgl_peminjaman,
        $tgl_janji_kembali,
        $trans_pinjam
    )
    {
        $sql = "INSERT INTO  EDP_MANAGER.PINJAM_MR
                    (
                        MR, 
                        NOKAR_PEMINJAM, 
                        KEPERLUAN, 
                        DEPT_PEMINJAM, 
                        CREATED_DATE, 
                        CREATED_BY, 
                        DISERAHKAN_OLEH, 
                        TGL_JANJI_KEMBALI, 
                        TRANS_PINJAM_MR,
                        TGL_PINJAM
                    )
                VALUES
                    (
                        '" . $medrec . "',
                        '" . $nokar_peminjam . "',
                        '" . $keperluan . "',
                        '" . $dept_peminjam . "',
                        SYSDATE,
                        '" . $created_by . "',
                        '" . $diserahkan_oleh . "',
                        TO_DATE('" . $tgl_janji_kembali . "','DD.MM.RRRR'),
                        '" . $trans_pinjam . "',                      
                        TO_DATE('" . $tgl_peminjaman . "','DD.MM.RRRR')
                    )
                ";
        $query = $this->oracle_db->query($sql);
    }
}